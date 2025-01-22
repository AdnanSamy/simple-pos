@include('top')

<a class="btn btn-primary m-2" href="{{ route('products.create') }}">Create New Product</a>
<div class="card p-5">
    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Product Name:</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price:</label>
            <input type="number" name="price" id="price" class="form-control" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="stock_qty" class="form-label">Stock Quantity:</label>
            <input type="number" name="stock_qty" id="stock_qty" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Product</button>
    </form>
</div>

@include('bottom')
