<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\SubjectCategory;

class QuestionController extends BaseController
{
    public function index($chapterId = 0)
    {
        $questions = Question::select('*');
        if($chapterId > 0){
            $questions = $questions->where('chapterId',$chapterId);
        }
        $questions = $questions->orderBy('id')->get();
        return view('admin.question.index', compact('questions'));
    }
    public function create()
    {
        $sub_category = SubjectCategory::all();
        return view('admin.question.create', compact('sub_category'));
    }
    public function store(Request $req)
    {
        $req->validate([
            'subjectCategoryId' => 'required|numeric|min:1',
            'chapterId' => 'required|numeric|min:1',
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
        $question->subjectCategoryId = $req->subjectCategoryId;
        $question->chapterId = $req->chapterId;
        $question->description = $req->description;
        $question->difficulty = $req->difficulty;
        $question->answer1 = $req->answer1;
        $question->answer2 = $req->answer2;
        $question->answer3 = $req->answer3;
        $question->answer4 = $req->answer4;
        $question->save();
        return $this->responseRedirect('admin.question.index', 'Question Added successfully' ,'success',false, false);
    }
    public function edit($id)
    {
        $sub_category = SubjectCategory::all();
        $question = Question::find($id);
        return view('admin.question.edit', compact('sub_category','question'));
    }
    public function update(Request $req)
    {
        // dd($req->all());
        $req->validate([
            'question_id' => 'required|numeric|min:1',
            'subjectCategoryId' => 'required|numeric|min:1',
            'chapterId' => 'required|numeric|min:1',
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
        $question->subjectCategoryId = $req->subjectCategoryId;
        $question->chapterId = $req->chapterId;
        $question->description = $req->description;
        $question->difficulty = $req->difficulty;
        $question->answer1 = $req->answer1;
        $question->answer2 = $req->answer2;
        $question->answer3 = $req->answer3;
        $question->answer4 = $req->answer4;
        $question->save();
        return $this->responseRedirect('admin.question.index', 'Question Updated successfully' ,'success',false, false);
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
