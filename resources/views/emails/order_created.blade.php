<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Confirmado</title>
</head>

<body>
    <h2>Olá, {{ $order->customer->name }}!</h2>
    <p>Seu pedido foi recebido com sucesso.</p>
    <p>Detalhes do pedido:</p>
    @if ($order->products)
        <ul>
            @foreach ($order->products as $product)
                <li>{{ $product->name }} - R$ {{ number_format($product->price, 2, ',', '.') }}</li>
            @endforeach
        </ul>
    @endif

    <p>Obrigado por comprar conosco!</p>
</body>

</html>
