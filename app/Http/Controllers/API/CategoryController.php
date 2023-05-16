<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Faker\Core\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *     tags={"Category"},
     *     path="/api/categories",
     *     @OA\Response(response="200", description="List Categories.")
     * )
     */
    public function index(){
        $categories = Category::paginate(2);
        return response()->json($categories, 200);
    }

    public function show(int $id){
        $category = Category::where('id', $id)->first();
        return response()->json($category);
    }
    /**
     * @OA\Post(
     *     tags={"Category"},
     *     path="/api/categories",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"image", "name", "description", "status"},
     *                 @OA\Property(
     *                     property="image",
     *                     type="file",
     *                     format="binary"
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="status",
     *                     type="boolean"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Add Category.")
     * )
     */
    public function store(Request $request){
        $input = $request->all();

            $filename = uniqid(). '.' .$request->file("image")->getClientOriginalExtension();
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
    public function update(Request $request, $id){
        $input = $request->all();

        print ($request->boolean("imgChange"));
        if($request->boolean("imgChange") == true){
            $deleteImage = Category::where('id', $id)->first()->image;

            Storage::disk("local")->delete("public/images/categories/" . $deleteImage);
            $filename = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();

            Storage::disk('local')->put("public/images/categories/" . $filename, file_get_contents($request->file("image")));
            $input["image"] = $filename;
        }

        if($input["status"])
            $input["status"] = 1;
        else
            $input["status"] = 0;
        $category = Category::where('id', $id)->update($input);
        return response()->json($input);
    }
    public function delete(int $id){
        $tmp = Category::where('id', $id)->first();
        Storage::disk("local")->delete("public/images/categories/".$tmp->image);
        $category = Category::destroy($id);
        return response()->json($category);
    }
}
