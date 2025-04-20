<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductVariationController extends Controller
{
    public function index()
    {
        $productVariation = ProductVariation::whereNull('deleted_at')->get();
        return view('backend.productVariation.list', compact('productVariation'));
    }

    public function create()
    {
        $products = Product::whereNull('deleted_at')->get();
        return view('backend.productVariation.form', compact('products'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'variation_type' => 'required|string|max:255',
            'variation_value' => 'required|string|max:255',
            'color' => 'nullable',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $productId = $request->product_id;
        $variationType = $request->variation_type;
        $variationValues = $request->variation_value;
        $color = $request->color;
        $purchasePrice = $request->purchase_price;
        $sellingPrice = $request->selling_price;

        $varValues = array_map('trim', explode(',', $variationValues));
        $skipped = [];

        $varValues = array_map('trim', explode(',', $variationValues));

        foreach ($varValues as $value) {
            if (empty($value)) continue;

            $exists = ProductVariation::where('product_id', $productId)
                ->where('variation_type', $variationType)
                ->where('variation_value', $value)
                ->exists();

            if ($exists) {
                $skipped[] = $value;
                continue;
            }

            ProductVariation::create([
                'product_id' => $productId,
                'variation_type' => $variationType,
                'variation_value' => $value,
                'color' => $color,
                'purchase_price' => $purchasePrice,
                'selling_price' => $sellingPrice,
            ]);
        }

        if (count($skipped)) {
            return redirect()->back()->with('warning', 'Some variations already existed and were skipped: ' . implode(', ', $skipped));
        }

        return redirect()->route('product-variation.index')->with('success', 'Product variations saved successfully.');
    }


    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $variation = ProductVariation::findOrFail($id);
        $products = Product::all();

        return view('backend.productVariation.form', compact('variation', 'products'));
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'variation_type' => 'required|string|max:255',
            'variation_value' => 'required|string|max:255',
            'color' => 'nullable',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $variation = ProductVariation::findOrFail($id);

        $variation->update([
            'product_id' => $request->product_id,
            'variation_type' => $request->variation_type,
            'variation_value' => $request->variation_value,
            'color' => $request->color,
            'purchase_price' => $request->purchase_price,
            'selling_price' => $request->selling_price,
        ]);

        return redirect()->route('product-variation.index')->with('success', 'Product variation updated successfully.');
    }


    public function destroy(string $id)
    {
        $variation = ProductVariation::findOrFail($id);
        $variation->update([
            'status' => 'Deleted',
            'deleted_at' => now(),
        ]);

        return redirect()->route('product-variation.index')->with('success', 'Product variation deleted successfully.');
    }
}
