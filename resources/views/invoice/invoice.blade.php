<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; color: #333; }
        .header { border-bottom: 2px solid #1669B3; padding-bottom: 10px; margin-bottom: 20px; }
        .brand { color: #1669B3; font-size: 24px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; background: #f4f4f4; padding: 10px; }
        td { padding: 10px; border-bottom: 1px solid #eee; }
        .total { text-align: right; font-size: 18px; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="brand">PROTRIXX LEARN</div>
        <p>Invoice #{{ $order->id }}<br>Date: {{ $order->created_at->format('d M Y') }}</p>
    </div>

    <h3>Purchased Past Papers</h3>
    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->order_items as $item)
                <tr>
                    <td>{{ $item->paper->title ?? 'Resource Item' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>KES {{ number_format($item->price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        Total Paid: KES {{ number_format($order->total_amount, 2) }}
    </div>
</body>
</html>
