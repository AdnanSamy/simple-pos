@include('top')

<a class="btn btn-primary m-2" href="{{ route('products.create') }}">Create New Product</a>
<div class="card p-5">
    @if (session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Stock Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->stock_qty }}</td>
                    <td>
                        <a class="btn btn-warning" href="{{ route('products.edit', $product->id) }}">Edit</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button  class="btn btn-danger" type="submit">Delete</button>
                        </form>
                        <a class="btn btn-primary" href="{{ url('/products/mutasi/' . $product->id) }}">Mutasi</a>
                </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@include('bottom')
