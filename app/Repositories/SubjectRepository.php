<?php
namespace App\Repositories;

use App\Contracts\SubjectContract;
use App\Models\Subject;
use App\Traits\UploadAble;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;

/**
 * Class SubjectRepository
 *
 * @package \App\Repositories
 */
class SubjectRepository extends BaseRepository implements SubjectContract
{
    use UploadAble;

    /**
     * SubjectRepository constructor.
     * @param Subject $model
     */
    public function __construct(Subject $model)
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
    public function listSubjects(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findSubjectById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Subject|mixed
     */
    public function createSubject(array $params)
    {
        try {
            $collection = collect($params);

            $Subject = new Subject;
            $Subject->name = $collection['name'];
            $Subject->parent_id = $collection['parent_id'];

            $Subject->save();

            return $Subject;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateSubject(array $params)
    {
        $Subject = $this->findSubjectById($params['id']); 
        $collection = collect($params)->except('_token'); 

        $Subject->name = $collection['name'];
        $Subject->parent_id = $collection['parent_id'];

        $Subject->save();

        return $Subject;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteSubject($id)
    {
        $Subject = $this->findOneOrFail($id);
        $Subject->delete();
        return $Subject;
    }

     /**
     * @param array $params
     * @return mixed
     */
    public function updateSubjectStatus(array $params){
        $Subject = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $Subject->is_active = $collection['is_active'];
        $Subject->save();

        return $Subject;
    }
}