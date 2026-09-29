<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</title>
    <style>
        body { font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; text-align: center; color: #000; margin: 0; padding: 0; }
        body h1 { font-weight: 300; margin-bottom: 0px; padding-bottom: 0px; color: #000; }
        body h3 { font-weight: 300; margin-top: 10px; margin-bottom: 20px; font-style: italic; color: #555; }
        body a { color: #000; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; font-size: 14px; line-height: 24px; color: #000; }
        .header { margin-bottom: 40px; text-transform: uppercase; border-bottom: 2px solid #000; padding-bottom: 20px; display: table; width: 100%; }
        .header-left { display: table-cell; text-align: left; vertical-align: bottom; }
        .header-right { display: table-cell; text-align: right; vertical-align: bottom; }
        .logo { font-size: 32px; font-weight: bold; letter-spacing: -1px; }
        
        .info-section { display: table; width: 100%; margin-bottom: 40px; text-align: left; }
        .info-col { display: table-cell; width: 50%; }
        .info-col p { margin: 0; }
        .info-title { font-weight: bold; text-transform: uppercase; font-size: 11px; color: #666; letter-spacing: 1px; margin-bottom: 5px; }
        
        .items-table { width: 100%; line-height: inherit; text-align: left; border-collapse: collapse; margin-bottom: 40px; }
        .items-table th { padding: 10px; background: #000; color: #fff; font-weight: bold; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; }
        .items-table td { padding: 15px 10px; border-bottom: 1px solid #eee; }
        .items-table td.item-name { font-weight: bold; text-transform: uppercase; }
        .items-table td.right { text-align: right; }
        
        .total-section { display: table; width: 100%; text-align: right; border-top: 2px solid #000; padding-top: 15px; }
        .total-row { display: table-row; }
        .total-label { display: table-cell; font-weight: bold; text-transform: uppercase; font-size: 12px; padding-bottom: 10px; padding-right: 20px; }
        .total-val { display: table-cell; font-weight: normal; padding-bottom: 10px; width: 120px; }
        .grand-total .total-label { font-size: 14px; }
        .grand-total .total-val { font-size: 18px; font-weight: bold; }
        
        .footer { margin-top: 50px; text-align: center; color: #888; font-size: 10px; text-transform: uppercase; letter-spacing: 1px; }
    </style>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=2">
</head>
<body>
    <div class="invoice-box">
        <div class="header">
            <div class="header-left">
                <div class="logo">AVOFTBAG.</div>
            </div>
            <div class="header-right">
                <span style="font-size: 24px; font-weight: bold;">INVOICE</span><br>
                #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}<br>
                Date: {{ $order->created_at->format('M d, Y') }}
            </div>
        </div>

        <div class="info-section">
            <div class="info-col">
                <div class="info-title">Billed To:</div>
                <p>
                    <strong>{{ $order->user->name }}</strong><br>
                    {{ $order->user->email }}<br>
                    {{ $order->shipping_address }}
                </p>
            </div>
            <div class="info-col" style="text-align: right;">
                <div class="info-title">Payment Info:</div>
                <p>
                    Status: <strong style="text-transform: uppercase;">{{ $order->status }}</strong><br>
                    Method: <span style="text-transform: uppercase;">{{ $order->payment_method }}</span>
                </p>
            </div>
        </div>

        @php
            $subtotal = 0;
            foreach($order->items as $item) {
                $subtotal += ($item->price * $item->quantity);
            }
            $shipping_fee = $order->total_price - $subtotal;
            
            $shipping_region = 'Standard Shipping';
            if ($shipping_fee == 10) {
                $shipping_region = 'Semenanjung Malaysia';
            } elseif ($shipping_fee == 15) {
                $shipping_region = 'Sabah & Sarawak';
            }
        @endphp

        <table class="items-table">
            <thead>
                <tr>
                    <th>Item Description</th>
                    <th style="text-align: center;">Qty</th>
                    <th class="right">Price</th>
                    <th class="right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td class="item-name">{{ $item->product->name }}</td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td class="right">RM {{ number_format($item->price, 2) }}</td>
                    <td class="right">RM {{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <div class="total-row">
                <div class="total-label">Subtotal</div>
                <div class="total-val">RM {{ number_format($subtotal, 2) }}</div>
            </div>
            <div class="total-row">
                <div class="total-label">Shipping ({{ $shipping_region }})</div>
                <div class="total-val">RM {{ number_format($shipping_fee, 2) }}</div>
            </div>
            <div class="total-row grand-total">
                <div class="total-label">Grand Total</div>
                <div class="total-val">RM {{ number_format($order->total_price, 2) }}</div>
            </div>
        </div>

        <div class="footer">
            Thank you for shopping with AVOFTBAG.<br>
            If you have any questions concerning this invoice, contact hello@avoftbag.com.
        </div>
    </div>
</body>
</html>
