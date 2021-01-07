<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\SubjectContract;
use App\Contracts\TopicContract;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Http\Request;
use Datatables;

class TopicController extends BaseController
{
    /**
     * @var CategoryContract
     */
    protected $topicRepository;
    protected $subjectRepository;

    /**
     * BoardController constructor.
     * 
     * @param CategoryContract $topicRepository
     */
    public function __construct(TopicContract $topicRepository,SubjectContract $subjectRepository)
    {
        $this->topicRepository = $topicRepository;
        $this->subjectRepository = $subjectRepository;
    }

	/**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $req){
        // $topic = $this->topicRepository->listTopics();
        if($req->ajax()){
            $topic = Topic::with('subject')->get()->toArray();
            return Datatables::of($topic)->make();
        }
        $this->setPageTitle('Topic', 'List of all Topic');
        return view('admin.topic.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
    	$subject = $this->subjectRepository->listSubjects();

        $this->setPageTitle('Topic', 'Create Topic');
        return view('admin.topic.create',compact('subject'));
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

        $status = $this->topicRepository->createTopic($params);

        if (!$status) {
            return $this->responseRedirectBack('Error occurred while creating Topic.', 'error', true, true);
        }
        return $this->responseRedirect('admin.topic.index', 'Topic added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetLevel3 = Topic::findOrFail($id);

        $subject = $this->subjectRepository->listSubjects();
        
        $this->setPageTitle('Topic', 'Edit Topic : '.$targetLevel3->name);
        return view('admin.topic.edit', compact('targetLevel3','subject'));
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

        $targetLevel3 = Topic::findOrFail($id);

        $status = $targetLevel3->update($data);

        if (!$status) {
            return $this->responseRedirectBack('Error occurred while updating Topic.', 'error', true, true);
        }
        return $this->responseRedirectBack('Topic updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $response = $this->topicRepository->deleteTopic($id);

        if (!$response) {
            return $this->responseRedirectBack('Error occurred while deleting topic.', 'error', true, true);
        }
        return $this->responseRedirect('admin.topic.index', 'topic deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $status = $this->topicRepository->updateTopicStatus($params);

        if ($status) {
            return response()->json(array('message'=>'Topic status successfully updated'));
        }
    }
}
