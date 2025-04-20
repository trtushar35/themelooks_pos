<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Themelooks</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">MyWebsite</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>

                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/dashboard') }}">Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-light py-5">
        <div class="container">
            <div class="row">

                <!-- Left: Product Cards (col-8) -->
                <div class="col-md-8">
                    <div class="row">
                        @for ($i = 1; $i <= 12; $i++)
                            <div class="col-md-3 mb-4">
                                <div class="card shadow-sm h-100">
                                    <img src="https://via.placeholder.com/150x150" class="card-img-top"
                                        alt="Product {{ $i }}">
                                    <div class="card-body p-3 text-center">
                                        <h5 class="card-title mb-2">Product {{ $i }}</h5>

                                        <!-- Price Section with Discount -->
                                        @php
                                            $hasDiscount = rand(0, 1); // Randomly simulate if the product has a discount
                                            $originalPrice = 39.99;
                                            $discountedPrice = 29.99;
                                        @endphp

                                        <div class="d-flex justify-content-between align-items-center">
                                            @if ($hasDiscount)
                                                <!-- Discounted Price on Left -->
                                                <span
                                                    class="text-success h5">${{ number_format($discountedPrice, 2) }}</span>

                                                <!-- Original Price (Struck-through) on Right -->
                                                <span
                                                    class="text-muted text-decoration-line-through">${{ number_format($originalPrice, 2) }}</span>
                                            @else
                                                <span
                                                    class="text-muted h5">${{ number_format($originalPrice, 2) }}</span>
                                            @endif
                                            <a href="#" class="btn btn-sm btn-primary">Add to Cart</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Right: Checkout (col-4) -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5>Checkout</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <p><strong>Total Items:</strong> 3</p>
                                <p><strong>Total Amount:</strong> $89.97</p>
                            </div>
                            <h6 class="mb-3">Shipping Details</h6>
                            <form>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name"
                                        placeholder="Enter your name">
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Shipping Address</label>
                                    <textarea class="form-control" id="address" rows="3" placeholder="Enter your address"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="payment" class="form-label">Payment Method</label>
                                    <select class="form-select" id="payment">
                                        <option value="credit">Credit Card</option>
                                        <option value="paypal">PayPal</option>
                                        <option value="bank">Bank Transfer</option>
                                    </select>
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-success">Proceed to Payment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>





    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        &copy; 2025 MyWebsite. All rights reserved.
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
