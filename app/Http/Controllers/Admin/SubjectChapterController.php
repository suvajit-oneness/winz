<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\SubChapter;
use App\Models\Chapter;
use DB;
class SubjectChapterController extends BaseController
{
    public function index($chapterId = 0)
    {
        $sub_chapters = SubChapter::select('*');
        if($chapterId > 0){
            $sub_chapters = $sub_chapters->where('chapterId',$chapterId);

        }
        $sub_chapters = $sub_chapters->orderBy('id')->paginate(10);

        $countquestion = DB::table('questions')->where('subChapterId',$chapterId)->count();
        return view('admin.subject-chapter.index', compact('sub_chapters','chapterId','countquestion'));
    }
    public function create($chapterId=0)
    {

        $chapter = Chapter::all();
        return view('admin.subject-chapter.create', compact('chapter','chapterId'));
    }
    public function store(Request $req)
    {
        $req->validate([
    		'name' => 'required|max:200|string',
    		'chapterId' => 'required|numeric|min:1',
            'topics' => 'required|max:500|string',
    	]);
        $sub_chapter = new SubChapter();
        $chapterId = $req->chapterId;
        $sub_chapter->name = $req->name;
        $sub_chapter->chapterId = $req->chapterId;
        $sub_chapter->topics = $req->topics;
        $sub_chapter->save();
        return redirect()->route('admin.subject.chapter.index',['chapterId'=>$chapterId]);
       // return $this->responseRedirect('admin.subject.chapter.index',$chapterId, 'Subject chapter added successfully' ,'success',false, false);
    }
    public function edit($id)
    {
        $sub_chapter = SubChapter::find($id);
        $chapter = Chapter::all();
        return view('admin.subject-chapter.edit', compact('sub_chapter','chapter'));
    }
    public function update(Request $req)
    {
        // dd($req->all());
        $req->validate([
            'sub_chapter_id' => 'required|numeric|min:1',
    		'name' => 'required|max:200|string',
    		'chapterId' => 'required|numeric|min:1',
            'topics' => 'required|max:500|string',
    	]);
        $sub_chapter = SubChapter::find($req->sub_chapter_id);
        $sub_chapter->name = $req->name;
        $sub_chapter->chapterId = $req->chapterId;
        $sub_chapter->topics = $req->topics;
        $sub_chapter->save();
        return $this->responseRedirect('admin.subject.chapter.index', 'Subject Chapter Updated successfully' ,'success',false, false);
    }
    public function delete($id)
    {
        $response = SubChapter::find($id)->delete();
        if (!$response) {
            return $this->responseRedirectBack('Error occurred while deleting.', 'error', true, true);
        }
        return $this->responseRedirect('admin.subject.chapter.index', 'Subject Chapter deleted successfully' ,'success',false, false);
    }
}
