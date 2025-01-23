@include('top')

<div class="container">
    <h2>Transaction Detail</h2>

    <!-- Success message -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Products List -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Tipe Mutasi</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody id="cart-items">
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->mutation_type }}</td>
                    <td>{{ $item->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@push('scripts')

@include('bottom')
