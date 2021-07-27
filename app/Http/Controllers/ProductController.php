<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\Paginator;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        // dd($request);
        $title = $request->title ?? null;
        $starting_price = $request->price_from ?? null;
        $ending_price = $request->price_to ?? null;
        $date = $request->date ?? null;
        DB::enableQueryLog();
        $query = Product::with('product_images', 'product_variants', 'product_variant_prices');

        if ($title) {
            $query = $query->where('title', 'like', '%' . $title . '%');
        }
        if ($starting_price) {
            $query = $query->whereHas('product_variant_prices', function ($query) use ($starting_price) {
                $query->where('price', '>=', $starting_price);
            });
        }

        if ($ending_price) {
            $query = $query->whereHas('product_variant_prices', function ($query) use ($ending_price) {
                $query->where('price', '<=', $ending_price);
            });
        }

        if ($date) {
            $query = $query->whereDate('created_at', '=', $date);
        }
        $products = $query->latest()->paginate(3);
        dd(DB::getQueryLog());
        return view('products.index')->with(['products' => $products, 'title' => $title, 'starting_price' => $starting_price, 'ending_price' => $ending_price, 'date' => $date]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $variants = Variant::all();
        return view('products.create', compact('variants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $variants = Variant::all();
        return view('products.edit', compact('variants', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
