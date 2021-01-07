<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\BoardContract;
use App\Contracts\ClassContract;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Classes;
use App\Models\Level1;
use Illuminate\Http\Request;
use Datatables;

class ClassController extends BaseController
{
    /**
     * @var CategoryContract
     */
    protected $classRepository;
    protected $boardRepository;

    /**
     * BoardController constructor.
     * 
     * @param CategoryContract $classRepository
     */
    public function __construct(ClassContract $classRepository,BoardContract $boardRepository)
    {
        $this->classRepository = $classRepository;
        $this->boardRepository = $boardRepository;
    }
	/**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $req){
        // $class = $this->classRepository->listClass();
        if($req->ajax()){
            $class = Classes::with('board')->get()->toArray();
            return Datatables::of($class)->make();
        }
        $this->setPageTitle('class', 'List of all class');
        return view('admin.class.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
    	$board = $this->boardRepository->listBoards();

        $this->setPageTitle('Class', 'Create Class');
        return view('admin.class.create',compact('board'));
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

        $status = $this->classRepository->createClass($params);

        if (!$status) {
            return $this->responseRedirectBack('Error occurred while creating Class.', 'error', true, true);
        }
        return $this->responseRedirect('admin.class.index', 'Class added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetLevel1 = Classes::findOrFail($id);

        $board = $this->boardRepository->listBoards();

        $this->setPageTitle('Class', 'Edit Class : '.$targetLevel1->name);
        return view('admin.class.edit', compact('targetLevel1','board'));
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

        $targetLevel1 = Classes::findOrFail($id);

        $valid_images = array("png","jpg","jpeg","gif");
            
        if($request->hasFile("image") && in_array($request->image->extension(),$valid_images)){
            
            $profile_image = $request->image;
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("class/",$imageName);
            $uploadedImage = $imageName;
            $data['image'] = $uploadedImage;
        }

        $status = $targetLevel1->update($data);

        if (!$status) {
            return $this->responseRedirectBack('Error occurred while updating Class.', 'error', true, true);
        }
        return $this->responseRedirectBack('Class updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $response = $this->classRepository->deleteClass($id);

        if (!$response) {
            return $this->responseRedirectBack('Error occurred while deleting Level1.', 'error', true, true);
        }
        return $this->responseRedirect('admin.class.index', 'Level1 deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){
        Classes::where('id',$request->id)->update(['is_active'=>$request->is_active]);
        return response()->json(array('message'=>'Class status successfully updated'));
    }
}
