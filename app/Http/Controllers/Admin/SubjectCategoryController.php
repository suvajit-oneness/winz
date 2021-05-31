<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Category;use App\Models\SubjectCategory;

class SubjectCategoryController extends BaseController
{
    public function index($categoryId = 0)
    {
        $sub_categories = SubjectCategory::select('*');
        if($categoryId > 0){
            $sub_categories = $sub_categories->where('categoryId',$categoryId);
        }
        $sub_categories = $sub_categories->orderBy('id')->get();
        return view('admin.subject-category.index', compact('sub_categories'));
    }
    public function create()
    {
        $category = Category::all();
        return view('admin.subject-category.create', compact('category'));
    }
    public function store(Request $req)
    {
        $req->validate([
    		'title' => 'required|max:200|string',
    		'categoryId' => 'required|numeric|min:1',
    	]);
        $sub_category = new SubjectCategory();
        if($req->hasFile('image')){
            $image = $req->file('image');
            $random = date('Ymdhis').rand(0000,9999);
            $image->move('upload/subject/category/',$random.'.'.$image->getClientOriginalExtension());
            $imageurl = url('upload/subject/category/'.$random.'.'.$image->getClientOriginalExtension());
            $sub_category->image = $imageurl;
        }
        $sub_category->title = $req->title;
        $sub_category->categoryId = $req->categoryId;
        $sub_category->save();
        return $this->responseRedirect('admin.subject.category.index', 'Subject Category added successfully' ,'success',false, false);
    }
    public function edit($id)
    {
        $category = Category::all();
        $sub_category = SubjectCategory::find($id);
        return view('admin.subject-category.edit', compact('sub_category', 'category'));
    }
    public function update(Request $req)
    {
        $req->validate([
            'sub_category_id' => 'required|numeric|min:1',
    		'title' => 'required|max:200|string',
    		'categoryId' => 'required|numeric|min:1',
    	]);
        $sub_category = SubjectCategory::find($req->sub_category_id);
        if($req->hasFile('image')){
            $image = $req->file('image');
            $random = date('Ymdhis').rand(0000,9999);
            $image->move('upload/subject/category/',$random.'.'.$image->getClientOriginalExtension());
            $imageurl = url('upload/subject/category/'.$random.'.'.$image->getClientOriginalExtension());
            $sub_category->image = $imageurl;
        }
        $sub_category->title = $req->title;
        $sub_category->categoryId = $req->categoryId;
        $sub_category->save();
        return $this->responseRedirect('admin.subject.category.index', 'Subject Category Updated successfully' ,'success',false, false);
    }
    public function delete($id)
    {
        $response = SubjectCategory::find($id)->delete();
        if (!$response) {
            return $this->responseRedirectBack('Error occurred while deleting.', 'error', true, true);
        }
        return $this->responseRedirect('admin.subject.category.index', 'Subject Category deleted successfully' ,'success',false, false);
    }
    public function getCategoryData(Request $req)
    {
        $categories = SubjectCategory::where('categoryId', $req->categoryId)->get();
        return response()->json(['error' => false, 'message' => 'Subject Categories Data', 'data' => $categories]);
    }
}
