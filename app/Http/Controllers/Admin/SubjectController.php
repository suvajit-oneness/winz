<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\ClassContract;
use App\Contracts\SubjectContract;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Level2;
use App\Models\Subject;
use Illuminate\Http\Request;
use Datatables;

class SubjectController extends BaseController
{

    /**
     * @var CategoryContract
     */
    protected $classRepository;
    protected $subjectRepository;

    /**
     * BoardController constructor.
     * 
     * @param CategoryContract $classRepository
     */
    public function __construct(ClassContract $classRepository,SubjectContract $subjectRepository)
    {
        $this->classRepository = $classRepository;
        $this->subjectRepository = $subjectRepository;
    }

	/**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $req){
        // $subject = $this->subjectRepository->listSubjects();
        if($req->ajax()){
            $subject = Subject::with('classes')->get()->toArray();
            return Datatables::of($subject)->make();
        }
        $this->setPageTitle('Subject', 'List of all Subject');
        return view('admin.subject.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
    	$class = $this->classRepository->listClass();

        $this->setPageTitle('Subject', 'Create Subject');
        return view('admin.subject.create',compact('class'));
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
            'parent_id'=>  'required'
        ]);

        $params = $request->except('_token');

        $status = $this->subjectRepository->createSubject($params);

        if (!$status) {
            return $this->responseRedirectBack('Error occurred while creating subject.', 'error', true, true);
        }
        return $this->responseRedirect('admin.subject.index', 'subject added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetLevel2 = Subject::findOrFail($id);

        $class = $this->classRepository->listClass();
        
        $this->setPageTitle('Subject', 'Edit Subject : '.$targetLevel2->name);
        return view('admin.subject.edit', compact('targetLevel2','class'));
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
            'parent_id'=>  'required'
        ]);

        $id = $request->id;
        $data = $request->all();

        $targetLevel2 = Subject::findOrFail($id);

        $status = $targetLevel2->update($data);

        if (!$status) {
            return $this->responseRedirectBack('Error occurred while updating Subject.', 'error', true, true);
        }
        return $this->responseRedirectBack('Subject updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $response = $this->subjectRepository->deleteSubject($id);

        if (!$response) {
            return $this->responseRedirectBack('Error occurred while deleting Subject.', 'error', true, true);
        }
        return $this->responseRedirect('admin.subject.index', 'Level1 deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $status = $this->subjectRepository->updateSubjectStatus($params);

        if ($status) {
            return response()->json(array('message'=>'Subject status successfully updated'));
        }
    }
}
