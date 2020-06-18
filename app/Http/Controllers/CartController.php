<?php

namespace App\Http\Controllers;
use App\Product;
use Cookie;
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
        $cook = Cookie::get('cook');
        $array=json_decode($cook,true);
        $prods_id=$array->where('user_id',$user)->only(['id']);
        $items=collect([]);
        foreach ($prods_id as $id)
        {
            $prod=Product::find($id);
            $items->push($prod);
        }
        return view('carts.index', compact('items'));
    }

    public function addCartProduct($id)
    {
        $user=auth()->user()->getAuthIdentifier();
        $cook = Cookie::get('cook');
        $array=json_decode($cook,true);
        $array->push(['id' => $id, 'user_id' => $user]);
        $newCook=json_encode($array);
        return redirect('/products')->withCookie(cookie()->forever('cook', $newCook));
    }

    public function deleteCartProduct($id)
    {
        //json_encode($languages);
        //json_decode(,true);
        $user=auth()->user()->getAuthIdentifier();
        $cook = Cookie::get('cook');
        $array=json_decode($cook,true);
        $array->where('id',$id)->delete();
        $newCook=json_encode($array);

        return redirect('/products')->withCookie(cookie()->forever('cook', $newCook));
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
