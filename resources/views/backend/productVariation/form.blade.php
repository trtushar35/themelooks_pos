@extends('backend.layouts.app')

@section('content')
<div class="container">
    <h2 class="mt-2 mb-4">{{ isset($variation) ? 'Edit Product Variation' : 'Add New Product Variation' }}</h2>
    <form action="{{ isset($variation) ? route('product-variation.update', $variation->id) : route('product-variation.store') }}" method="POST">
        @csrf
        @if(isset($variation))
            @method('PUT')
        @endif

        {{-- Product Variations --}}
        <div id="variation_container">
            <div class="row variation-row mb-2">
                <div class="col-md-2">
                    <label for="product_id" class="form-label">Product Name</label>
                    <select name="product_id" id="product_id" class="form-control" required>
                        <option value="">Select Product</option>
                        @foreach ($products as $data)
                            <option value="{{ $data->id }}" {{ isset($variation) && $variation->product_id == $data->id ? 'selected' : '' }}>
                                {{ ucfirst($data->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="color" class="form-label">Color</label>
                    <input type="text" name="color" id="color" class="form-control" placeholder="e.g. Red"
                    value="{{ old('color', $variation->color ?? '') }}" >
                </div>

                <div class="col-md-2">
                    <label for="variation_type" class="form-label">Variation Type</label>
                    <input type="text" name="variation_type" id="variation_type" class="form-control" placeholder="e.g. Size/Weight"
                        value="{{ old('variation_type', $variation->variation_type ?? '') }}" required>
                </div>

                <div class="col-md-2">
                    <label for="variation_value" class="form-label">Variation Value</label>
                    <input type="text" name="variation_value" id="variation_value" class="form-control"
                        value="{{ old('variation_value', $variation->variation_value ?? '') }}" required
                        placeholder="{{ isset($variation) ? '' : 'e.g. M, L, XL' }}">
                </div>
                
                <div class="col-md-2">
                    <label for="purchase_price" class="form-label">Purchase Price</label>
                    <input type="text" name="purchase_price" id="purchase_price" class="form-control"
                        value="{{ old('purchase_price', $variation->purchase_price ?? '') }}" required
                        placeholder="{{ isset($variation) ? '' : '100' }}">
                </div>
                
                <div class="col-md-2">
                    <label for="selling_price" class="form-label">Selling Price</label>
                    <input type="text" name="selling_price" id="selling_price" class="form-control"
                        value="{{ old('selling_price', $variation->selling_price ?? '') }}" required
                        placeholder="{{ isset($variation) ? '' : '110' }}">
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">{{ isset($variation) ? 'Update' : 'Submit' }}</button>
        </div>
    </form>
</div>
@endsection
