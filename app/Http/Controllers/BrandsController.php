<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Exception;
use Illuminate\Http\Request;

class BrandsController extends Controller
{
    public function index()
    {
        $brands = Brand::paginate(10);
        return response()->json($brands,200);
    }

    public function show($id)
    {
        $brand = Brand::find($id);
        if($brand){
            return response()->json($brand,200);
        }else return response()->json(['message'=>'Brand Not Found'],404);

    }

    public function store(Request $request)
    {
        try{
            $validated = $request->validate([

                'name'=> 'required|unique:brands,name'
            ]);

            $brand = new Brand();
            $brand->name=$request->name;
            $brand->save();
            return response()->json(['message'=>'Brand Save Successfully'],201);

        }catch (Exception $exception){
            return response()->json($exception,500);
        }
    }


    public function update_brand($id,Request $request)
    {
        try {

            $validated = $request->validate([
               'name'=>'required|unique:brands,name'
            ]);

            Brand::where('id',$id)->update([
                'name'=>$request->name
            ]);

            return response()->json(['message'=>'Brand Update Successfully'],200);

        }catch (Exception $exception){
            return response()->json($exception,500);
        }
    }

    public function delete_brand($id)
    {
        try {

            $brand=Brand::find($id);
            if ($brand){
                $brand.delete();
                return response()->json(['message'=>'Brand Deleted'],200);
            }else return response()->json(['message'=>'Brand Not Found'],404);

        }catch (Exception $exception){
            return response()->json($exception,500);
        }

    }

}


