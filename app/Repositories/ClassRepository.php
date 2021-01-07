<?php
namespace App\Repositories;

use App\Contracts\ClassContract;
use App\Models\Classes;
use App\Traits\UploadAble;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;

/**
 * Class BannerRepository
 *
 * @package \App\Repositories
 */
class ClassRepository extends BaseRepository implements ClassContract
{
    use UploadAble;

    /**
     * BannerRepository constructor.
     * @param Classes $model
     */
    public function __construct(Classes $model)
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
    public function listClass(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findClassById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Class|mixed
     */
    public function createClass(array $params)
    {
        try {

            $collection = collect($params);

            $Class = new Classes;
            $Class->name = $collection['name'];
            $Class->parent_id = $collection['parent_id'];
            
            if($collection->has('image')){

            $profile_image = $collection['image'];
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("class/",$imageName);
            $uploadedImage = $imageName;
            $Class->image = $uploadedImage;
            }

            $Class->save();

            return $Class;
            
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateClass(array $params)
    {
        $Class = $this->findOneOrFail($params['id']); 
        $collection = collect($params)->except('_token'); 

        $Class->name = $collection['name'];
        $Class->parent_id = $collection['parent_id'];
        
        if($collection->has('image')){
        $profile_image = $collection['image'];
        $imageName = time().".".$profile_image->getClientOriginalName();
        $profile_image->move("class/",$imageName);
        $uploadedImage = $imageName;
        $Class->image = $uploadedImage;
        }
        $Class->save();

        return $Class;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteClass($id)
    {
        $Class = $this->findOneOrFail($id);
        $Class->delete();
        return $Class;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateClassStatus(array $params){
        $Class = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $Class->is_active = $collection['is_active'];
        $Class->save();

        return $Class;
    }
}