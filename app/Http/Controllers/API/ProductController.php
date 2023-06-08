<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index', 'show', 'store', 'update', 'delete']]);
    }

    public function index(){
        $products = Product::paginate(2);
        return response()->json($products, 200);
    }

    public function show(int $id){
        $product = Product::where('id', $id)->first();
        return response()->json($product);
    }
    /**
     * @OA\Post(
     *     tags={"Product"},
     *     path="/api/products",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"image", "name", "priority", "price", "category_id", "description", "status"},
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
     *                     property="priority",
     *                     type="number"
     *                 ),
     *                 @OA\Property(
     *                     property="price",
     *                     type="number"
     *                 ),
     *                 @OA\Property(
     *                     property="category_id",
     *                     type="number"
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
        print (response()->json($request->all()));
        $filename = uniqid(). '.' .$request->file("image")->getClientOriginalExtension();
        Storage::disk('local')->put("public/images/products/".$filename,file_get_contents($request->file("image")));
        $input["image"] = $filename;

        if($input["status"])
            $input["status"] = 1;
        else
            $input["status"] = 0;

        $category = Product::create($input);
        return response()->json($category);
    }
//    public function update(Request $request, $id, $change){
//        $input = $request->all();
//
//
//
//        if($change == "true"){
//            print ("aga");
//            $deleteImage = Category::where('id', $id)->first()->image;
//
//            Storage::disk("local")->delete("public/images/categories/" . $deleteImage);
//            $filename = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
//
//            Storage::disk('local')->put("public/images/categories/" . $filename, file_get_contents($request->file("image")));
//            $input["image"] = $filename;
//        }
//
//        if($input["status"])
//            $input["status"] = 1;
//        else
//            $input["status"] = 0;
//        $category = Category::where('id', $id)->update($input);
//        return response()->json($input);
//    }
//    public function delete(int $id){
//        $tmp = Category::where('id', $id)->first();
//        Storage::disk("local")->delete("public/images/categories/".$tmp->image);
//        $category = Category::destroy($id);
//        return response()->json($category);
//    }
}