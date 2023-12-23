<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function place_order(Request $request){
        // Check if 'cart' exists in the session
        if($request->session()->has('cart')){
            // Get input values from the request
            $name = $request->input('name');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $city = $request->input('city');
            $address = $request->input('address');
            
            // Get the current date
            $date = date('Y-m-d');
            
            // Set initial order status
            $status = 'not paid';
            
            // Get total cost from the session
            $cost = $request->session()->get('total');

            // Get cart items from the session
            $cart = $request->session()->get('cart');

            // Insert order details into the 'orders' table and get the order ID
            $order_id = DB::table('orders')->insertGetId([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'cost' => $cost,
                'date' => $date,
                'status' => $status,
                'city' => $city,
                'address' => $address
            ], 'id');

            // Insert order items into the 'order_items' table
            foreach ($cart as $id => $product){
                $product_id = $product['id'];
                $product_name = $product['name'];
                $product_image = $product['image'];
                $product_price = $product['price'];
                $product_quantity = $product['quantity'];
                
                // Insert product details into the 'order_items' table
                DB::table('order_items')->insert([
                    'order_id' => $order_id,
                    'order_date' => $date,
                    'product_id' => $product_id,
                    'product_name' => $product_name,
                    'product_image' => $product_image,
                    'product_price' => $product_price,
                    'product_quantity' => $product_quantity
                ]);
            }

            // Store order ID in session
            $request->session()->put('order_id', $order_id);

            // Redirect to the complete_payment view
            return view('payment');
        } else {
            // Redirect to the homepage if 'cart' doesn't exist in the session
            return redirect('/');
        }
    }

    public function payment () {
        // Display the complete_payment view
        return view('payment');
    }

    public function verify_payment (Request $request, $transaction_id) {
        $request->session()->put('transaction_id',$transaction_id);
        return redirect('/complete_payment');
    }

    public function complete_payment(Request $request)
    {
        // Check if both 'order_id' and 'transaction_id' are present in the session
        if ($request->session()->has('order_id') && $request->session()->has('transaction_id')) {
            // Retrieve 'order_id' and 'transaction_id' from the session
            $order_id = $request->session()->get('order_id');
            $transaction_id = $request->session()->get('transaction_id');
    
            // Set order status to 'paid' and get the current date
            $order_status = 'paid';
            $payment_date = date('Y-m-d');
    
            // Update the order status in the 'orders' table
            $affected = DB::table('orders')->where('id', $order_id)->update(['status' => $order_status]);
    
            // Insert payment details into the 'payments' table
            DB::table('payments')->insert([
                'order_id' => $order_id,
                'transaction_id' => $transaction_id,
                'date' => $payment_date
            ]);
    
            // Flush the session data
            $request->session()->flush();
    
            // Redirect to the thank you page with the 'order_id' in the session
            return redirect('/thank_you')->with('order_id', $order_id);
        } else {
            // Redirect to the home page if 'order_id' or 'transaction_id' is not present in the session
            return redirect('/');
        }
    }

    public function thank_you () {
        return view('/thank_you');
    }
}
