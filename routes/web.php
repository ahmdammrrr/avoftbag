<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function (Illuminate\Http\Request $request) {
    $query = Product::query();
    
    if ($request->has('search') && $request->search != '') {
        $query->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
    }
    
    $products = $query->get();
    return view('welcome', compact('products'));
})->name('home');

Route::get('/product/{id}', [App\Http\Controllers\ProductController::class, 'show'])->name('product.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    $cart = session()->get('cart', []);
    $orders = auth()->user()->orders()->with('items.product')->orderBy('created_at', 'desc')->get();
    return view('dashboard', compact('cart', 'orders'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/checkout/success', [App\Http\Controllers\OrderController::class, 'success'])->name('checkout.success');
Route::get('/checkout/cancel', [App\Http\Controllers\OrderController::class, 'cancel'])->name('checkout.cancel');
Route::post('/checkout', [App\Http\Controllers\OrderController::class, 'checkout'])->middleware('auth')->name('checkout');
Route::post('/order/{order}/pay', [App\Http\Controllers\OrderController::class, 'payPendingOrder'])->middleware('auth')->name('order.pay');
Route::post('/order/{order}/cancel', [App\Http\Controllers\OrderController::class, 'cancelOrder'])->middleware('auth')->name('order.cancel');
Route::get('/order/{order}/invoice', [App\Http\Controllers\OrderController::class, 'invoice'])->middleware('auth')->name('order.invoice');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/order/{id}/update', [App\Http\Controllers\AdminController::class, 'updateOrderStatus'])->name('order.update');
    
    Route::get('/users', [App\Http\Controllers\AdminController::class, 'usersIndex'])->name('users.index');
    Route::delete('/users/{user}', [App\Http\Controllers\AdminController::class, 'usersDestroy'])->name('users.destroy');
    
    Route::resource('products', App\Http\Controllers\AdminProductController::class)->except(['show']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
});

require __DIR__.'/auth.php';
