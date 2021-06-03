<?php
namespace App\Repositories;

use App\Contracts\QuestionpaperContract;
use App\Models\Questionpaper;
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
class QuestionpaperRepository extends BaseRepository implements QuestionpaperContract
{
    use UploadAble;

    /**
     * CategoryRepository constructor.
     * @param Questionpaper $model
     */
    public function __construct(Questionpaper $model)
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
    public function listQuestionpapers(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findQuestionpaperById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Questionpaper|mixed
     */
    public function createQuestionpaper(array $params)
    {
        try {
            $collection = collect($params);

            $Questionpaper = new Questionpaper;
            $Questionpaper->title = $collection['title'];
            $Questionpaper->description = $collection['description'];
            $Questionpaper->video_link = $collection['video_link'];

            $Questionpaper->difficulty = $collection['difficulty'];

            $Questionpaper->video_solution = $collection['video_solution'];
            $Questionpaper->video_solution2 = $collection['video_solution2'];
            $Questionpaper->video_solution3 = $collection['video_solution3'];

            $Questionpaper->board_id = $collection['board_id'];
            $Questionpaper->subject_id = $collection['subject_id'];
            $Questionpaper->class_id = $collection['class_id'];

            if($collection->has('image')){
                $profile_image = $collection['image'];
                $imageName = time().".".$profile_image->getClientOriginalName();
                $profile_image->move("upload/questionpaper/",$imageName);
                // $uploadedImage = $imageName;
                $Questionpaper->image = url('upload/questionpaper/'.$imageName);
            }
            $Questionpaper->save();

            return $Questionpaper;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateQuestionpaper(array $params)
    {
        $Questionpaper = $this->findQuestionpaperById($params['id']); 
        $collection = collect($params)->except('_token'); 

        $Questionpaper->title = $collection['title'];
        $Questionpaper->description = $collection['description'];
        $Questionpaper->video_link = $collection['video_link'];

        $Questionpaper->difficulty = $collection['difficulty'];

        $Questionpaper->video_solution = $collection['video_solution'];
        $Questionpaper->video_solution2 = $collection['video_solution2'];
        $Questionpaper->video_solution3 = $collection['video_solution3'];

        $Questionpaper->board_id = $collection['board_id'];
        $Questionpaper->subject_id = $collection['subject_id'];
        $Questionpaper->class_id = $collection['class_id'];

        if($collection->has('image')){
            $profile_image = $collection['image'];
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("upload/questionpaper/",$imageName);
            // $uploadedImage = $imageName;
            $Questionpaper->image = url('upload/questionpaper/'.$imageName);
        }
        $Questionpaper->save();
        return $Questionpaper; 
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteQuestionpaper($id)
    {
        $Questionpaper = $this->findQuestionpaperById($id);
        $Questionpaper->delete();

        return $Questionpaper;
    }

   /**
     * @param array $params
     * @return mixed
     */
    public function updateQuestionpaperStatus(array $params){
        $Questionpaper = $this->findQuestionpaperById($params['id']);
        $collection = collect($params)->except('_token');
        $Questionpaper->is_active = $collection['check_status'];
        $Questionpaper->save();

        return $Questionpaper;
    }
}