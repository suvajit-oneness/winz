<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\BoardContract;
use App\Contracts\ClassContract;
use App\Contracts\KeyConceptContract;
use App\Contracts\SubjectContract;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\Tutor;
use App\Models\Keyconcept;
use Illuminate\Http\Request;
use Datatables;

class KeyconceptController extends BaseController
{
    /**
     * @var CategoryContract
     */
    protected $classRepository;
    protected $subjectRepository;
    protected $boardRepository;
    protected $keyConceptRepository;

    /**
     * BoardController constructor.
     * 
     * @param CategoryContract $classRepository
     */
    public function __construct(ClassContract $classRepository,SubjectContract $subjectRepository,BoardContract $boardRepository,KeyConceptContract $keyConceptRepository)
    {
        $this->classRepository = $classRepository;
        $this->subjectRepository = $subjectRepository;
        $this->boardRepository = $boardRepository;
        $this->keyConceptRepository = $keyConceptRepository;
    }

	/**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $req)
    {
        // $keyConcept = $this->keyConceptRepository->listKeyconcepts(); 
        if($req->ajax()){
            $keyConcept = Keyconcept::select('key_conceptes.*')->with('board')->with('subject')->with('class');
            return Datatables::of($keyConcept)->make();
        }
        $keyConcept = [];
        $this->setPageTitle('Key Concepts', 'List of all Key Concepts');
        return view('admin.keyconcept.index', compact('keyConcept'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
    	$class = $this->classRepository->listClass();
        $subject = $this->subjectRepository->listSubjects();
        $board = $this->boardRepository->listBoards();

        $this->setPageTitle('Key Concepts', 'Create Key Concept');
        return view('admin.keyconcept.create',compact('class','subject','board'));
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
        ]);

        $params = $request->except('_token');

        $status = $this->keyConceptRepository->createKeyconcept($params);

        if (!$status) {
            return $this->responseRedirectBack('Error occurred while creating Key Concepts.', 'error', true, true);
        }
        return $this->responseRedirect('admin.keyconcept.index', 'Key Concepts added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetkeyconcept = $this->keyConceptRepository->findKeyconceptById($id);

        $class = $this->classRepository->listClass();
        $subject = $this->subjectRepository->listSubjects();
        $board = $this->boardRepository->listBoards();
        
        $this->setPageTitle('Key Concepts', 'Edit Key Concepts : '.$targetkeyconcept->title);
        return view('admin.keyconcept.edit', compact('class','subject','board','targetkeyconcept'));
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
        ]);

        $params = $request->except('_token');

        $status = $this->keyConceptRepository->updateKeyconcept($params);

        if (!$status) {
            return $this->responseRedirectBack('Error occurred while updating Key Concepts.', 'error', true, true);
        }
        return $this->responseRedirectBack('Key Concepts updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $response = $this->keyConceptRepository->deleteKeyconcept($id);

        if (!$response) {
            return $this->responseRedirectBack('Error occurred while deleting Key Concepts.', 'error', true, true);
        }
        return $this->responseRedirect('admin.keyconcept.index', 'Key Concepts deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $status = $this->keyConceptRepository->updateKeyconceptStatus($params);

        if ($status) {
            return response()->json(array('message'=>'Key Concepts status successfully updated'));
        }
    }
}