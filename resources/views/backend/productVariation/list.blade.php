@extends('backend.layouts.app')

@section('content')
<div class="container">
    <h2 class="mt-5 mb-4">Product List</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('product-variation.create') }}" class="btn btn-primary mb-3">Add New Variation</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>S/N</th>
                <th>Variation Type</th>
                <th>Color</th>
                <th>Variation Value</th>
                <th>Purchase Price</th>
                <th>Selling Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($productVariation as $index => $product)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $product->variation_type ?? ''}}</td>
                <td>{{ $product->color ?? '' }}</td>
                <td>{{ $product->variation_value ?? '' }}</td>
                <td>{{ $product->purchase_price ?? '' }}</td>
                <td>{{ $product->selling_price ?? '' }}</td>
                <td>
                    <a href="{{ route('product-variation.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('product-variation.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="11" class="text-center">No variations found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
