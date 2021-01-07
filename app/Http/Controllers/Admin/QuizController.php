<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\BoardContract;
use App\Contracts\ClassContract;
use App\Contracts\QuizContract;
use App\Contracts\SubjectContract;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Level1;
use App\Models\Size;use App\Models\Quiz;
use Illuminate\Http\Request;
use Datatables;

class QuizController extends BaseController
{
	/**
     * @var CategoryContract
     */
    protected $classRepository;
    protected $subjectRepository;
    protected $boardRepository;
    protected $quizRepository;

    /**
     * BoardController constructor.
     * 
     * @param CategoryContract $classRepository
     */
    public function __construct(ClassContract $classRepository,SubjectContract $subjectRepository,BoardContract $boardRepository,QuizContract $quizRepository)
    {
        $this->classRepository = $classRepository;
        $this->subjectRepository = $subjectRepository;
        $this->boardRepository = $boardRepository;
        $this->quizRepository = $quizRepository;
    }

  /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $req){
        // $quiz = $this->quizRepository->listQuizs();
        if($req->ajax()){
            $quiz = Quiz::select('quizzes.*')->with('board')->with('subject')->with('class');
            return Datatables::of($quiz)->make();
        }
        $this->setPageTitle('Quiz', 'List of all quizzes');
        return view('admin.quiz.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $class = $this->classRepository->listClass();
        $subject = $this->subjectRepository->listSubjects();
        $board = $this->boardRepository->listBoards();

        $this->setPageTitle('Quiz', 'Create quiz');
        return view('admin.quiz.create',compact('class','subject','board'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'question'     =>  'required|max:191',
            'option1'     =>  'required|max:191',
            'option2'     =>  'required|max:191',
            'option3'     =>  'required|max:191',
            'option4'     =>  'required|max:191',
            'answer'     =>  'required|max:191',
        ]);

        $params = $request->except('_token');

        $status = $this->quizRepository->createQuiz($params);

        if (!$status) {
            return $this->responseRedirectBack('Error occurred while creating Tutor.', 'error', true, true);
        }
        return $this->responseRedirect('admin.quiz.index', 'Tutor added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetQuiz = $this->quizRepository->findQuizById($id);

        $class = $this->classRepository->listClass();
        $subject = $this->subjectRepository->listSubjects();
        $board = $this->boardRepository->listBoards();
        
        $this->setPageTitle('Tutor', 'Edit Tutor : '.$targetQuiz->name);
        return view('admin.quiz.edit', compact('class','subject','board','targetQuiz'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'question'   =>  'required|max:191',
            'option1'    =>  'required|max:191',
            'option2'    =>  'required|max:191',
            'option3'    =>  'required|max:191',
            'option4'    =>  'required|max:191',
            'answer'     =>  'required|max:191',
        ]);

        $params = $request->except('_token');

        $status = $this->quizRepository->updateQuiz($params);

        if (!$status) {
            return $this->responseRedirectBack('Error occurred while updating Quiz.', 'error', true, true);
        }
        return $this->responseRedirectBack('Quiz updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $response = $this->quizRepository->deleteQuiz($id);

        if (!$response) {
            return $this->responseRedirectBack('Error occurred while deleting Quiz.', 'error', true, true);
        }
        return $this->responseRedirect('admin.quiz.index', 'Quiz deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $status = $this->quizRepository->updateQuizStatus($params);

        if ($status) {
            return response()->json(array('message'=>'Quiz status successfully updated'));
        }
    }
}
