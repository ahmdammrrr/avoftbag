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
        .status-box { background: #000; color: #fff; padding: 20px; text-align: center; margin: 30px 0; }
        .status-box span { display: block; font-size: 12px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; color: #999; margin-bottom: 5px; }
        .status-box strong { font-size: 24px; text-transform: uppercase; letter-spacing: 1px; }
        .tracking-box { border: 2px dashed #e5e5e5; padding: 20px; text-align: center; margin-bottom: 30px; }
        .tracking-box span { display: block; font-size: 12px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; color: #666; margin-bottom: 10px; }
        .tracking-box strong { font-size: 18px; font-family: monospace; letter-spacing: 2px; }
        .footer { margin-top: 40px; font-size: 12px; color: #999; text-align: center; text-transform: uppercase; letter-spacing: 1px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">AEROBAG.</div>
        
        <h1>Order Update</h1>
        
        <p>Hi {{ $order->user->name }},</p>
        <p>There's an update regarding your order <strong>#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong>.</p>

        <div class="status-box">
            <span>Current Status</span>
            <strong>{{ $order->status }}</strong>
        </div>

        @if($order->tracking_number)
        <div class="tracking-box">
            <span>Tracking Number</span>
            <strong>{{ $order->tracking_number }}</strong>
        </div>
        <p>You can use this tracking number on our courier partner's website to trace your package.</p>
        @endif

        <p>Thank you for shopping with us!</p>
        
        <div class="footer">
            &copy; {{ date('Y') }} AEROBAG. All rights reserved.
        </div>
    </div>
</body>
</html>
