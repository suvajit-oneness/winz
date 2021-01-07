<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\BoardContract;
use App\Http\Controllers\BaseController;
use App\Models\Board;
use App\Models\Category;
use Illuminate\Http\Request;
use Datatables;
class BoardController extends BaseController
{
    /**
     * @var CategoryContract
     */
    protected $boardRepository;

    /**
     * BoardController constructor.
     * 
     * @param CategoryContract $boardRepository
     */
    public function __construct(BoardContract $boardRepository)
    {
        $this->boardRepository = $boardRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        if($req->ajax()){
            $board = Board::where('id','!=',0);
            return Datatables::of($board)->make();
        }
        $this->setPageTitle('Board', 'List of all board');
        return view('admin.board.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setPageTitle('Board', 'Create Board');
        return view('admin.board.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' =>  'required'
        ]);

        $params = $request->except('_token');

        $category = $this->boardRepository->createBoard($params);

        if (!$category) {
            return $this->responseRedirectBack('Error occurred while creating Board.', 'error', true, true);
        }
        return $this->responseRedirect('admin.board.index', 'Board has been added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $category = $this->boardRepository->findBoardById($id);
        
        $this->setPageTitle('Board', 'Edit Board : '.$category->name);
        return view('admin.board.edit', compact('category'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' =>  'required'
        ]);

        $id = $request->id;

        //$params = $request->except('_token');

        $Category = Board::findOrFail($id);

        $Category->name = $request->name;
        $valid_images = array("png","jpg","jpeg","gif");
        if($request->hasFile("image") && in_array($request->image->extension(),$valid_images)){
            $profile_image = $request->image;
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("board/",$imageName);
            $uploadedImage = $imageName;
            $Category->image = $uploadedImage;
        }

        $Category->save();

        //$category = $this->boardRepository->updateCategory($params);

        if (!$Category) {
            return $this->responseRedirectBack('Error occurred while updating Board.', 'error', true, true);
        }
        return $this->responseRedirectBack('Board updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $category = $this->boardRepository->deleteBoard($id);

        if (!$category) {
            return $this->responseRedirectBack('Error occurred while deleting Board.', 'error', true, true);
        }
        return $this->responseRedirect('admin.board.index', 'Board deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $category = $this->boardRepository->updateBoardStatus($params);

        if ($category) {
            return response()->json(array('message'=>'Board status successfully updated'));
        }
    }
}