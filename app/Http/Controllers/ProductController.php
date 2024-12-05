<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Summary of getProductsByParam
     * Return an array of products based on parameters provided (category or collection).
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getProductsByParam(Request $request){
        
        $result = Product::when($request->category, function ($query, $category) {
            return $query->where('category', $category);
        })->when($request->collection, function ($query, $collection) {
            return $query->where('collection', $collection);
        })->get();

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
    public function getXNumOfProducts(Request $request){
        $numEach = $request->input('num');

        $categories = ['coasters', 'planters', 'candles', 'clocks', 'jewelry'];

        $products = [];

        if($numEach === null){
            foreach ($categories as $category) {
                $products[$category] = Product::where('category', $category)
                    ->orderByDesc('id')
                    ->get();
            }
        }else{
            foreach ($categories as $category) {
                $products[$category] = Product::where('category', $category)
                    ->limit($numEach)
                    ->orderByDesc('id')
                    ->get();
            }
        }
        
        return response()->json([
            'status' => 'successful',
            'data' => $products
        ], 200);
    }
}
