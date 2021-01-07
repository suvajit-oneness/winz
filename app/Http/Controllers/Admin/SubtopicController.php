<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\SubtopicContract;
use App\Contracts\TopicContract;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Subtopic;
use App\Models\Topic;
use Illuminate\Http\Request;
use Datatables;

class SubtopicController extends BaseController
{
    /**
     * @var CategoryContract
     */
    protected $topicRepository;
    protected $subtopicRepository;

    /**
     * BoardController constructor.
     * 
     * @param TopicContract $topicRepository
     */
    public function __construct(TopicContract $topicRepository,SubtopicContract $subtopicRepository)
    {
        $this->topicRepository = $topicRepository;
        $this->subtopicRepository = $subtopicRepository;
    }

	/**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $req){
        // $subtopic = $this->subtopicRepository->listSubtopics();
        if($req->ajax()){
            $subtopic = Subtopic::with('topic')->get()->toArray();
            return Datatables::of($subtopic)->make();
        }
        $subtopic = [];
        $this->setPageTitle('Subtopic', 'List of all Subtopic');
        return view('admin.subtopic.index', compact('subtopic'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
    	$topic = $this->topicRepository->listTopics();

        $this->setPageTitle('Subtopic', 'Create Subtopic');
        return view('admin.subtopic.create',compact('topic'));
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

        $status = $this->subtopicRepository->createSubtopic($params);

        if (!$status) {
            return $this->responseRedirectBack('Error occurred while creating Subtopic.', 'error', true, true);
        }
        return $this->responseRedirect('admin.subtopic.index', 'Subtopic added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetLevel4 = Subtopic::findOrFail($id);

        $topic = $this->topicRepository->listTopics();
        
        $this->setPageTitle('Subtopic', 'Edit Subtopic : '.$targetLevel4->name);
        return view('admin.subtopic.edit', compact('targetLevel4','topic'));
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

        $targetLevel4 = Subtopic::findOrFail($id);

        $status = $targetLevel4->update($data);

        if (!$status) {
            return $this->responseRedirectBack('Error occurred while updating Subtopic.', 'error', true, true);
        }
        return $this->responseRedirectBack('Subtopic updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
         $response = $this->subtopicRepository->deleteSubtopic($id);

        if (!$response) {
            return $this->responseRedirectBack('Error occurred while deleting Subtopic.', 'error', true, true);
        }
        return $this->responseRedirect('admin.subtopic.index', 'Subtopic deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $status = $this->subtopicRepository->updateSubtopicStatus($params);

        if ($status) {
            return response()->json(array('message'=>'Subtopic status successfully updated'));
        }
    }
}
