<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Chapter;
use App\Models\Category;
use App\Models\SubjectCategory;
use DB;
class ChaptersController extends BaseController
{
    public function index($courseId)
    {
        $chapters = Chapter::select('*');
        if($courseId > 0){
            $chapters = $chapters->where('courseId',$courseId);
        }
        $chapters = $chapters->paginate(10);
        return view('admin.chapters.index', compact('chapters','courseId'));
    }
    public function create($courseId)
    {
        $category = Category::all();
        $courses = DB::table('courses')->get();
        return view('admin.chapters.create', compact('category','courses'));
    }
    public function store(Request $req)
    {
        $req->validate([
    		'chapter' => 'required|max:200|string',
    		'price' => 'required|numeric',
            'categoryId' => 'required|numeric|min:1',
            
    	]);
        $chapter = new Chapter();
        $chapter->courseId = $req->courseId;
        $chapter->name = $req->name;
        $chapter->price = $req->price;
        $chapter->save();
        return redirect(route('admin.course.chapters.index',$chapter->courseId));

        //return $this->responseRedirect('admin.course.chapters.index', 'Chapter added successfully' ,'success',false, false);
    }
    public function edit($courseId,$chapterId)
    {
        $chapter = Chapter::find($chapterId);
        $courses = DB::table('courses')->get();

        return view('admin.chapters.edit', compact('chapter','courses'));
    }
    public function update(Request $req)
    {
        $req->validate([
            'chapter_id' => 'required|numeric|min:1',
    		'name' => 'required|max:200|string',
    		'price' => 'required|numeric'
    		
    	]);
        $chapter = Chapter::find($req->chapter_id);
        $chapter->name = $req->name;
        $chapter->price = $req->price;
        $chapter->courseId = $req->courseId;
        $chapter->save();
        return redirect(route('admin.course.chapters.index',$chapter->courseId))->with('success','Chapter Updated successfully');
        // return $this->responseRedirect('admin.course.chapters.index', 'Chapter Updated successfully' ,'success',false, false);
    }
    public function delete($id)
    {
        $response = Chapter::find($id)->delete();
        if (!$response) {
            return $this->responseRedirectBack('Error occurred while deleting.', 'error', true, true);
        }
        return redirect(route('admin.course.chapters.index',$chapter->courseId))->with('success','Chapter deleted successfully');
        // return $this->responseRedirect('admin.course.chapters.index', 'Chapter  successfully' ,'success',false, false);
    }
    public function getChapterData(Request $req)
    {
        $chapters = Chapter::where('subjectCategoryId', $req->subjectCategoryId)->get();
        return response()->json(['error' => false, 'message' => 'Chapters Data', 'data' => $chapters]);
    }
}
