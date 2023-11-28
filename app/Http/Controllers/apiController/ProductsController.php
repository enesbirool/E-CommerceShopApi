<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ProductsController extends Controller
{
    public function index(){
        $products=Product::paginate(10);
        if ($products){
            return response()->json($products,200);
        }else return response()->json(['message'=>'Product Not Found'],404);
    }


    public function show($id){
        $product=Product::find($id);
        if ($product){
            return response()->json($product,200);
        }else return response()->json(['message'=>'Product Not Found'],404);
    }


    public function store(Request $request){
        Validator::make($request->all(),[
           'name'=>'required',
            'price'=>'required|numeric',
            'category_id'=>'required|numeric',
            'brand_id'=>'required|numeric',
            'discount'=>'numeric',
            'amount'=>'required|numeric',
        ]);
        $product=new Product();
        $product->name=$request->name;
        $product->price=$request->price;
        $product->brand_id=$request->brand_id;
        $product->category_id=$request->category_id;
        $product->discount=$request->discount;
        $product->amount=$request->amount;

        if($request->hasFile('image')){

            $path='assets/uploads/product/' . $product->image;
            if (File::exists($path)){
                File::delete($path);
            }
            $file=$request->file('image');
            $ext=$file->getClientOriginalExtension();
            $filename=time() . '-' . $ext;
            try {
                $file->move('assets/uploads/product', $filename);
            }catch (FileException $e){
                dd($e);
            }
            $product->image=$filename;
        }
            $product->save();
            return response()->json(['message'=>'Product Added'],201);

    }


    public function update($id,Request $request)
    {

        Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|numeric',
            'brand_id' => 'required|numeric',
            'discount' => 'required|numeric',
            'amount' => 'required|numeric',
            'image' => 'required',
        ]);

        $product = Product::find($id);
        if ($product) {
            $product->name = $request->name;
            $product->price = $request->price;
            $product->brand_id = $request->brand_id;
            $product->category_id = $request->category_id;
            $product->discount = $request->discount;
            $product->amount = $request->amount;

            if ($request->hasFile('image')) {

                $path = 'assets/uploads/product/' . $product->image;
                if (File::exists($path)) {
                    File::delete($path);
                }
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = time() . '-' . $ext;
                try {
                    $file->move('assets/uploads/product', $filename);
                } catch (FileException $e) {
                    dd($e);
                }
                $product->image = $filename;
            }
            $product->save();
            return response()->json(['message' => 'Product Updated'], 201);
        }

        else return response()->json(['message' => 'Product Not Found'], 201);
    }


    public function destroy($id){

        $product=Product::find($id);
        if ($product){
            $product->delete();
            return response()->json(['message'=>'Product Deleted'],200);
        }
        else return response()->json(['message'=>'Product Not Found'],404);
    }
}
