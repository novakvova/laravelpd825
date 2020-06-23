@extends('base')

@section('main')
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <div class="d-flex">
        <div style="flex-direction: row;color: white;position: absolute;align-self: center;display: flex;align-items: center;" class="ml-5">
            <img src="/images/logo.svg" style="height: 100px; width: 100px"/>
            <h1 style="font-size: 100px;">oo Store</h1>
        </div>

        <img src="/images/zhaba4k.jpg" style="width: 100%;object-fit: cover;">
    </div >
    <div class="container">


    <div class="row">
        <div class="col-sm-12">

            @if(session()->get('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
        </div>

        <div class="col-sm-12">

            <h1 class="display-3">Знижки:</h1>
            @guest
            @else
            <div>
                <a style="margin: 19px;" href="{{ route('products.create')}}" class="btn btn-primary">Додати продукт</a>
            </div>
            @endguest
            <div class="container">
                <div class="row">
                    @foreach($products as $product)
                        <a href="{{ route('products.show', $product->id)}}"
                           class="col-6 col-md-4 p-3"
                           style="
                                color: initial;
                                text-decoration: initial;
                        ">
                        <div class="card" style="width: 18rem;">
                                <h2 class=" mt-2 d-flex" style="position: absolute; width: 100%;justify-content: flex-end"><span class="mr-3 badge badge-danger badge-pill d-flex"  >{{$product->discount}}%</span></h2>
                                <img  class="card-img-top" src="/images/420_{{$product->productImages[0]->name}}" >
                            <div class="card-body">
                                <h5 class="card-title bold" style="font-size: 25px;">{{$product->price}}</h5>
                                <p class="card-text" style="font-size: 22px;">{{$product->name}}</p>
{{--                                <a href="{{ route('products.edit',$product->id)}}" class="btn btn-primary">Edit</a>--}}
{{--                                <form action="{{ route('products.destroy', $product->id)}}" method="post">--}}
{{--                                          @csrf--}}
{{--                                          @method('DELETE')--}}
{{--                                     <button class="btn btn-danger" type="submit">Delete</button>--}}
{{--                                </form>--}}
                            </div>
                        </div>
                        </a>
                    @endforeach
                </div>
            </div>


            <div class="mr-3" style="display: flex; justify-content: flex-end; margin-top: 25px">
                {!! $products->appends(['sort' => 'created_at'])->links() !!}
            </div>
        <div>
            <div class="col-sm-12">

                <h1 class="display-3">Новини:</h1>
                @guest
                @else
                    <div>
                        <a style="margin: 19px;" href="{{ route('news.create')}}" class="btn btn-primary">Додати новину</a>
                    </div>
                @endguest
                <div class="container">
                    <div class="row">
                        @foreach($news as $n)
                            <a href="{{ route('news.show', $n->id)}}"
                               class="col-12 col-md-6 p-3"
                               style="
                                color: initial;
                                text-decoration: initial;
                                width: 100%;
                        ">
                                <div class="card" style="width: 100%;">
                                    <img  class="card-img-top" src="/images/840_{{$n->image}}" >
                                    <div class="card-body">
                                        <h4 class="card-title bold">{{$n->title}}</h4>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div>
    </div>
            </div>
@endsection
