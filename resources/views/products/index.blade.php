@extends('layouts.app')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Products</h1>
</div>


<div class="card">
    <form action="{{route('product.index')}}" method="get" class="card-header">
        <div class="form-row justify-content-between">
            <div class="col-md-2">
                <input type="text" value="{{$title}}" name="title" placeholder="Product Title" class="form-control">
            </div>
            <div class="col-md-2">
                <select name="variant" id="" class="form-control">

                </select>
            </div>

            <div class="col-md-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Price Range</span>
                    </div>
                    <input type="text" value="{{$starting_price}}" name="price_from" aria-label="First name" placeholder="From" class="form-control">
                    <input type="text" value="{{$ending_price}}" name="price_to" aria-label="Last name" placeholder="To" class="form-control">
                </div>
            </div>
            <div class="col-md-2">
                <input type="date" name="date" placeholder="Date" value="{{$date}}" class="form-control">
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary float-right"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>

    <div class="card-body">
        <div class="table-response">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Variant</th>
                        <th width="150px">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @if($products)
                    @foreach($products as $key=>$product)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$product->title}}<br> Created at : {{ $product->created_at }}</td>
                        <td>{{$product->description}}</td>
                        <td>
                            @if($product->product_variants)
                            <dl class="row mb-0" style="height: 80px; overflow: hidden" id="variant">
                                @foreach($product->product_variants as $product_variant)
                                <dt class="col-sm-3 pb-0">
                                    {{$product_variant->variant}}
                                </dt>
                                <dd class="col-sm-9">
                                    <dl class="row mb-0">
                                        <dt class="col-sm-4 pb-0">Price : {{ number_format($product->product_variant_prices[$key]->price,2) }}</dt>
                                        <dd class="col-sm-8 pb-0">InStock : {{ number_format($product->product_variant_prices[$key]->stock,0) }}</dd>
                                    </dl>
                                </dd>
                                @endforeach
                            </dl>
                            @endif
                            <button onclick="$('#variant').toggleClass('h-auto')" class="btn btn-sm btn-link">Show more</button>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('product.edit', $product->id) }}" class="btn btn-success">Edit</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>

            </table>
        </div>

    </div>

    <div class="card-footer">
        <div class="row justify-content-between">
            <div class="col-md-6">
                <p>Showing{{' '.$products->firstItem()}} {{$products->firstItem()!=$products->lastItem() ? 'to '.$products->lastItem():''}} out of {{$products->total()}}</p>
            </div>
            <div class="col-md-2">
                {{$products->appends(['title'=>$title ?? '','price_from'=>$starting_price ?? '','price_to'=>$ending_price ?? '','date'=>$date ?? ''])->links()}}
            </div>
        </div>
    </div>
</div>

@endsection