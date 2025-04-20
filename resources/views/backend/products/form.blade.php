@extends('backend.layouts.app')

@section('content')
    <div class="container">
        <h2 class="mt-5 mb-4">{{ isset($product) ? 'Edit Product' : 'Add New Product' }}</h2>
        <form action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @if (isset($product))
                @method('PUT')
            @endif

            {{-- Basic Product Details --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Product Name *</label>
                    <input type="text" name="name" class="form-control" required
                        value="{{ old('name', $product->name ?? '') }}">
                </div>
                <div class="col-md-6">
                    <label for="sku" class="form-label">Product SKU *</label>
                    <input type="number" name="sku" class="form-control" required
                        value="{{ old('sku', $product->sku ?? '') }}">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="unit" class="form-label">Unit *</label>
                    <input type="text" name="unit" class="form-control" required
                        value="{{ old('unit', $product->unit ?? '') }}">
                </div>
                <div class="col-md-4">
                    <label for="unit_value" class="form-label">Unit Value *</label>
                    <input type="text" name="unit_value" class="form-control" required
                        value="{{ old('unit_value', $product->unit_value ?? '') }}">
                </div>
                <div class="col-md-4">
                    <label for="image" class="form-label">Product Image</label>
                    <input type="file" name="image" class="form-control" onchange="previewImage(event)">
                    <img id="imagePreview"
                        src="{{ isset($product) && $product->image ? $product->image : '#' }}"
                        style="max-width: 200px; height: auto; {{ isset($product) && $product->image ? '' : 'display:none;' }}">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Selling Price *</label>
                    <input type="number" name="selling_price" step="0.01" class="form-control" required
                        value="{{ old('selling_price', $product->selling_price ?? '') }}">
                </div>
                <div class="col-md-4">
                    <label>Purchase Price *</label>
                    <input type="number" name="purchase_price" step="0.01" class="form-control" required
                        value="{{ old('purchase_price', $product->purchase_price ?? '') }}">
                </div>
                <div class="col-md-2">
                    <label>Discount (%)</label>
                    <input type="number" name="discount" step="0.01" class="form-control"
                        value="{{ old('discount', $product->discount ?? 0) }}">
                </div>
                <div class="col-md-2">
                    <label>Tax (%)</label>
                    <input type="number" name="tax" step="0.01" class="form-control"
                        value="{{ old('tax', $product->tax ?? 0) }}">
                </div>
            </div>

            {{-- Submit --}}
            <div class="mt-4">
                <button type="submit"
                    class="btn btn-primary">{{ isset($product) ? 'Update Product' : 'Save Product' }}</button>
            </div>
        </form>
    </div>

    {{-- JS --}}
    <script>
        function previewImage(event) {
            const preview = document.getElementById('imagePreview');
            preview.src = URL.createObjectURL(event.target.files[0]);
            preview.style.display = 'block';
        }
    </script>
@endsection
