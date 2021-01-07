<?php
namespace App\Repositories;

use App\Contracts\BoardContract;
use App\Models\Board;
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
class BoardRepository extends BaseRepository implements BoardContract
{
    use UploadAble;

    /**
     * CategoryRepository constructor.
     * @param Board $model
     */
    public function __construct(Board $model)
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
    public function listBoards(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findBoardById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return board|mixed
     */
    public function createBoard(array $params)
    {
        try {
            $collection = collect($params);

            $board = new Board;
            $board->name = $collection['name'];
            if($collection->has('image')){
            $profile_image = $collection['image'];
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("board/",$imageName);
            $uploadedImage = $imageName;
            $board->image = $uploadedImage;
            }
            $board->save();

            return $board;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateBoard(array $params)
    {
        $board = $this->findBoardById($params['id']); 
        $collection = collect($params)->except('_token'); 

        $board->name = $collection['name'];

        $profile_image = $collection['image'];
        $imageName = time().".".$profile_image->getClientOriginalName();
        $profile_image->move("board/",$imageName);
        $uploadedImage = $imageName;
        $board->image = $uploadedImage;

        $board->save();

        return $board; 
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteBoard($id)
    {
        $board = $this->findBoardById($id);
        $board->delete();

        return $board;
    }

   /**
     * @param array $params
     * @return mixed
     */
    public function updateBoardStatus(array $params){
        $board = $this->findBoardById($params['id']);
        $collection = collect($params)->except('_token');
        $board->is_active = $collection['is_active'];
        $board->save();

        return $board;
    }
}