<?php
namespace App\Repositories;

use App\Contracts\KeyConceptContract;
use App\Models\Keyconcept;
use App\Traits\UploadAble;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;

/**
 * Class CategoryRepository
 *
 * @package \App\Repositories
 */
class KeyConceptRepository extends BaseRepository implements KeyConceptContract
{
    use UploadAble;

    /**
     * CategoryRepository constructor.
     * @param Key $model
     */
    public function __construct(Keyconcept $model)
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
    public function listKeyconcepts(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findKeyconceptById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Keyconcept|mixed
     */
    public function createKeyconcept(array $params)
    {
        try {
            $collection = collect($params);

            $Keyconcept = new Keyconcept;
            $Keyconcept->title = $collection['title'];
            $Keyconcept->description = $collection['description'];
            $Keyconcept->video_link = $collection['video_link'];
            $Keyconcept->board_id = $collection['board_id'];
            $Keyconcept->subject_id = $collection['subject_id'];
            $Keyconcept->class_id = $collection['class_id'];

            if($collection->has('image')){
            $profile_image = $collection['image'];
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("keyconcept/",$imageName);
            $uploadedImage = $imageName;
            $Keyconcept->image = $uploadedImage;
            }
            $Keyconcept->save();

            return $Keyconcept;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateKeyconcept(array $params)
    {
        $Keyconcept = $this->findKeyconceptById($params['id']); 
        $collection = collect($params)->except('_token'); 

        $Keyconcept->title = $collection['title'];
        $Keyconcept->description = $collection['description'];
        $Keyconcept->video_link = $collection['video_link'];
        $Keyconcept->board_id = $collection['board_id'];
        $Keyconcept->subject_id = $collection['subject_id'];
        $Keyconcept->class_id = $collection['class_id'];

        if($collection->has('image')){
        $profile_image = $collection['image'];
        $imageName = time().".".$profile_image->getClientOriginalName();
        $profile_image->move("keyconcept/",$imageName);
        $uploadedImage = $imageName;
        $Keyconcept->image = $uploadedImage;
        }

        $Keyconcept->save();


        return $Keyconcept; 
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteKeyconcept($id)
    {
        $Keyconcept = $this->findKeyconceptById($id);
        $Keyconcept->delete();

        return $Keyconcept;
    }

   /**
     * @param array $params
     * @return mixed
     */
    public function updateKeyconceptStatus(array $params){
        $Keyconcept = $this->findKeyconceptById($params['id']);
        $collection = collect($params)->except('_token');
        $Keyconcept->is_active = $collection['check_status'];
        $Keyconcept->save();

        return $Keyconcept;
    }
}