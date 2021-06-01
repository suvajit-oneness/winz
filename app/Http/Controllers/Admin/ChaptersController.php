<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Chapter;use App\Models\Category;
use App\Models\SubjectCategory;

class ChaptersController extends BaseController
{
    public function index()
    {
        $chapters = Chapter::orderBy('id')->get();
        return view('admin.chapters.index', compact('chapters'));
    }
    public function create()
    {
        $category = Category::all();
        return view('admin.chapters.create', compact('category'));
    }
    public function store(Request $req)
    {
        $req->validate([
    		'chapter' => 'required|max:200|string',
    		'categoryId' => 'required|numeric|min:1',
    		'subjectCategoryId' => 'required|numeric|min:1',
    	]);
        $chapter = new Chapter();
        $chapter->chapter = $req->chapter;
        $chapter->categoryId = $req->categoryId;
        $chapter->subjectCategoryId = $req->subjectCategoryId;
        $chapter->save();
        return $this->responseRedirect('admin.chapters.index', 'Chapter added successfully' ,'success',false, false);
    }
    public function edit($id)
    {
        $chapter = Chapter::find($id);
        $category = Category::all();
        $sub_category = SubjectCategory::all();
        return view('admin.chapters.edit', compact('chapter','sub_category', 'category'));
    }
    public function update(Request $req)
    {
        $req->validate([
            'chapter_id' => 'required|numeric|min:1',
    		'chapter' => 'required|max:200|string',
    		'categoryId' => 'required|numeric|min:1',
    		'subjectCategoryId' => 'required|numeric|min:1',
    	]);
        $chapter = Chapter::find($req->chapter_id);
        $chapter->chapter = $req->chapter;
        $chapter->categoryId = $req->categoryId;
        $chapter->subjectCategoryId = $req->subjectCategoryId;
        $chapter->save();
        return $this->responseRedirect('admin.chapters.index', 'Chapter Updated successfully' ,'success',false, false);
    }
    public function delete($id)
    {
        $response = Chapter::find($id)->delete();
        if (!$response) {
            return $this->responseRedirectBack('Error occurred while deleting.', 'error', true, true);
        }
        return $this->responseRedirect('admin.chapters.index', 'Chapter deleted successfully' ,'success',false, false);
    }
    public function getChapterData(Request $req)
    {
        $chapters = Chapter::where('subjectCategoryId', $req->subjectCategoryId)->get();
        return response()->json(['error' => false, 'message' => 'Chapters Data', 'data' => $chapters]);
    }
}
