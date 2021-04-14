<?php
namespace App\Repositories;

use App\Models\Blog;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\BlogContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class BlogRepository
 *
 * @package \App\Repositories
 */
class BlogRepository extends BaseRepository implements BlogContract
{
    use UploadAble;

    /**
     * BlogRepository constructor.
     * @param Blog $model
     */
    public function __construct(Blog $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listBlogs(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findBlogById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Blog|mixed
     */
    public function createBlog(array $params)
    {
        try {

            $collection = collect($params);

            $Blog = new Blog;
            $Blog->title = $collection['title'];
            $Blog->content = $collection['content'];
            $Blog->post_date = \Carbon\Carbon::now();
            
            
            $profile_image = $collection['image'];
            $imageName = time().".".$profile_image->getClientOriginalExtension();
            $profile_image->move("Blog/",$imageName);
            $uploadedImage = $imageName;
            $Blog->image = $uploadedImage;
            
            $Blog->save();

            return $Blog;
            
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateBlog(array $params)
    {
        $Blog = $this->findOneOrFail($params['id']); 
        $collection = collect($params)->except('_token'); 

        $Blog->title = $collection['title'];
         $Blog->content = $collection['content'];
        

        $profile_image = $collection['image'];
        $imageName = time().".".$profile_image->getClientOriginalName();
        $profile_image->move("blogs/",$imageName);
        $uploadedImage = $imageName;
        $Blog->image = $uploadedImage;

        $Blog->save();

        return $Blog;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteBlog($id)
    {
        $Blog = $this->findOneOrFail($id);
        $Blog->delete();
        return $Blog;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateBlogStatus(array $params){
        $Blog = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $Blog->is_active = $collection['is_active'];
        $Blog->save();

        return $Blog;
    }
}