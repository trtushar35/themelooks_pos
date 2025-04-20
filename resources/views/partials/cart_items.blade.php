@if (!empty($cart))
    @foreach ($cart as $id => $item)
        <div class="cart-item" data-id="{{ $id }}">
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
