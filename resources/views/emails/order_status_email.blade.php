<!DOCTYPE html>
<html>
<head>
    <title>Order Status Update</title>
</head>
<body>
    <h1>Order Status Update</h1>
    <p>Dear {{ $order->address->name }},</p>
    <p>Your order with ID {{ $order->order_no }} status has been updated to <strong>"{{ $data['order_status'] }}"</strong>.</p>
    <p>Your tracking ID would be {{$data['comment']}}.</p>
    <p>Thank you for shopping with us!</p>
</body>
</html>
