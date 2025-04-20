<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::whereNull('deleted_at')->latest()->get();
        return view('backend.products.list', compact('products'));
    }

    public function create()
    {
        return view('backend.products.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|numeric|unique:products,sku',
            'unit' => 'required',
            'unit_value' => 'required',
            'selling_price' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'tax' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload if exists
        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->storeAs('uploads/products', $filename, 'public');
        }

        // Create the product
        Product::create([
            'name' => $request->name,
            'sku' => $request->sku,
            'unit' => $request->unit,
            'unit_value' => $request->unit_value,
            'selling_price' => $request->selling_price,
            'purchase_price' => $request->purchase_price,
            'discount' => $request->discount ?? 0,
            'tax' => $request->tax ?? 0,
            'image' => $imagePath,
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        return view('backend.products.form', compact('product'));
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|numeric',
            'unit' => 'required',
            'unit_value' => 'required',
            'selling_price' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'tax' => 'nullable|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->unit = $request->unit;
        $product->unit_value = $request->unit_value;
        $product->selling_price = $request->selling_price;
        $product->purchase_price = $request->purchase_price;
        $product->discount = $request->discount ?? 0;
        $product->tax = $request->tax ?? 0;

        if ($request->hasFile('image')) {
            if ($product->image && Storage::exists('public/' . $product->image)) {
                Storage::delete('public/' . $product->image);
            }

            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        if ($product->image && Storage::exists($product->image)) {
            Storage::delete($product->image);
        }

        $product->update([
            'status' => 'Deleted',
            'deleted_at' => now(),
        ]);

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
