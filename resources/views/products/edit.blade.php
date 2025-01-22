@include('top')

<div class="card p-5">
    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Product Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Product Name:</label>
            <input type="text" name="name" id="name" value="{{ $product->name }}" class="form-control" required>
        </div>

        <!-- Price -->
        <div class="mb-3">
            <label for="price" class="form-label">Price:</label>
            <input type="number" name="price" id="price" value="{{ $product->price }}" class="form-control" step="0.01" required>
        </div>

        <!-- Stock Quantity -->
        <div class="mb-3">
            <label for="stock_qty" class="form-label">Stock Quantity:</label>
            <input type="number" name="stock_qty" id="stock_qty" value="{{ $product->stock_qty }}" class="form-control" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
</div>

@include('bottom')
