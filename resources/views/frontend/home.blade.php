<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #dfe4eb;
        }

        .product-grid {
            max-height: 85vh;
            overflow-y: auto;
            padding-right: 10px;
        }

        .card-img-top {
            height: 100px;
            object-fit: contain;
        }

        .card-title {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .price-tag {
            font-size: 13px;
        }

        .checkout-card {
            position: sticky;
            top: 20px;
        }

        .cart-item {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }

        .quantity-control {
            display: flex;
            align-items: center;
        }

        .quantity-input {
            width: 50px;
            text-align: center;
            margin: 0 5px;
        }
    </style>
</head>

<body>

    @include('frontend.layouts.navbar')

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-9">
                <div class="mb-3">
                    <input type="text" id="searchInput" class="form-control"
                        placeholder="Search product by name or SKU">
                </div>

                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3 product-grid" id="productGrid">
                    @foreach ($products as $product)
                        <div class="col product-card">
                            <div class="card h-100 d-flex flex-column shadow-sm">
                                <img src="{{ $product->image ? $product->image : 'https://via.placeholder.com/150' }}"
                                    class="card-img-top" alt="{{ $product->name }}">

                                <div class="card-body text-center p-2 d-flex flex-column">
                                    <div class="card-title text-truncate">{{ $product->name }}</div>
                                    <div class="text-muted small">{{ $product->unit_value }} | SKU: {{ $product->sku }}
                                    </div>
                                    <div class="text-muted small">Stock: {{ $product->sku }}</div>

                                    @php
                                        $originalPrice = $product->selling_price;
                                        $discount = ($originalPrice * $product->discount) / 100;
                                        $final = $originalPrice - $discount;
                                    @endphp

                                    <div class="price-tag mt-1 mb-2">
                                        @if ($product->discount > 0)
                                            <span class="text-success fw-bold">${{ number_format($final, 2) }}</span>
                                            <span
                                                class="text-muted text-decoration-line-through small">${{ number_format($originalPrice, 2) }}</span>
                                        @else
                                            <span class="fw-bold">${{ number_format($originalPrice, 2) }}</span>
                                        @endif
                                    </div>

                                    <div class="mt-auto">
                                        <form method="POST" action="{{ route('cart.add') }}" class="add-to-cart-form">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-sm btn-outline-primary w-100">Add to cart</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-end mt-4">
                    {{ $products->links() }}
                </div>
            </div>

            <div class="col-md-3">
                <div class="card checkout-card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Checkout</h5>
                    </div>
                    <div class="card-body">
                        <div id="cart-items" style="max-height: 400px; overflow-y: auto;">
                            @if (session('cart'))
                                @foreach (session('cart') as $id => $item)
                                    <div class="cart-item border-bottom pb-2 mb-2" data-id="{{ $id }}">
                                        <div class="d-flex justify-content-between">
                                            <div class="me-3" style="width: 80px;">
                                                <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}"
                                                     class="img-fluid rounded">
                                            </div>
                                            <div>
                                                <strong>{{ $item['name'] }}</strong>
                                                <div>৳{{ number_format($item['price'], 2) }}</div>
                                            </div>
                                            <div class="quantity-control">
                                                <button class="btn btn-sm btn-outline-secondary decrement">-</button>
                                                <input type="number"
                                                       class="form-control form-control-sm quantity-input"
                                                       value="{{ $item['quantity'] }}" min="1"
                                                       max="{{ $item['max_quantity'] }}">
                                                <button class="btn btn-sm btn-outline-secondary increment">+</button>
                                            </div>
                                        </div>
                                        <div class="text-end mt-1">
                                            <strong>৳{{ number_format($item['price'] * $item['quantity'], 2) }}</strong>
                                            <button class="btn btn-sm btn-danger ms-2 remove-item">×</button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted">Your cart is empty</p>
                            @endif
                        </div>
                        

                        <div class="mt-3">
                            <div class="d-flex justify-content-between">
                                <strong>Total Items:</strong>
                                <span id="total-items">
                                    {{ array_sum(array_column(session('cart', []), 'quantity')) }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <strong>Subtotal:</strong>
                                <span id="total-amount">
                                    ৳{{ number_format(array_sum(array_map(function ($item) {return $item['price'] * $item['quantity'];}, session('cart', []))), 2) }}
                                </span>
                            </div>
                        </div>
                        
                        <h6 class="mt-4">Shipping Details</h6>
                        <form id="checkout-form" method="POST" action="{{ route('order.place') }}">
                            @csrf
                            <div class="mb-2">
                                <input type="text" name="name" class="form-control" placeholder="Full Name"
                                    required>
                            </div>
                            <div class="mb-2">
                                <textarea name="address" class="form-control" rows="2" placeholder="Address" required></textarea>
                            </div>
                            <div class="mb-3">
                                <select name="payment_method" class="form-select" required>
                                    <option value="">Select Payment</option>
                                    <option value="credit_card">Credit Card</option>
                                    <option value="paypal">PayPal</option>
                                    <option value="cash">Cash</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success w-100"
                                {{ empty(session('cart')) ? 'disabled' : '' }}>Proceed</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#searchInput').on('keyup', function() {
                let filter = $(this).val().toLowerCase();
                $('.product-card').each(function() {
                    let title = $(this).find('.card-title').text().toLowerCase();
                    $(this).toggle(title.includes(filter));
                });
            });

            $('.add-to-cart-form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        updateCart(response.cart);
                    },
                    error: function(xhr) {
                        alert(xhr.responseJSON.message || 'Error adding to cart');
                    }
                });
            });

            $(document).on('click', '.increment, .decrement', function() {
                let $input = $(this).siblings('.quantity-input');
                let newVal = parseInt($input.val()) + ($(this).hasClass('increment') ? 1 : -1);

                if (newVal >= 1 && newVal <= parseInt($input.attr('max'))) {
                    $input.val(newVal);
                    updateCartItem($input.closest('.cart-item').data('id'), newVal);
                }
            });

            $(document).on('change', '.quantity-input', function() {
                let newVal = parseInt($(this).val());
                let max = parseInt($(this).attr('max'));

                if (newVal >= 1 && newVal <= max) {
                    updateCartItem($(this).closest('.cart-item').data('id'), newVal);
                } else {
                    $(this).val($(this).data('current'));
                }
            });

            $(document).on('click', '.remove-item', function() {
                if (confirm('Remove this item from cart?')) {
                    updateCartItem($(this).closest('.cart-item').data('id'), 0);
                }
            });

            function updateCartItem(productId, quantity) {
                $.ajax({
                    url: '{{ route('cart.update') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId,
                        quantity: quantity
                    },
                    success: function(response) {
                        updateCart(response.cart);
                    },
                    error: function(xhr) {
                        alert(xhr.responseJSON.message || 'Error updating cart');
                    }
                });
            }

            function updateCart(cart) {
                $.get('{{ route('cart.view') }}', function(response) {
                    $('#cart-items').html(response.cartHtml);
                    $('#total-items').text(response.totalItems);
                    $('#total-amount').text(response.totalAmount.toFixed(2));
                    $('#checkout-form button[type="submit"]').prop('disabled', response.totalItems === 0);
                });
            }
        });
    </script>
</body>

</html>
