<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public  function index(){
        $categories = Category::all();
        return response()->json($categories);
    }

    public function store(Request $request){
        $input = $request->all();
        $category = Category::create($input);
        return response()->json($category);
    }
    public function delete(int $id){
        echo($id);
        $category = Category::destroy($id);
        return response()->json($category);
    }
}
