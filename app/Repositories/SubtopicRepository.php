<?php
namespace App\Repositories;

use App\Contracts\SubtopicContract;
use App\Contracts\TopicContract;
use App\Models\Subtopic;
use App\Models\Topic;
use App\Traits\UploadAble;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;

/**
 * Class TopicRepository
 *
 * @package \App\Repositories
 */
class SubtopicRepository extends BaseRepository implements SubtopicContract
{
    use UploadAble;

    /**
     * TopicRepository constructor.
     * @param Subtopic $model
     */
    public function __construct(Subtopic $model)
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
    public function listSubtopics(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findSubtopicById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Subtopic|mixed
     */
    public function createSubtopic(array $params)
    {
        try {
            $collection = collect($params);

            $Subtopic = new Subtopic;
            $Subtopic->name = $collection['name'];
            $Subtopic->parent_id = $collection['parent_id'];

            $Subtopic->save();

            return $Subtopic;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateSubtopic(array $params)
    {
        $Subtopic = $this->findSubtopicById($params['id']); 
        $collection = collect($params)->except('_token'); 

        $Subtopic->name = $collection['name'];
        $Subtopic->parent_id = $collection['parent_id'];

        $Subtopic->save();

        return $Subtopic;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteSubtopic($id)
    {
        $Subtopic = $this->findOneOrFail($id);
        $Subtopic->delete();
        return $Subtopic;
    }

     /**
     * @param array $params
     * @return mixed
     */
    public function updateSubtopicStatus(array $params){
        $Subtopic = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $Subtopic->is_active = $collection['is_active'];
        $Subtopic->save();

        return $Subtopic;
    }
}