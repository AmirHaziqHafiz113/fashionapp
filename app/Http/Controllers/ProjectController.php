<?php

namespace App\Http\Controllers;
use Illuminate\Pagination\Paginator;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function index()
    {
        $products = DB::table('products')->limit(4)->get();
        $men_products = DB::table('products')->where('type', 'men')->limit(4)->get();

        return view('index', ['products' => $products, 'men_products' => $men_products]);
    }

    public function products()
    {
        $products = DB::table('products')->paginate(1);
        return view('products', ['products' => $products]);
    }

    public function newest()
    {
        $products = DB::table('products')->orderBy('id','desc')->paginate(1);
        return view('products', ['products' => $products]);
    }

    public function lowest_price()
    {
        $products = DB::table('products')->orderBy('price','asc')->paginate(1);
        return view('products', ['products' => $products]);
    }

    public function highest_price()
    {
        $products = DB::table('products')->orderBy('price','desc')->paginate(1);
        return view('products', ['products' => $products]);
    }

    public function men()
    {
        $products = DB::table('products')->where('type', 'men')->paginate(4);
        return view('products', ['products' => $products]);
    }

    public function women()
    {
        $products = DB::table('products')->where('type', 'women')->paginate(4);
        return view('products', ['products' => $products]);
    }


}
