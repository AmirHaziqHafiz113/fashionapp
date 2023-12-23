<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ProjectController::class,"index"]);

Route::get('/products',[ProjectController::class,"products"])->name('products');

Route::get('/shop_detail', function () {
    return view('shop_detail');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/newest',[ProjectController::class,"newest"])->name('newest');

Route::get('/lowest_price',[ProjectController::class,"lowest_price"])->name('lowest_price');

Route::get('/highest_price',[ProjectController::class,"highest_price"])->name('highest_price');

Route::get('/men',[ProjectController::class,"men"])->name('men');

Route::get('/women',[ProjectController::class,"women"])->name('women');

Route::get('/cart',[CartController::class,"cart"])->name('cart');

Route::post('/add_to_cart',[CartController::class,"add_to_cart"])->name('add_to_cart');
Route::post('/remove_from_cart',[CartController::class,"remove_from_cart"])->name('remove_from_cart');

Route::get('/remove_from_cart',function(){
    return redirect('/index');
});


Route::get('/add_to_cart',function(){
    return view('index');
});

Route::post('/edit_product_quantity',[CartController::class,"edit_product_quantity"])->name('edit_product_quantity');

Route::get('/edit_product_quantity',function(){
    return redirect('/index');
});

Route::post('/edit_product_quantity',[CartController::class,"edit_product_quantity"])->name('edit_product_quantity');

Route::get('/checkout',[CartController::class,"checkout"])->name('checkout');

Route::post('/place_order',[OrderController::class,"place_order"])->name('place_order');
Route::get('/place_order',function(){
    return redirect('/');
});

Route::post('/payment',[OrderController::class,"payment"])->name('payment');

Route::get('/complete_payment/{transaction_id}',[OrderController::class,"complete_payment"])->name('complete_payment');

Route::get('/verify_payment',[OrderController::class,"verify_payment"])->name('verify_payment');

Route::get('/thankyou',[OrderController::class,"thankyou"])->name('thankyou');
