@extends('backend.layouts.app')

@section('content')
    <div class="container">
        <h2 class="mt-5 mb-4">Product List</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add New Product</a>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>S/N</th>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Items</th>
                    <th>Payment</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $key => $order)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <strong>{{ $order->order_number }}</strong>
                            @if ($order->notes)
                                <i class="bi bi-chat-left-text text-primary" title="{{ $order->notes }}"></i>
                            @endif
                        </td>
                        <td>
                            {{ $order->customer_name }}<br>
                            <small class="text-muted">{{ $order->customer_phone }}</small>
                        </td>
                        <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                        <td>{{ $order->items->sum('quantity') }}</td>
                        <td>
                            <span
                                class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                        </td>
                        <td>৳{{ number_format($order->total, 2) }}</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">No orders found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
