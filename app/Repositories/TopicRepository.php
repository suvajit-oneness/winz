<?php
namespace App\Repositories;

use App\Contracts\TopicContract;
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
class TopicRepository extends BaseRepository implements TopicContract
{
    use UploadAble;

    /**
     * TopicRepository constructor.
     * @param Topic $model
     */
    public function __construct(Topic $model)
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
    public function listTopics(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findTopicById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Topic|mixed
     */
    public function createTopic(array $params)
    {
        try {
            $collection = collect($params);

            $Topic = new Topic;
            $Topic->name = $collection['name'];
            $Topic->parent_id = $collection['parent_id'];

            $Topic->save();

            return $Topic;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateTopic(array $params)
    {
        $Topic = $this->findTopicById($params['id']); 
        $collection = collect($params)->except('_token'); 

        $Topic->name = $collection['name'];
        $Topic->parent_id = $collection['parent_id'];

        $Topic->save();

        return $Topic;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteTopic($id)
    {
        $Topic = $this->findOneOrFail($id);
        $Topic->delete();
        return $Topic;
    }

     /**
     * @param array $params
     * @return mixed
     */
    public function updateTopicStatus(array $params){
        $Topic = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $Topic->is_active = $collection['is_active'];
        $Topic->save();

        return $Topic;
    }
}