<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminOrderNotification;
use App\Mail\OrderPlaced;
use App\Models\Notification;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'region' => 'required|in:semenanjung,sabah_sarawak'
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }

        $subtotal = 0;
        $line_items = [];

        foreach ($cart as $id => $item) {
            $subtotal += $item['price'] * $item['quantity'];
            
            // Add to Stripe line items
            $line_items[] = [
                'price_data' => [
                    'currency' => 'myr',
                    'product_data' => [
                        'name' => $item['name'],
                    ],
                    'unit_amount' => intval($item['price'] * 100), // in cents
                ],
                'quantity' => $item['quantity'],
            ];
        }

        $shipping_fee = $request->region === 'semenanjung' ? 10 : 15;
        $total_price = $subtotal + $shipping_fee;

        // Add shipping fee as a line item
        $line_items[] = [
            'price_data' => [
                'currency' => 'myr',
                'product_data' => [
                    'name' => 'Shipping Fee (' . ($request->region === 'semenanjung' ? 'Semenanjung' : 'Sabah/Sarawak') . ')',
                ],
                'unit_amount' => intval($shipping_fee * 100), // in cents
            ],
            'quantity' => 1,
        ];

        // 1. Create Pending Order in Database
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $total_price,
            'shipping_address' => $request->address,
            'status' => 'pending' // Still pending until Stripe confirms
        ]);

        foreach ($cart as $id => $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $details['quantity'],
                'price' => $details['price']
            ]);
        }

        // 2. Initialize Stripe
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        // 3. Create Stripe Checkout Session
        try {
            $checkout_session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card', 'fpx'], // Enable card and FPX
                'line_items' => $line_items,
                'mode' => 'payment',
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.cancel'),
                'metadata' => [
                    'order_id' => $order->id,
                ],
            ]);

            // Redirect to Stripe's hosted checkout page
            return redirect()->away($checkout_session->url);
            
        } catch (\Exception $e) {
            return back()->with('error', 'Stripe Error: ' . $e->getMessage());
        }
    }

    public function success(Request $request)
    {
        $session_id = $request->query('session_id');

        if (!$session_id) {
            return redirect()->route('dashboard')->with('error', 'Invalid Session ID');
        }

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        
        try {
            $session = \Stripe\Checkout\Session::retrieve([
                'id' => $session_id,
                'expand' => ['payment_intent.payment_method'],
            ]);
            
            if ($session->payment_status === 'paid') {
                $order_id = $session->metadata->order_id;
                $order = Order::findOrFail($order_id);
                
                // Get Payment Method Type ('card', 'fpx', etc)
                $paymentMethod = $session->payment_intent->payment_method->type ?? 'fpx';
                
                // Update Order Status and Payment Method
                $order->status = 'paid';
                $order->payment_method = $paymentMethod;
                $order->save();

                // Deduct stock
                foreach ($order->items as $item) {
                    $product = $item->product;
                    if ($product) {
                        $product->stock = max(0, $product->stock - $item->quantity);
                        $product->save();
                    }
                }

                // Clear the cart
                session()->forget('cart');

                // Send Email Notification to Customer
                try {
                    Mail::to($order->user->email)
                        ->send(new OrderPlaced($order));
                } catch (\Exception $e) {
                    \Log::error('Customer mail sending failed: ' . $e->getMessage());
                }

                // Send Email Notification to Admin
                try {
                    Mail::to('jairex0601@gmail.com')
                        ->send(new AdminOrderNotification($order));
                } catch (\Exception $e) {
                    \Log::error('Admin mail sending failed: ' . $e->getMessage());
                }

                // Create in-app notification for Admin
                $admins = User::where('role', 'admin')->get();
                $orderNum = '#' . str_pad($order->id, 5, '0', STR_PAD_LEFT);
                foreach ($admins as $admin) {
                    Notification::create([
                        'user_id' => $admin->id,
                        'title' => 'New Paid Order',
                        'message' => 'New paid order ' . $orderNum . ' from ' . $order->user->name . ' (RM ' . number_format($order->total_price, 2) . ')',
                        'type' => 'order_placed',
                        'order_id' => $order->id,
                    ]);
                }

                // Create in-app notification for Customer
                Notification::create([
                    'user_id' => $order->user_id,
                    'title' => 'Payment Successful',
                    'message' => 'Your payment for order ' . $orderNum . ' has been confirmed. We will process your order soon!',
                    'type' => 'order_placed',
                    'order_id' => $order->id,
                ]);

                return redirect()->route('dashboard')->with('success', 'Payment successful! Your order has been placed.');
            }
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Stripe Verification Error: ' . $e->getMessage());
        }

        return redirect()->route('dashboard')->with('error', 'Payment not verified.');
    }

    public function cancel()
    {
        return redirect()->route('cart.index')->with('error', 'Payment was cancelled. You can try again.');
    }

    public function payPendingOrder(Order $order)
    {
        // Ensure user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return back()->with('error', 'This order cannot be paid.');
        }

        // Build Stripe line items from order items
        $line_items = [];
        $items_total = 0;

        foreach ($order->items as $item) {
            $line_items[] = [
                'price_data' => [
                    'currency' => 'myr',
                    'product_data' => [
                        'name' => $item->product->name,
                    ],
                    'unit_amount' => intval($item->price * 100),
                ],
                'quantity' => $item->quantity,
            ];
            $items_total += $item->price * $item->quantity;
        }

        // Calculate shipping fee (difference between total and items)
        $shipping_fee = $order->total_price - $items_total;
        if ($shipping_fee > 0) {
            $line_items[] = [
                'price_data' => [
                    'currency' => 'myr',
                    'product_data' => [
                        'name' => 'Shipping Fee',
                    ],
                    'unit_amount' => intval($shipping_fee * 100),
                ],
                'quantity' => 1,
            ];
        }

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $checkout_session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card', 'fpx'],
                'line_items' => $line_items,
                'mode' => 'payment',
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('dashboard'),
                'metadata' => [
                    'order_id' => $order->id,
                ],
            ]);

            return redirect()->away($checkout_session->url);

        } catch (\Exception $e) {
            return back()->with('error', 'Stripe Error: ' . $e->getMessage());
        }
    }

    public function cancelOrder(Order $order)
    {
        // Ensure user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return back()->with('error', 'Only pending orders can be cancelled.');
        }

        $order->status = 'cancelled';
        $order->save();

        // Notify Admin about cancellation
        $admins = User::where('role', 'admin')->get();
        $orderNum = '#' . str_pad($order->id, 5, '0', STR_PAD_LEFT);
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'Order Cancelled',
                'message' => 'Order ' . $orderNum . ' has been cancelled by ' . $order->user->name,
                'type' => 'order_cancelled',
                'order_id' => $order->id,
            ]);
        }

        return back()->with('success', 'Order ' . $orderNum . ' has been cancelled.');
    }

    public function invoice(Order $order)
    {
        // Ensure user owns this order or is admin
        if ($order->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        if ($order->status === 'pending' || $order->status === 'cancelled') {
            return back()->with('error', 'Invoice is only available for paid orders.');
        }

        $pdf = Pdf::loadView('pdf.invoice', compact('order'));
        return $pdf->download('invoice-' . str_pad($order->id, 5, '0', STR_PAD_LEFT) . '.pdf');
    }
}
