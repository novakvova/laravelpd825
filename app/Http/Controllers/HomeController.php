<?php

namespace App\Http\Controllers;

use App\News;
use App\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::where('discount', '>', 0)->paginate(3);
        $news=News::all()->sortByDesc('created_at')->take(4);

        return view('home',compact('products','news'));
    }
}
