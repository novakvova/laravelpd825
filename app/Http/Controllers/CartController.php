<?php

namespace App\Http\Controllers;

use App\Product;
use Cookie;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Order;
use App\OrderProduct;
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
        $user = auth()->user()->getAuthIdentifier();
        $cook = Cookie::get('cook');
        $array = collect(json_decode($cook, true));
        $prods_id = collect([]);
        foreach ($array as $arr)
        {
            if($arr["user_id"]==$user)
            {
                $prods_id->push($arr["id"]);
            }
        }

        $items = collect([]);
        foreach ($prods_id as $id) {
            $prod = Product::find($id);
            
            $items->push($prod);
        }
        return view('cart.index', compact('items'));
    }

    public function addCartProduct($id)
    {
        $user = auth()->user()->getAuthIdentifier();
        $cook = Cookie::get('cook');
        $array = collect(json_decode($cook, true));
        if (is_null($array))
            $array = collect([]);
        $array->push(['id' => $id, 'user_id' => $user]);
        $newCook = json_encode($array);
        return redirect('/cart')->withCookie(cookie()->forever('cook', $newCook));
    }

    public function deleteCartProduct($id)
    {
        //json_encode($languages);
        //json_decode(,true);
        $user = auth()->user()->getAuthIdentifier();
        $cook = Cookie::get('cook');
        $array = collect(json_decode($cook, true));
        $temp=$array->map(function ($item, $key) use($id) {
            if($item['id']==$id)
                return $key;
        });
        $key=$temp->filter(function ($value) { return !is_null($value); })->first();
        $array->forget($key);
        $newCook = json_encode($array);

        return redirect('/cart')->withCookie(cookie()->forever('cook', $newCook));
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'productId'=>'required',
            'productCount'=>'required'
        ]);
        $user = auth()->user()->getAuthIdentifier();
        $ids=$request-> get("productId");
        $counts=$request-> get("productCount");
        $prodsCount = count($ids);

        $order = new Order([
            'user_id' => $user
        ]);
        $order->save();
        for($i=0;$i<$prodsCount;$i++)
        {
            $orderProd=new OrderProduct([
                'order_id'=>$order->id,
                'product_id'=>$ids[$i],
                'quantity'=>$counts[$i]
            ]);
            $orderProd->save();
            $product = Product::find($ids[$i]);
            $newCount=$product->count-$counts[$i];
            $product->count=$newCount;
            $product->save();
        }
        $arr=collect([]);
        $newCook = json_encode($arr);
        //return redirect('/cart')->with('success', 'Замовлення успішно збережено!')->withCookie(cookie()->forever('cook', $newCook));
        return redirect('/cart')->withCookie(cookie()->forever('cook', $newCook));

    }
    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
