<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\BoardContract;
use App\Contracts\ClassContract;
use App\Contracts\KeyConceptContract;
use App\Contracts\QuestionpaperContract;
use App\Contracts\SubjectContract;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\Tutor;
use App\Models\Questionpaper;
use Illuminate\Http\Request;
use Datatables;

class QuestionpaperController extends BaseController
{
    /**
     * @var CategoryContract
     */
    protected $classRepository;
    protected $subjectRepository;
    protected $boardRepository;
    protected $questionpaperRepository;

    /**
     * BoardController constructor.
     * 
     * @param QuestionpaperContract $questionpaperRepository
     */
    public function __construct(ClassContract $classRepository,SubjectContract $subjectRepository,BoardContract $boardRepository,QuestionpaperContract $questionpaperRepository)
    {
        $this->classRepository = $classRepository;
        $this->subjectRepository = $subjectRepository;
        $this->boardRepository = $boardRepository;
        $this->questionpaperRepository = $questionpaperRepository;
    }

	/**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $req)
    {
        // $questionpaper = $this->questionpaperRepository->listQuestionpapers(); 
        if($req->ajax()){
            $questionpaper = Questionpaper::select('question_papers.*')->with('board')->with('subject')->with('class');
            return Datatables::of($questionpaper)->make();
        }
        $this->setPageTitle('Question paper', 'List of all Question paper');
        return view('admin.questionpaper.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
    	$class = $this->classRepository->listClass();
        $subject = $this->subjectRepository->listSubjects();
        $board = $this->boardRepository->listBoards();

        $this->setPageTitle('Question Paper', 'Create Question Paper');
        return view('admin.questionpaper.create',compact('class','subject','board'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'     =>  'required|max:191',
            'difficulty'     =>  'required|max:191',
        ]);

        $params = $request->except('_token');

        $status = $this->questionpaperRepository->createQuestionpaper($params);

        if (!$status) {
            return $this->responseRedirectBack('Error occurred while creating Question paper.', 'error', true, true);
        }
        return $this->responseRedirect('admin.questionpaper.index', 'Question paper added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetquestionpaper = $this->questionpaperRepository->findQuestionpaperById($id);

        $class = $this->classRepository->listClass();
        $subject = $this->subjectRepository->listSubjects();
        $board = $this->boardRepository->listBoards();
        
        $this->setPageTitle('Question paper', 'Edit Question paper : '.$targetquestionpaper->title);
        return view('admin.questionpaper.edit', compact('class','subject','board','targetquestionpaper'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'title'     =>  'required|max:191',
            'difficulty'     =>  'required|max:191',
        ]);

        $params = $request->except('_token');

        $status = $this->questionpaperRepository->updateQuestionpaper($params);

        if (!$status) {
            return $this->responseRedirectBack('Error occurred while updating Question paper.', 'error', true, true);
        }
        return $this->responseRedirectBack('Question paper updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $response = $this->questionpaperRepository->deleteQuestionpaper($id);

        if (!$response) {
            return $this->responseRedirectBack('Error occurred while deleting Question paper.', 'error', true, true);
        }
        return $this->responseRedirect('admin.questionpaper.index', 'Question paper deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $status = $this->questionpaperRepository->updateQuestionpaperStatus($params);

        if ($status) {
            return response()->json(array('message'=>'Question paper status successfully updated'));
        }
    }
}