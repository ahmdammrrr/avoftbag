<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 1.6; color: #000; margin: 0; padding: 0; background-color: #f9f9f9; }
        .container { max-width: 600px; margin: 40px auto; background: #fff; padding: 40px; border: 1px solid #e5e5e5; }
        .logo { font-size: 24px; font-weight: 900; letter-spacing: -1px; text-transform: uppercase; margin-bottom: 30px; }
        h1 { font-size: 20px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        p { margin-bottom: 20px; color: #333; }
        .order-details { margin: 30px 0; border: 1px solid #e5e5e5; }
        .detail-row { display: flex; justify-content: space-between; padding: 15px; border-bottom: 1px solid #e5e5e5; font-size: 14px; }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { font-weight: bold; text-transform: uppercase; letter-spacing: 1px; color: #666; font-size: 12px; }
        .detail-value { font-weight: bold; text-transform: uppercase; }
        .total-row { background: #000; color: #fff; }
        .total-row .detail-label { color: #ccc; }
        .footer { margin-top: 40px; font-size: 12px; color: #999; text-align: center; text-transform: uppercase; letter-spacing: 1px; }
    </style>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=2">
</head>
<body>
    <div class="container">
        <div class="logo">AVOFTBAG. Admin</div>
        
        <h1>New Order Received</h1>
        
        <p>A new order has been placed by <strong>{{ $order->user->name }}</strong>.</p>

        <div class="order-details">
            <div class="detail-row">
                <span class="detail-label">Order Number</span>
                <span class="detail-value">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Customer Email</span>
                <span class="detail-value">{{ $order->user->email }}</span>
            </div>
            
            @foreach($order->items as $item)
            <div class="detail-row" style="background-color: #fcfcfc;">
                <span class="detail-label" style="text-transform: none;">{{ $item->product->name }} x{{ $item->quantity }}</span>
                <span class="detail-value">RM {{ number_format($item->price * $item->quantity, 2) }}</span>
            </div>
            @endforeach
            
            <div class="detail-row">
                <span class="detail-label">Shipping Address</span>
                <span class="detail-value" style="text-align: right; max-width: 250px;">{{ $order->shipping_address }}</span>
            </div>
            <div class="detail-row total-row">
                <span class="detail-label">Total Amount</span>
                <span class="detail-value">RM {{ number_format($order->total_price, 2) }}</span>
            </div>
        </div>
        
        <p>Please log in to the admin dashboard to update the order tracking number once it is shipped.</p>
        
        <div class="footer">
            &copy; {{ date('Y') }} AVOFTBAG. All rights reserved.
        </div>
    </div>
</body>
</html>
