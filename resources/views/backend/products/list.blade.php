@extends('backend.layouts.app')

@section('content')
    <div class="container">
        <h2 class="mt-2 mb-4">Product List</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add New Product</a>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>S/N</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Unit</th>
                    <th>Unit Value</th>
                    <th>Selling Price</th>
                    <th>Purchase Price</th>
                    <th>Discount (%)</th>
                    <th>Tax (%)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if ($product->image)
                                <img src="{{ $product->image ?? '' }}" alt="Image" width="60">
                            @else
                                <span class="text-muted">No image</span>
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->unit }}</td>
                        <td>{{ $product->unit_value }}</td>
                        <td>{{ $product->selling_price }}</td>
                        <td>{{ $product->purchase_price }}</td>
                        <td>{{ $product->discount }}</td>
                        <td>{{ $product->tax }}</td>
                        <td>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Are you sure you want to delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center">No products found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
