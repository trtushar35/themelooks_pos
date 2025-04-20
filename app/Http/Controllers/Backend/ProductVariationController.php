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
        $productVariation = ProductVariation::all();
        return view('backend.productVariation.list', compact('productVariation'));
    }

    public function create()
    {
        $products = Product::all();
        return view('backend.productVariation.form', compact('products'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'variation_type.*' => 'required|string|max:255',
            'variation_value.*' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $productId = $request->product_id;
        $variationTypes = $request->variation_type;
        $variationValues = $request->variation_value;

        $skipped = [];

        foreach ($variationTypes as $index => $type) {
            $values = explode(',', $variationValues[$index]);

            foreach ($values as $rawValue) {
                $value = trim($rawValue);

                if (empty($value)) continue;

                $exists = ProductVariation::where('product_id', $productId)
                    ->where('variation_type', $type)
                    ->where('variation_value', $value)
                    ->exists();

                if ($exists) {
                    $skipped[] = "$type - $value";
                    continue;
                }

                ProductVariation::create([
                    'product_id' => $productId,
                    'variation_type' => $type,
                    'variation_value' => $value,
                ]);
            }
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

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function getVariationValues($type)
    {
        $values = ProductVariation::where('variation_type', $type)
            ->pluck('variation_value')
            ->unique()
            ->values();

        return response()->json($values);
    }
}
