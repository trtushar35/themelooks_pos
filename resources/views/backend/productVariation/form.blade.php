@extends('backend.layouts.app')

@section('content')
<div class="container">
    <h2 class="mt-5 mb-4">{{ isset($product) ? 'Edit Product Variation' : 'Add New Product Variation' }}</h2>
    <form action="{{ isset($product) ? route('product-variation.update', $product->id) : route('product-variation.store') }}" method="POST">
        @csrf
        @if(isset($product))
            @method('PUT')
        @endif

        {{-- Dynamic Product Variations --}}
        <h5 class="mt-2 mb-2">Product Variations</h5>
        <div id="variation_container">
            <div class="row variation-row mb-2">
                <div class="col-md-2">
                    <select name="product_id" class="form-control variation-type-dropdown">
                        <option value="">Select Type</option>
                        @foreach ($products as $data)
                            <option value="{{ $data->id }}">{{ ucfirst($data->name) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="color" class="form-control" placeholder="Variation Type (e.g. Color)">
                </div>
                <div class="col-md-3">
                    <input type="text" name="variation_type[]" class="form-control" placeholder="Variation Type (e.g. Color/Size)">
                </div>
                <div class="col-md-3">
                    <input type="text" name="variation_value[]" class="form-control" placeholder="Variation Value (e.g. Red, Blue, Black/M, L, XL)">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm remove-variation mt-1">×</button>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-sm btn-secondary mb-3" onclick="addVariationRow()">+ Add More Variation</button>

        {{-- Submit --}}
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">{{ isset($product) ? 'Update Product' : 'Save Product' }}</button>
        </div>
    </form>
</div>

{{-- JS --}}
<script>
    function addVariationRow() {
        const variationRow = `
            <div class="row variation-row mb-2">
                <div class="col-md-3">
                    <input type="text" name="variation_type[]" class="form-control" placeholder="Variation Type">
                </div>
                <div class="col-md-3">
                    <input type="text" name="variation_value[]" class="form-control" placeholder="Variation Value">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm remove-variation mt-1">×</button>
                </div>
            </div>
        `;
        document.getElementById('variation_container').insertAdjacentHTML('beforeend', variationRow);
    }

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-variation')) {
            e.target.closest('.variation-row').remove();
        }
    });

    function previewImage(event) {
        const preview = document.getElementById('imagePreview');
        preview.src = URL.createObjectURL(event.target.files[0]);
        preview.style.display = 'block';
    }
</script>
@endsection
