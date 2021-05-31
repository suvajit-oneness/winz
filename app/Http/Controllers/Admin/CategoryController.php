<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends BaseController
{
    public function index()
    {
        $categories = Category::orderBy('id')->get();
        return view('admin.category.index', compact('categories'));
    }
    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.category.edit', compact('category'));
    }
    public function update(Request $req)
    {
        $req->validate([
            'category_id' => 'required|numeric|min:1',
    		'title' => 'required|max:200|string',
    		'full_name' => 'required|max:200|string',
    	]);
    	$check = Category::where('id','!=',$req->category_id)->where('title',$req->title)->withTrashed()->first();
    	if(!$check){
            $category = Category::where('id',$req->category_id)->withTrashed()->first();
	    	$category->title = $req->title;
	    	$category->full_name = $req->full_name;
	    	$category->save();
	    	return $this->responseRedirect('admin.category.index', 'Category Updated successfully' ,'success',false, false);
    	}
    	$error['title'] = 'The title has already been taken.';
    	return back()->withErrors($error)->withInput($req->all());
    }
}
