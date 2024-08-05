<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function send(Request $request){
        $category = new Category();
        $category->name = $request->category_text;
        $category->save();

    }

    public function get(){
        $category = Category::select("id", "name")->get();
        return response()->json(['data'=> $category]);
    }

    public function update(Request $request)
    {
        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->save();
    }

    public function delete(Request $request)
    {
        $category = Category::find($request->id);
        $category->delete();
    }
}
