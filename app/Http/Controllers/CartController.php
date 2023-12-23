<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cart()
    {
        return view('cart');
    }

    public function add_to_cart(Request $request)
    {
        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart');
        } else {
            $cart = [];
        }

        $id = $request->input('id');
        $name = $request->input('name');
        $image = $request->input('image');
        $price = $request->input('price');
        $quantity = $request->input('quantity');
        $sale_price = $request->input('sale_price');

        if ($sale_price !== null) {
            $price_to_charge = $sale_price;
        } else {
            $price_to_charge = $price;
        }

        if (!array_key_exists($id, $cart)) {
            $product_array = [
                'id' => $id,
                'name' => $name,
                'image' => $image,
                'price' => $price_to_charge,
                'quantity' => $quantity,
                'sale_price' => $sale_price,
            ];

            $cart[$id] = $product_array;
            $request->session()->put('cart', $cart);

            $this->calculateTotalCart($request);
        } else {
            echo '<script>alert("Product is already in cart");</script>';
        }

        return view('cart');
    }

    public function calculateTotalCart(Request $request)
    {
        $total_price = 0;
        $total_quantity = 0;
        $cart = $request->session()->get('cart');

        foreach ($cart as $product) {
            $price = $product['price'];
            $quantity = $product['quantity'];

            $total_price += $price * $quantity;
            $total_quantity += $quantity;
        }

        $request->session()->put('total', $total_price);
        $request->session()->put('quantity', $total_quantity);
    }

    public function remove_from_cart(Request $request)
    {
        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart');
            $product_id = $request->input('id');

            unset($cart[$product_id]);

            $request->session()->put('cart', $cart);

            $this->calculateTotalCart($request);
        }

        return view('cart');
    }

    public function edit_product_quantity(Request $request)
    {
        if ($request->session()->has('cart')) {
            $product_id = $request->input('id');
            $product_quantity = $request->input('quantity');
            $cart = $request->session()->get('cart');

            if (array_key_exists($product_id, $cart)) {
                $cart[$product_id]['quantity'] = $product_quantity;

                $request->session()->put('cart', $cart);

                $this->calculateTotalCart($request);
            }
        }

        return view('cart');
    }

    function checkout(){
        return view('checkout');
    }
}
