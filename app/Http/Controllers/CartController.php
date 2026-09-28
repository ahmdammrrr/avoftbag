<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('cart', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $quantityToAdd = $request->input('quantity', 1);
        $cart = session()->get('cart', []);

        $currentCartQty = isset($cart[$product->id]) ? $cart[$product->id]['quantity'] : 0;
        $totalRequested = $currentCartQty + $quantityToAdd;

        if ($totalRequested > $product->stock) {
            return redirect()->back()->with('error', 'Cannot add more items. Only ' . $product->stock . ' left in stock.');
        }

        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantityToAdd;
        } else {
            $cart[$product->id] = [
                "id" => $product->id,
                "name" => $product->name,
                "quantity" => $quantityToAdd,
                "price" => $product->price,
                "image_path" => $product->image_path
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return redirect()->back()->with('success', 'Product removed successfully');
        }
        return redirect()->back();
    }
}
