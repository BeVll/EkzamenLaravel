<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Faker\Core\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::all();
        return response()->json($categories);
    }
    public function show(int $id){
        $category = Category::where('id', $id)->first();
        return response()->json($category);
    }
    public function update(Request $request, $id){
        $input = $request->all();
        $deleteImage = Category::where('id', $id)->first()->image;

        Storage::disk("local")->delete("public/images/categories/".$deleteImage);
        $filename = uniqid(). '.' .$request->file('image')->getClientOriginalExtension();

        Storage::disk('local')->put("public/images/categories/".$filename,file_get_contents($request->file("image")));
        $input["image"] = $filename;
        print($input["image"]);
        if($input["status"])
            $input["status"] = 1;
        else
            $input["status"] = 0;
        $category = Category::where('id', $input["id"])->update($input);
        return response()->json($category);
    }
    public function store(Request $request){
        $input = $request->all();

            $filename = uniqid(). '.' .$request->file('image')->getClientOriginalExtension();

            Storage::disk('local')->put("public/images/categories/".$filename,file_get_contents($request->file("image")));
        $input["image"] = $filename;
            print($input["image"]);
        if($input["status"])
            $input["status"] = 1;
        else
            $input["status"] = 0;

        $category = Category::create($input);
        return response()->json($category);
    }
    public function delete(int $id){
        echo($id);
        $category = Category::destroy($id);
        return response()->json($category);
    }
}
