<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Summary of getProductsByParam
     * Return an array of paginated products based on parameters provided (category or collection).
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getProductsByParam(Request $request){
        // $page = $request->input('page');

        // if($page === null){
        //     $page = 1;
        // }
        // dd(request('products'));

        $result = Product::when($request->category, function ($query, $category) {
            return $query->where('category', $category);
        })->when($request->collection, function ($query, $collection) {
            return $query->where('collection', $collection);
        })->orderByDesc('id')->paginate(28, ['*']);

        return response()->json([
            'status' => 'successful',
            'data' => $result
        ], 200);
    }


    /**
     * Summary of getProductFromEachCategory
     * takes the number of product to be fetched from each category and then returns the fetched products.
     * the number to be fetched is passed as aparameter in the url
     * @return void
     */
    public function getFeaturedProducts(Request $request){

        $categories = ['coasters', 'planters', 'candles', 'clocks', 'jewelry'];

        $products = [];

        $categorizedProductsCount = [];

        foreach ($categories as $category) {
            $products[$category] = Product::where('category', $category)
                ->limit(4)
                ->orderByDesc('id')
                ->get();
            
            $categorizedProductsCount[$category] = Product::where('category', $category)->count();
        }

        $result = [
            'products' => $products, 
            'productCount' => $categorizedProductsCount
        ];
        
        return response()->json([
            'status' => 'successful',
            'data' => $result
        ], 200);
    }


    public function getSingleProduct(Request $request){
        $category = $request->get('category');
        $collection = $request->get('collection');
        $product = $request->get('product');

        $result = Product::where('category', $category)
            ->where('collection', $collection)
            ->where('name', $product)
            ->first();

        $youCouldAlsoLike = Product::where('collection', $collection)
            ->orderByDesc('id')
            ->limit(4)
            ->get();

        if($result === null){
            $result = [];
        }

        if($youCouldAlsoLike === null){
            $youCouldAlsoLike = [];
        }
        
        return response()->json([
           'data' => $result,
           'youCouldAlsoLike' => $youCouldAlsoLike
        ]);
    }
}
