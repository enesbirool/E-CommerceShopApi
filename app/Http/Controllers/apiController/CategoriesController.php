<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10);
        return response()->json($categories,200);
    }

    public function show($id)
    {
        $category = Category::find($id);
        if($category){
            return response()->json($category,200);
        }else return response()->json(['message'=>'Category Not Found'],404);

    }

    public function store(Request $request)
    {
        try{
            $validated = $request->validate([

                'name'=> 'required|unique:categories,name',
                'image'=> 'required'
            ]);

            $category = new Category();
            $path = 'assets/uploads/category/' . $category->image;
            if(File::exists($path)){
                File::delete($path);
            }
            $file=$request->file('image');
            $ext=$file->getClientOriginalExtension();
            $filename=time() . '-' . $ext;
            try {
                $file->move('assets/uploads/category',$filename);
            }catch (FileException $e){
                dd($e);
            }
            $category->image=$filename;
            $category->name=$request->name;
            $category->save();
            return response()->json(['message'=>'Category added'],201);
        }catch (Exception $exception){
            return response()->json($exception,500);
        }
    }


    public function update_category($id,Request $request)
    {
        try {

            $validated = $request->validate([
               'name'=>'required|unique:category,name',
               'image'=> 'required'
            ]);

            $category=Category::find($id);

            if ($request->hasFile('image')) {
                $path = 'assets/uploads/category/' . $category->image;
                if (File::exists($path)) {
                    File::delete($path);
                }
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = time() . '-' . $ext;
                try {
                    $file->move('assets/uploads/category', $filename);
                } catch (FileException $e) {
                    dd($e);
                }
                $category->image=$filename;
            }
            $category->name=$request->name;
            $category->update();
            return response()->json(['message'=>'Category Update Successfully'],200);

        }catch (Exception $exception){
            return response()->json($exception,500);
        }
    }

    public function delete_category($id)
    {
        try {

            $category=Category::find($id);
            if ($category){
                $category.delete();
                return response()->json(['message'=>'category Deleted'],200);
            }else return response()->json(['message'=>'category Not Found'],404);

        }catch (Exception $exception){
            return response()->json($exception,500);
        }

    }

}
