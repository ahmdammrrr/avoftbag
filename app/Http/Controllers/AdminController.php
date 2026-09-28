<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusUpdated;
use App\Models\Notification;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $orders = Order::with('items.product', 'user')->orderBy('created_at', 'desc')->get();
        $products = Product::all();
        return view('admin.dashboard', compact('orders', 'products'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->tracking_number = $request->tracking_number;
        $order->save();

        try {
            Mail::to($order->user->email)->send(new OrderStatusUpdated($order));
        } catch (\Exception $e) {
            \Log::error('Mail sending failed: ' . $e->getMessage());
        }

        // Create in-app notification for Customer
        $orderNum = '#' . str_pad($order->id, 5, '0', STR_PAD_LEFT);
        $statusMsg = ucfirst($request->status);
        $message = 'Your order ' . $orderNum . ' status has been updated to ' . $statusMsg . '.';
        
        if ($request->tracking_number) {
            $message .= ' Tracking: ' . $request->tracking_number;
        }

        Notification::create([
            'user_id' => $order->user_id,
            'title' => 'Order Updated',
            'message' => $message,
            'type' => 'order_updated',
            'order_id' => $order->id,
        ]);

        return back()->with('success', 'Order updated successfully!');
    }

    public function usersIndex()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function usersDestroy(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot delete an admin user.');
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }
}
