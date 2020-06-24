@extends('layouts.app')

@section('content')


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

            <h1 class="display-3">Керування продуктами</h1>
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
                                <h2 class=" mt-2 d-flex"
                                    style="position: absolute; width: 100%;justify-content: flex-end"><span
                                        class="mr-3 badge badge-danger badge-pill d-flex">{{$product->discount}}%</span>
                                </h2>
                                <img class="card-img-top" src="/images/420_{{$product->productImages[0]->name}}">
                                <div class="card-body">
                                    <h5 class="card-title bold" style="font-size: 25px;">{{$product->price}}</h5>
                                    <p class="card-text" style="font-size: 22px;">{{$product->name}}</p>
                                    {{--                                <a href="{{ route('products.edit',$product->id)}}" class="btn btn-primary">Edit</a>--}}
                                    <form action="{{ route('products.destroy', $product->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
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

@endsection
