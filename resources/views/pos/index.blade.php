@include('top')

<div class="container">
    <h2>Point of Sale (POS)</h2>

    <!-- Success message -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Products List -->
    <h3>Available Products</h3>
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-3">
                <div class="card">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="{{ $product->product_name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->product_name }}</h5>
                        <p class="card-text">Price: ${{ number_format($product->price, 2) }}</p>
                        <button class="btn btn-primary add-to-cart" data-id="{{ $product->id }}" data-name="{{ $product->product_name }}" data-price="{{ $product->price }}">Add to Cart</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Cart Section -->
    <h3>Cart</h3>
    <form action="{{ route('pos.store') }}" method="POST" id="transaction-form">
        @csrf
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="cart-items">
                <!-- Cart items will be appended here -->
            </tbody>
        </table>
        <div class="text-end">
            <strong>Total: $<span id="total-price">0.00</span></strong>
        </div>
        <button type="submit" class="btn btn-success mt-3" id="submit-btn" disabled>Complete Transaction</button>
    </form>
</div>

@push('scripts')
<script>
    // Initialize cart array
    let cart = [];

    // Function to update cart UI
    function updateCart() {
        const cartItemsContainer = document.getElementById('cart-items');
        const totalPriceElement = document.getElementById('total-price');
        let cartItemsHtml = '';
        let totalPrice = 0;

        cart.forEach((item, index) => {
            cartItemsHtml += `
                <tr>
                    <td>${item.name}</td>
                    <td>$${item.price.toFixed(2)}</td>
                    <td>
                        <input type="number" class="form-control quantity" value="${item.quantity}" data-index="${index}" min="1">
                    </td>
                    <td>$${(item.price * item.quantity).toFixed(2)}</td>
                    <td><button class="btn btn-danger remove-item" data-index="${index}">Remove</button></td>
                </tr>
            `;
            totalPrice += item.price * item.quantity;
        });

        cartItemsContainer.innerHTML = cartItemsHtml;
        totalPriceElement.textContent = totalPrice.toFixed(2);

        // Enable/disable submit button based on cart size
        document.getElementById('submit-btn').disabled = cart.length === 0;
    }

    // Add product to cart
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            const productName = this.getAttribute('data-name');
            const productPrice = parseFloat(this.getAttribute('data-price'));

            // Check if the product already exists in the cart
            const existingItemIndex = cart.findIndex(item => item.id === productId);

            if (existingItemIndex >= 0) {
                // Update quantity of existing item
                cart[existingItemIndex].quantity += 1;
            } else {
                // Add new item to cart
                cart.push({ id: productId, name: productName, price: productPrice, quantity: 1 });
            }

            // Update the cart UI
            updateCart();
        });
    });

    // Update quantity of items in the cart
    document.getElementById('cart-items').addEventListener('change', function(event) {
        if (event.target && event.target.classList.contains('quantity')) {
            const index = event.target.getAttribute('data-index');
            const newQuantity = parseInt(event.target.value, 10);

            if (newQuantity > 0) {
                cart[index].quantity = newQuantity;
            } else {
                cart.splice(index, 1);
            }

            updateCart();
        }
    });

    // Remove item from the cart
    document.getElementById('cart-items').addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('remove-item')) {
            const index = event.target.getAttribute('data-index');
            cart.splice(index, 1);
            updateCart();
        }
    });

    // When the form is submitted, add the cart data to the request
    document.getElementById('transaction-form').addEventListener('submit', function(event) {
        event.preventDefault();

        const cartData = cart.map(item => ({
            product_id: item.id,
            quantity: item.quantity
        }));

        // You can pass cartData to the server (via AJAX or form submission)
        fetch('{{ route("pos.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="_token"]').getAttribute('content')
            },
            body: JSON.stringify({ cart: cartData })
        })
        .then(response => response.json())
        .then(data => {
            // Handle success
            alert('Transaction completed!');
            cart = [];  // Clear the cart
            updateCart();  // Update the cart UI
        })
        .catch(error => {
            // Handle failure
            alert('Transaction failed.');
        });
    });
</script>

@include('bottom')
