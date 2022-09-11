<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller
{
    public function products(){
        $products = Product::latest()->paginate(5);

        return view('products', compact('products'));
    }

    public function addProduct(Request $request){
        $request->validate(
            [
             'name'=> 'required|unique:products',
             'price'=> 'required',
            ],
            [
                'name.required' => 'Name is Required',
                'name.unique' => 'Product Allreay Exists',
                'price.required' => 'Price is Required',
            ]
        );

        $product = new Product();
        $product->name  = $request->name;
        $product->price = $request->price;

        $product->save();

        return response()->json([
            'status'=> 'success', 
            'message' => 'Successfully Product Added',
        ]);
    }

    // update

    public function updateProduct(Request $request){
        $request->validate(
            [
             'u_name'=> 'required|unique:products,name,'.$request->u_id,
             'u_price'=> 'required',
            ],
            [
                'u_name.required' => 'Name is Required',
                'u_name.unique' => 'Product Allreay Exists',
                'u_price.required' => 'Price is Required',
            ]
        );

       Product::where('id', $request->u_id)->update([
          'name' => $request->u_name,
          'price' => $request->u_price,
       ]);

        return response()->json([
            'status'=> 'success', 
            'message' => 'Successfully Product Updated',
        ]);
    }

    public function deleteProduct(Request $request){

        Product::find($request->product_id)->delete();
        return response()->json([
            'status'=> 'success', 
            'message' => 'Successfully Product Deleated',
        ]);
    }

    public  function pagination(){
        $products = Product::latest()->paginate(5);
        return view('paginate_products', compact('products'))->render();
    }
    public  function searchProduct(Request $request){
        $products = Product::where('name', 'like', '%'.$request->search_string.'%')
        ->orWhere('price', 'like', '%'.$request->search_string.'%')
        ->orderBy('id', "DESC")
        ->paginate(5);

        if($products->count() >=1 ){
            return view('paginate_products', compact('products'))->render();
        }else{
            return response()->json([
                'status'=> 'not_found', 
                'message' => 'Not Found',
            ]);
        }
    }
}
