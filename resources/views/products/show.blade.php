<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Product</title>
</head>
<body>
    <h1>{{ $product->product_name }}</h1>
    <p>Price: ${{ $product->price }}</p>
    <p>Stock Quantity: {{ $product->stock_quantity }}</p>
    <a href="{{ route('products.index') }}">Back to Product List</a>
</body>
</html>
