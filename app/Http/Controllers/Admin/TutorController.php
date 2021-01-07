<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\BoardContract;
use App\Contracts\SubjectContract;
use App\Contracts\TopicContract;
use App\Contracts\TutorContract;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\Tutor;
use Illuminate\Http\Request;
use DataTables;

class TutorController extends BaseController
{
    /**
     * @var CategoryContract
     */
    protected $topicRepository;
    protected $subjectRepository;
    protected $boardRepository;
    protected $tutorRepository;

    /**
     * BoardController constructor.
     * 
     * @param CategoryContract $topicRepository
     */
    public function __construct(TopicContract $topicRepository,SubjectContract $subjectRepository,BoardContract $boardRepository,TutorContract $tutorRepository)
    {
        $this->topicRepository = $topicRepository;
        $this->subjectRepository = $subjectRepository;
        $this->boardRepository = $boardRepository;
        $this->tutorRepository = $tutorRepository;
    }

	/**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index(Request $req)
    {
        if($req->ajax()){
            $tutor = Tutor::with('board')->with('subject')->with('topic');
            return Datatables::of($tutor)->make();
        }
        $this->setPageTitle('Level5', 'List of all Level5');
        return view('admin.tutor.index');
    }

    public function indexOld()
    {
        $tutor = Tutor::all();
        $this->setPageTitle('Level5', 'List of all Level5');
        return view('admin.tutor.index', compact('tutor'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
    	$topic = $this->topicRepository->listTopics();
        $subject = $this->subjectRepository->listSubjects();
        $board = $this->boardRepository->listBoards();

        $this->setPageTitle('Level5', 'Create Level5');
        return view('admin.tutor.create',compact('topic','subject','board'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'     =>  'required|max:191',
            'email'     =>  'required|max:191|email',
        ]);

        $params = $request->except('_token');

        $status = $this->tutorRepository->createTutor($params);

        if (!$status) {
            return $this->responseRedirectBack('Error occurred while creating Tutor.', 'error', true, true);
        }
        return $this->responseRedirect('admin.tutor.index', 'Tutor added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetLevel5 = Tutor::findOrFail($id);

        $topic = $this->topicRepository->listTopics();
        $subject = $this->subjectRepository->listSubjects();
        $board = $this->boardRepository->listBoards();
        
        $this->setPageTitle('Tutor', 'Edit Tutor : '.$targetLevel5->name);
        return view('admin.tutor.edit', compact('topic','subject','board','targetLevel5'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name'     =>  'required|max:191',
            'email'     =>  'required|max:191|email',
        ]);

        $params = $request->except('_token');

        $status = $this->tutorRepository->updateTutor($params);

        if (!$status) {
            return $this->responseRedirectBack('Error occurred while updating Tutor.', 'error', true, true);
        }
        return $this->responseRedirectBack('Tutor updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $response = Tutor::find($id)->delete();

        if (!$response) {
            return $this->responseRedirectBack('Error occurred while deleting Tutor.', 'error', true, true);
        }
        return $this->responseRedirect('admin.tutor.index', 'Tutor deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $status = $this->tutorRepository->updateTutorStatus($params);

        if ($status) {
            return response()->json(array('message'=>'Tutor status successfully updated'));
        }
    }
}
