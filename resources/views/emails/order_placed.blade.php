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
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th { text-align: left; padding: 10px 0; border-bottom: 1px solid #e5e5e5; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: #666; }
        td { padding: 15px 0; border-bottom: 1px solid #e5e5e5; vertical-align: top; }
        .total-row td { font-weight: bold; border-top: 2px solid #000; border-bottom: none; font-size: 16px; text-transform: uppercase; }
        .footer { margin-top: 40px; font-size: 12px; color: #999; text-align: center; text-transform: uppercase; letter-spacing: 1px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">AVOFTBAG.</div>
        
        <h1>Order Confirmation</h1>
        
        <p>Hi {{ $order->user->name }},</p>
        <p>Thank you for your purchase! We've received your order <strong>#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong> and we're getting it ready for shipment.</p>

        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th style="text-align: right;">Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td style="text-transform: uppercase; font-weight: bold;">{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td style="text-align: right;">RM {{ number_format($item->price, 2) }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="2">Total</td>
                    <td style="text-align: right;">RM {{ number_format($order->total_price, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div style="background: #f9f9f9; padding: 20px; border: 1px solid #e5e5e5; margin-bottom: 30px;">
            <p style="margin:0; font-size: 12px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; color:#666;">Shipping Address:</p>
            <p style="margin: 10px 0 0 0; text-transform: uppercase; font-size: 14px;">{{ $order->shipping_address }}</p>
        </div>

        <p>We will notify you again once your order has been shipped. If you have any questions, simply reply to this email.</p>
        
        <div class="footer">
            &copy; {{ date('Y') }} AVOFTBAG. All rights reserved.
        </div>
    </div>
</body>
</html>
