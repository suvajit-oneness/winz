<?php
namespace App\Repositories;

use App\Contracts\QuizContract;;
use App\Models\Quiz;
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
class QuizRepository extends BaseRepository implements QuizContract
{
    use UploadAble;

    /**
     * CategoryRepository constructor.
     * @param Quiz $model
     */
    public function __construct(Quiz $model)
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
    public function listQuizs(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findQuizById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Quiz|mixed
     */
    public function createQuiz(array $params)
    {
        try {
            $collection = collect($params);

            $Quiz = new Quiz;
            $Quiz->question = $collection['question'];
            $Quiz->option1 = $collection['option1'];
            $Quiz->option2 = $collection['option2'];
            $Quiz->option3 = $collection['option3'];
            $Quiz->option4 = $collection['option4'];
            $Quiz->option5 = $collection['option5'];

            $Quiz->answer = $collection['answer'];
            
            $Quiz->board_id = $collection['board_id'];
            $Quiz->class_id = $collection['class_id'];
            $Quiz->subject_id = $collection['subject_id'];

            $Quiz->save();

            return $Quiz;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateQuiz(array $params)
    {
        $Quiz = $this->findQuizById($params['id']); 
        $collection = collect($params)->except('_token'); 

        $Quiz->question = $collection['question'];
        $Quiz->option1 = $collection['option1'];
        $Quiz->option2 = $collection['option2'];
        $Quiz->option3 = $collection['option3'];
        $Quiz->option4 = $collection['option4'];
        $Quiz->option5 = $collection['option5'];

        $Quiz->answer = $collection['answer'];
        
        $Quiz->board_id = $collection['board_id'];
        $Quiz->class_id = $collection['class_id'];
        $Quiz->subject_id = $collection['subject_id'];

        $Quiz->save();

        return $Quiz; 
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteQuiz($id)
    {
        $Quiz = $this->findQuizById($id);
        $Quiz->delete();

        return $Quiz;
    }

   /**
     * @param array $params
     * @return mixed
     */
    public function updateQuizStatus(array $params){
        $Quiz = $this->findQuizById($params['id']);
        $collection = collect($params)->except('_token');
        $Quiz->is_active = $collection['check_status'];
        $Quiz->save();

        return $Quiz;
    }
}