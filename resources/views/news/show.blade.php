@extends('layouts.app')

@section('content')

    <div class="d-flex container mt-5 flex-column">
        <div class="d-flex justify-content-center">
            <img src="{{'/images/840_'.$news->image}}" style="object-fit: contain;border-radius: 20px" />
        </div>

        <h1 class="single-product-name mt-4">{{$news->title}}</h1>
        <div class="product-info">{!! $news->description !!}</div>
    </div>



@endsection


