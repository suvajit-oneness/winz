<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\BlogContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Datatables;use App\Models\Blog;use Str;
class BlogController extends BaseController
{
    /**
     * @var BlogContract
     */
    protected $blogRepository;

    /**
     * PageController constructor.
     * @param BlogContract $blogRepository
     * 
     */
     
    public function __construct(BlogContract $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index(Request $req)
    {
        // $blog = $this->blogRepository->listBlogs();
        if($req->ajax()){
            $blog = Blog::select('*')->get();
            foreach ($blog as $blogs) {
                $blogs->post_date = date('d M Y h:i A',strtotime($blogs->post_date));
                $strip_tags = strip_tags($blogs->content);
                $blogs->content = Str::limit($strip_tags,50);
            }
            return Datatables::of($blog)->make();
        }
        $this->setPageTitle('Blog', 'List of all blog');
        return view('admin.blog.index');
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Blog', 'Create Blog');
        return view('admin.blog.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'      =>  'required|max:191',
            'image'     =>  'required'
        ]);

        $params = $request->except('_token');
        
        $blog = $this->blogRepository->createBlog($params);

        if (!$blog) {
            return $this->responseRedirectBack('Error occurred while creating blog.', 'error', true, true);
        }
        return $this->responseRedirect('admin.blog.index', 'Blog added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetBlog = $this->blogRepository->findBlogById($id);
        
        $this->setPageTitle('Blog', 'Edit Blog : '.$targetBlog->title);
        return view('admin.blog.edit', compact('targetBlog'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'title'      =>  'required|max:191',
            'image'     =>  'required'
        ]);

        $params = $request->except('_token');
        
        $blog = $this->blogRepository->updateBlog($params);

        if (!$blog) {
            return $this->responseRedirectBack('Error occurred while updating blog.', 'error', true, true);
        }
        return $this->responseRedirectBack('Blog updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $blog = $this->blogRepository->deleteBlog($id);

        if (!$blog) {
            return $this->responseRedirectBack('Error occurred while deleting blog.', 'error', true, true);
        }
        return $this->responseRedirect('admin.blog.index', 'Blog deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $blog = $this->blogRepository->updateBlogStatus($params);

        if ($blog) {
            return response()->json(array('message'=>'Blog status successfully updated'));
        }
    }
}
