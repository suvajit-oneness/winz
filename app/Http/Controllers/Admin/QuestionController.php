<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\SubjectCategory;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\SubChapter;
use DB;

class QuestionController extends BaseController
{
    public function index($chapterId = 0, $subChapterId = 0)
    {
        $questions = Question::select('*');
        if($chapterId > 0){
            $questions = $questions->where('chapterId',$chapterId);
        }else{
            $chapterId =0;
        }
        if($subChapterId>0){
            $questions  = $questions->where('subChapterId',$subChapterId);
        }else{
            $subChapterId = 0;
        }
       
        $questions = $questions->orderBy('id')->paginate(10);
        return view('admin.question.index', compact('questions','chapterId','subChapterId'));
    }
    public function create($chapterId=0,$subChapterId=0)
    {
       // $sub_category = SubjectCategory::all();
        if($chapterId>0)
        {
            $chapterId = $chapterId;
        }else{
            $chapterId=0;
        }

        if($subChapterId>0)
        {
            $subChapterId = $subChapterId;
        }else{
            $subChapterId = 0;
        }

        $categories = Category::all();
        $chapters = Chapter::all();
        return view('admin.question.create',compact('categories','chapters','chapterId','subChapterId'));
    }
    public function store(Request $req)
    {
        $req->validate([
            'question' => 'mimes:jpeg,jpg,png,gif|required', // max 10000kb
            'mark_scheme' => 'mimes:jpeg,jpg,png,gif|required', // max 10000kb
    		'description' => 'required|max:500|string',
    		'difficulty' => 'required|numeric|min:1',
            'answer1' => 'required|string',
            'answer2' => 'required|string',
            'answer3' => 'required|string',
            'answer4' => 'required|string',
    	]);
        $question = new Question();
        if($req->hasFile('question')){
            $question_img = $req->file('question');
            $random = date('Ymdhis').rand(0000,9999);
            $question_img->move('upload/questions/',$random.'.'.$question_img->getClientOriginalExtension());
            $question_img_url = url('upload/questions/'.$random.'.'.$question_img->getClientOriginalExtension());
            $question->question = $question_img_url;
        }
        if($req->hasFile('mark_scheme')){
            $mark_scheme = $req->file('mark_scheme');
            $random = date('Ymdhis').rand(0000,9999);
            $mark_scheme->move('upload/questions/markScheme/',$random.'.'.$mark_scheme->getClientOriginalExtension());
            $mark_scheme_url = url('upload/questions/markScheme/'.$random.'.'.$mark_scheme->getClientOriginalExtension());
            $question->mark_scheme = $mark_scheme_url;
        }

        $subChapterId = $req->subChapterId;
        $categoryId = DB::table('sub_chapters')->where('id',$subChapterId)->first();
        $chapterId =  $req->chapterId;
        $categoryId =  $categoryId->categoryId;

        $question->categoryId = $categoryId;
        $question->chapterId = $req->chapterId;
        $question->subChapterId = $req->subChapterId;
        $question->description = $req->description;
        $question->difficulty = $req->difficulty;
        $question->answer1 = $req->answer1;
        $question->answer2 = $req->answer2;
        $question->answer3 = $req->answer3;
        $question->answer4 = $req->answer4;
        $question->save();
        
        return redirect()->route('admin.question.index',['chapterId'=>$chapterId,'subChapterId'=>$subChapterId]);
       // return $this->responseRedirect('admin.questions.index', 'Question Added successfully' ,'success',false, false);
    }
    public function edit($chapterId=0, $subChapterId=0, $id)
    {
        //$sub_category = SubjectCategory::all();
         if($chapterId>0)
        {
            $chapterId = $chapterId;
        }else{
            $chapterId=0;
        }

        if($subChapterId>0)
        {
            $subChapterId = $subChapterId;
        }else{
            $subChapterId = 0;
        }
        $question = Question::find($id);
        return view('admin.question.edit', compact('question','chapterId','subChapterId'));
    }
    
    public function update(Request $req)
    {
        // dd($req->all());
        $req->validate([
            'question_id' => 'required|numeric|min:1',
            'chapterId' => 'required|numeric|min:1',
            'subChapterId' => 'required|numeric|min:1',
            'description' => 'required|max:500|string',
            'difficulty' => 'required|numeric|min:1',
            'answer1' => 'required|string',
            'answer2' => 'required|string',
            'answer3' => 'required|string',
            'answer4' => 'required|string',
        ]);
        $question = Question::find($req->question_id);
        if($req->hasFile('question')){
            $question_img = $req->file('question');
            $random = date('Ymdhis').rand(0000,9999);
            $question_img->move('upload/questions/',$random.'.'.$question_img->getClientOriginalExtension());
            $question_img_url = url('upload/questions/'.$random.'.'.$question_img->getClientOriginalExtension());
            $question->question = $question_img_url;
        }
        if($req->hasFile('mark_scheme')){
            $mark_scheme = $req->file('mark_scheme');
            $random = date('Ymdhis').rand(0000,9999);
            $mark_scheme->move('upload/questions/markScheme/',$random.'.'.$mark_scheme->getClientOriginalExtension());
            $mark_scheme_url = url('upload/questions/markScheme/'.$random.'.'.$mark_scheme->getClientOriginalExtension());
            $question->mark_scheme = $mark_scheme_url;
        }
        $subChapterId = $req->subChapterId;
        $chapterId =  $req->chapterId;
        $question->chapterId = $req->chapterId;
        $question->subChapterId = $req->subChapterId;
        $question->description = $req->description;
        $question->difficulty = $req->difficulty;
        $question->answer1 = $req->answer1;
        $question->answer2 = $req->answer2;
        $question->answer3 = $req->answer3;
        $question->answer4 = $req->answer4;
        $question->save();
        return redirect()->route('admin.question.index',['chapterId'=>$chapterId,'subChapterId'=>$subChapterId]);

        //return $this->responseRedirect('admin.question.index', 'Question Updated successfully' ,'success',false, false);
    }

    public function delete($id)
    {
        $response = Question::find($id)->delete();
        if (!$response) {
            return $this->responseRedirectBack('Error occurred while deleting.', 'error', true, true);
        }
        return $this->responseRedirect('admin.question.index', 'Question deleted successfully' ,'success',false, false);
    }
}
