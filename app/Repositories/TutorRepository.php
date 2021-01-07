<?php
namespace App\Repositories;

use App\Contracts\BoardContract;
use App\Contracts\TutorContract;
use App\Models\Board;
use App\Models\Tutor;
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
class TutorRepository extends BaseRepository implements TutorContract
{
    use UploadAble;

    /**
     * CategoryRepository constructor.
     * @param Tutor $model
     */
    public function __construct(Tutor $model)
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
    public function listTutors(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findTutorById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Tutor|mixed
     */
    public function createTutor(array $params)
    {
        try {
            $collection = collect($params);

            $Tutor = new Tutor;
            $Tutor->name = $collection['name'];
            $Tutor->email = $collection['email'];
            $Tutor->mobile = $collection['mobile'];
            $Tutor->board_id = $collection['board_id'];
            $Tutor->subject_id = $collection['subject_id'];
            $Tutor->topic_id = $collection['topic_id'];

            if($collection->has('image')){
            $profile_image = $collection['image'];
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("tutor/",$imageName);
            $uploadedImage = $imageName;
            $Tutor->image = $uploadedImage;
            }
            $Tutor->save();

            return $Tutor;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateTutor(array $params)
    {
        $Tutor = $this->findTutorById($params['id']); 
        $collection = collect($params)->except('_token'); 

        $Tutor->name = $collection['name'];
        $Tutor->email = $collection['email'];
        $Tutor->mobile = $collection['mobile'];
        $Tutor->board_id = $collection['board_id'];
        $Tutor->subject_id = $collection['subject_id'];
        $Tutor->topic_id = $collection['topic_id'];

        if($collection->has('image')){
        $profile_image = $collection['image'];
        $imageName = time().".".$profile_image->getClientOriginalName();
        $profile_image->move("tutor/",$imageName);
        $uploadedImage = $imageName;
        $Tutor->image = $uploadedImage;
        }

        $Tutor->save();

        return $Tutor; 
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteTutor($id)
    {
        $Tutor = $this->findTutorById($id);
        $Tutor->delete();

        return $Tutor;
    }

   /**
     * @param array $params
     * @return mixed
     */
    public function updateTutorStatus(array $params){
        $Tutor = $this->findTutorById($params['id']);
        $collection = collect($params)->except('_token');
        $Tutor->is_active = $collection['is_active'];
        $Tutor->save();

        return $Tutor;
    }
}