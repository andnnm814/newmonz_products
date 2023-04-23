<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $products = Product::paginate(20);
        // dd($products);
        $data = [
            "products" => $products,
        ];
        return view("products.index", $data);
        // $product = Product::first();
        // dd($product);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = new Product();
        $data = ['product' => $product];
        return view('products.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product();
        $product->category_id = $request->category_id;
        $product->maker = $request->maker;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->save();

        return redirect(route('products.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product :どの商品を表示するのかの対象オブジェクト
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $data = ['product' => $product];
        return view('products.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $data = ['product' => $product];
        return view('products.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->maker = $request->maker;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->save();
        return redirect(route('products.show', $product));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect(route('products.index'));
    }

    public function search(Request $request)
    {
        // $requestに保持された値を取得
        $category_id = $request->category_id;
        $keyword = $request->keyword;
        $min_price = (int)$request->min_price;
        $max_price = (int)$request->max_price;
        // dd($min_price, $max_price);
        $sort = $request->sort;
        // dd($sort);
        $page = $request->page;
        // if($page == NULL){
        //     $page = 1;
        // }
        
        // DBからデータを取得
        $query = Product::query();

        // カテゴリー検索
        if(!empty($category_id)) {
            $query->where('category_id', '=', $category_id);
        }

        // キーワード検索
        if(!empty($keyword)) {
            $query->where(function($query) use($keyword){
                $query->where('maker', 'LIKE', '%'.$keyword.'%')
                ->orWhere('name', 'LIKE', '%'.$keyword.'%');
            });
        }

        // 価格検索
        if(!empty($min_price) and !empty($max_price)){
            $query
                ->where('price', '>=', $min_price)
                ->where('price', '<=', $max_price);
        }
        elseif(!empty($min_price)) {
            $query->where('price', '>=', $min_price);
        }
        elseif(!empty($max_price)) {
            $query->where('price', '<=', $max_price);
        }

        // 並び順
        if (!empty($sort) && $sort == "price_asc") {
            $query->orderBy("price", "asc");
        } elseif (!empty($sort) && $sort == "price_desc") {
            $query->orderBy("price", "desc");
        }

        $products = $query->paginate(20);
        // dd($products);

        $data = [
            "products" => $products,
        ];        

        return view("products.index", $data);
    }

    // 山下さん
    // public function search($request) {
    //     $categoryId = $request->category_id;
    //     $keyword = $request->keyword;
    //     $minPrice = $request->min_price;
    //     $maxPrice = $request->max_price;
    //     $sort = $request->sort;

    //     $productQuery = Product::query();
    //     if (!empty($categoryId)) {
    //         $productQuery->where("category_id", $categoryId);
    //     }
    //     if (!empty($keyword)) {
    //         $productQuery->where(function($productQuery) use($keyword) {
    //             $productQuery
    //                 ->where("maker", "LIKE", "%{$keyword}%")
    //                 ->orWhere("name", "LIKE", "%{$keyword}%");
    //         });
    //     }
    //     if (!empty($minPrice) and !empty($maxPrice)) {
    //         $productQuery
    //             ->where("price", ">=", $minPrice)
    //             ->where("price", "<=", $maxPrice);
    //     } else if (!empty($minPrice)) {
    //         $productQuery->where("price", ">=", $minPrice);
    //     } else if (!empty($maxPrice)) {
    //         $productQuery->where("price", "<=", $maxPrice);
    //     }
    //     if (!empty($sort) and $sort == "price_asc") {
    //         $productQuery->orderBy("price", "asc");
    //     } else if (!empty($sort) and $sort == "price_desc") {
    //         $productQuery->orderBy("price", "desc");
    //     }
    //     $products = $productQuery->paginate(17);

    //     return $products;
    // }

}