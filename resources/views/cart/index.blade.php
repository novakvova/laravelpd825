@extends('base')

@section('main')
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <div class="row">
        <div class="col-sm-12">

            @if(session()->get('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
        </div>
        <div class="col-sm-12" id="cart">
            <h1 class="display-3">Cart</h1>
            <div class="container mb-4">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Available</th>
                                    <th scope="col" class="text-center">Quantity</th>
                                    <th scope="col" class="text-right">Price</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $item)
                                    <tr id="{{$item->id}}">
                                        <td><img src="/images/105_{{$item->productImages[0]->name}}" width="75"></td>
                                        <td>{{$item->name}}</td>
                                        @if($item->count>=1)
                                            <td>In stock</td>
                                            <td style="width: 100px"><input onchange="NumberOnClick(this)"
                                                                            class="form-control" type="number" min="1"
                                                                            max="{{$item->count}}" value="1"/></td>
                                        @else
                                            <td>Not in stock</td>
                                            <td style="width: 100px"><input class="form-control" disabled type="number"
                                                                            min="1"
                                                                            max="2" value="0"/></td>
                                        @endif
                                        <td class="text-right">{{$item->price}}</td>
                                        <td class="text-right">
                                            <form action="/cart/deleteProduct/{{$item->id}}"
                                                  method="post">
                                                @csrf
                                                <button class="btn btn-sm btn-danger" type="submit"><i
                                                        class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                {{--                                <tr>--}}
                                {{--                                    <td></td>--}}
                                {{--                                    <td></td>--}}
                                {{--                                    <td></td>--}}
                                {{--                                    <td></td>--}}
                                {{--                                    <td>Sub-Total</td>--}}
                                {{--                                    <td class="text-right">255,90 €</td>--}}
                                {{--                                </tr>--}}
                                {{--                                <tr>--}}
                                {{--                                    <td></td>--}}
                                {{--                                    <td></td>--}}
                                {{--                                    <td></td>--}}
                                {{--                                    <td></td>--}}
                                {{--                                    <td>Shipping</td>--}}
                                {{--                                    <td class="text-right">6,90 €</td>--}}
                                {{--                                </tr>--}}
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><strong>Total</strong></td>
                                    <td class="text-right"><strong id="total">{{$items->sum('price')}}</strong></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col mb-2">
                        <div class="row">
                            <div class="col-sm-12  col-md-6">
                                <a href="{{ route('products.index')}}" class="btn btn-block btn-light">Continue
                                    Shopping</a>
                            </div>
                            <div class="col-sm-12 col-md-6 text-right">
                                <form id="create" method="post" action="{{ route('cart.store') }}">
                                    @csrf
                                    @if($items->contains('count',0))
                                        <button data-toggle="tooltip" data-placement="top" disabled title="One of products not in stock"
                                                class="btn btn-lg btn-secondary text-uppercase">Make order
                                        </button>
                                    @else

                                        <input type="hidden" id="ids"/>
                                        <input type="hidden" id="counts"/>
                                        <button type="submit" id="upload"
                                                class="btn btn-lg btn-block btn-success text-uppercase">Make order
                                        </button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function NumberOnClick(event) {
            let tot = document.getElementById('total');
            let price=event.parentNode.nextElementSibling.innerHTML;
            tot.innerText = parseInt(tot.innerText) + (parseInt(event.value)*price);
            console.log(parent);
        }
    </script>
    <script>
        let counts = $("#counts");
        let ids = $("#ids");
        (function ($) {
            $(document).ready(function () {
                let button = $('#upload');
                button.on('click', function () {
                    let trs = $("tbody tr").not(":last");
                    trs.each(function () {
                        let id = $(this).prop('id');
                        let count = $(this).find('input[type=number]')[0].value;
                        counts.append('<input type="hidden" name="productId[]" value="' + id + '">');
                        ids.append('<input type="hidden" name="productCount[]" value="' + count + '">');
                        console.log(id);
                        console.log(count);
                    })
                });
            });
        })(jQuery);
    </script>
@endsection

