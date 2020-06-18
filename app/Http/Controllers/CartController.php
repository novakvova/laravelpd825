<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\CartProduct;
use function GuzzleHttp\Promise\all;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=auth()->user()->getAuthIdentifier();
        $items = CartProduct::all()->only(['product','quantity']);

        return view('carts.index', compact('items'));
    }

    public function addCartProduct($id)
    {
        $user=auth()->user()->getAuthIdentifier();
        $cart=Cart::where('user_id','=',$user);
        $cartProduct = new CartProduct([
            'cart_id' => $cart->id,
            'product_id' => $id,
            'quantity'=>1
        ]);
        $cartProduct->save();

        return redirect('/products')->with('success', 'Продукт успішно додано в кошик!');
    }

    public function deleteCartProduct($id)
    {
        $user=auth()->user()->getAuthIdentifier();
        $cart=Cart::where('user_id','=',$user);
        $cartProduct = new CartProduct([
            'cart_id' => $cart->id,
            'product_id' => $id,
            'quantity'=>1
        ]);
        $cartProduct->save();

        return redirect('/products')->with('success', 'Продукт успішно додано в кошик!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
