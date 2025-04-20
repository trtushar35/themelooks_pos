<?php

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($request->quantity > $product->sku) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough stock available. Only ' . $product->sku . ' left.'
            ], 400);
        }

        $cart = session()->get('cart', []);
        $id = $product->id;

        if (isset($cart[$id])) {
            $newQuantity = $cart[$id]['quantity'] + $request->quantity;
            if ($newQuantity > $product->sku) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot add more than available stock. Only ' . $product->sku . ' left.'
                ], 400);
            }
            $cart[$id]['quantity'] = $newQuantity;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->selling_price,
                'quantity' => $request->quantity,
                'max_quantity' => $product->sku,
                'image' => $product->image,
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'cart' => $cart
        ]);
    }

    public function updateCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0'
        ]);

        $cart = session()->get('cart', []);
        $id = $request->product_id;

        if ($request->quantity == 0) {
            unset($cart[$id]);
        } else {
            $product = Product::findOrFail($id);
            
            if ($request->quantity > $product->sku) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot add more than available stock. Only ' . $product->sku . ' left.'
                ], 400);
            }

            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = $request->quantity;
                $cart[$id]['max_quantity'] = $product->sku;
                $cart[$id]['image'] = $product->image;
            }
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'cart' => $cart
        ]);
    }

    public function getCartView()
    {
        $cart = session()->get('cart', []);
        $cartHtml = view('partials.cart_items', compact('cart'))->render();
        $totalItems = array_sum(array_column($cart, 'quantity'));
        $totalAmount = array_sum(array_map(function($item) { 
            return $item['price'] * $item['quantity']; 
        }, $cart));

        return response()->json([
            'cartHtml' => $cartHtml,
            'totalItems' => $totalItems,
            'totalAmount' => $totalAmount
        ]);
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'payment_method' => 'required',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Cart is empty.');
        }

        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if (!$product || $product->sku < $item['quantity']) {
                return back()->with('error', 'Product "' . $item['name'] . '" is no longer available in the requested quantity.');
            }
        }

        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'customer_name' => $request->name,
            'customer_address' => $request->address,
            'payment_method' => $request->payment_method,
            'subtotal' => array_sum(array_map(function($item) { 
                return $item['price'] * $item['quantity']; 
            }, $cart)),
            'total' => array_sum(array_map(function($item) { 
                return $item['price'] * $item['quantity']; 
            }, $cart)),
            'status' => 'completed',
        ]);

        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            
            $order->items()->create([
                'product_id' => $id,
                'product_name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'total' => $item['price'] * $item['quantity'],
            ]);

            $product->sku -= $item['quantity'];
            $product->save();
        }

        session()->forget('cart');
        
        return redirect()->back()->with('success', 'Order #' . $order->order_number . ' placed successfully!');
    }
}
