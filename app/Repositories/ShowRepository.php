<?php
namespace App\Repositories;

use App\Models\Show;
use App\Models\UserPayPerClicks;
use App\Models\UserTransaction;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\ShowContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class ShowRepository
 *
 * @package \App\Repositories
 */
class ShowRepository extends BaseRepository implements ShowContract
{
    use UploadAble;

    /**
     * ShowRepository constructor.
     * @param Show $model
     */
    public function __construct(Show $model)
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
    public function listShows(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findShowById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Show|mixed
     */
    public function createShow(array $params)
    {
        try {
            $collection = collect($params);

            $Show = new Show;
            $Show->category_id = $collection['category_id'];
            $Show->language_id = $collection['language_id'];
            $Show->title = $collection['title'];

            $Show->slug = $collection['slug'];
            $Show->description = $collection['description'];
            $Show->year_of_release = $collection['year_of_release'];
            $Show->show_time = $collection['show_time'];
            $Show->age_group = $collection['age_group'];
            $Show->director = $collection['director'];

            $Show->video_file = $collection['video_file'];
            $Show->trailer_video_file = $collection['trailer_video_file'];
            $Show->type = $collection['type'];
            $Show->starrring = $collection['starrring'];

            $profile_image = $collection['image1'];
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("shows/",$imageName);
            $uploadedImage = $imageName;
            $Show->image1 = $uploadedImage;

            $profile_image1 = $collection['image2'];
            $imageName1 = time().".".$profile_image1->getClientOriginalName();
            $profile_image1->move("shows/",$imageName1);
            $uploadedImage1 = $imageName1;
            $Show->image2 = $uploadedImage1;

            $Show->save();

            return $Show;
            
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateShow(array $params)
    {
        $Show = $this->findOneOrFail($params['id']); 
        $collection = collect($params)->except('_token'); 

        $Show->category_id = $collection['category_id'];
        $Show->language_id = $collection['language_id'];
        $Show->title = $collection['title'];

        $Show->slug = $collection['slug'];
        $Show->description = $collection['description'];
        $Show->year_of_release = $collection['year_of_release'];
        $Show->show_time = $collection['show_time'];
        $Show->age_group = $collection['age_group'];
        $Show->director = $collection['director'];

        $Show->video_file = $collection['video_file'];
        $Show->trailer_video_file = $collection['trailer_video_file'];
        $Show->type = $collection['type'];
        $Show->starrring = $collection['starrring'];

        $profile_image = $collection['image1'];
        $imageName = time().".".$profile_image->getClientOriginalName();
        $profile_image->move("shows/",$imageName);
        $uploadedImage = $imageName;
        $Show->image1 = $uploadedImage;

        $profile_image1 = $collection['image2'];
        $imageName1 = time().".".$profile_image1->getClientOriginalName();
        $profile_image1->move("shows/",$imageName1);
        $uploadedImage1 = $imageName1;
        $Show->image2 = $uploadedImage1;

        $Show->save();

        return $Show;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteShow($id)
    {
        $show = $this->findOneOrFail($id);
        $show->delete();
        return $show;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateShowStatus(array $params){
        $show = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $show->status = $collection['check_status'];
        $show->save();

        return $show;
    }

    /**
     * @return mixed
     */
    public function latestMovies(){
        return Show::where('status','1')->orderBy('id', 'desc')->limit('15')->get();
    }

    /**
     * @return mixed
     */
    public function topMovies(){
        return Show::where('status','1')->where('is_top_10','1')->orderBy('id', 'desc')->limit('10')->get();
    }

    /**
     * @return mixed
     */
    public function mustWatchMovies(){
        return Show::where('status','1')->where('is_must_watch','1')->orderBy('id', 'desc')->limit('10')->get();
    }

    /**
     * @return mixed
     */
    public function familyMovies(){
        return Show::where('status','1')->where('is_family','1')->orderBy('id', 'desc')->limit('10')->get();
    }

    /**
     * @param string $slug
     * @return mixed
     */
    public function fetchShowDetails($slug){
        return Show::where('slug',$slug)->with('genres')->with('language')->get();
    }

    /**
     * @param integer $id
     * @param integer $category_id
     * @return mixed
     */
    public function fetchRelatedShows($id,$category_id){
        return Show::where('id','!=',$id)->where('category_id',$category_id)->orderBy('views', 'desc')->limit('10')->get();
    }

    /**
     * @param integer $show_id
     * @param integer $user_id
     * @return mixed
     */
    public function fetchPayPerClickShow($show_id,$user_id){
        return UserPayPerClicks::where('show_id',$show_id)->where('user_id',$user_id)->get();
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function payPerClickUserUpdate(array $params)
    {
        try {
            $collection = collect($params);

            $userPayPerClicks = new UserPayPerClicks;
           
            $userPayPerClicks->user_id = $collection['user_id'];
            $userPayPerClicks->show_id = $collection['show_id'];
            $userPayPerClicks->end_date = date("Y-m-d", strtotime("+365 day"));
            $userPayPerClicks->created_at = date("Y-m-d G:i:s");
            $userPayPerClicks->save();

            $userTransaction = new UserTransaction;
            $userTransaction->user_id = $collection['user_id'];
            $userTransaction->amount = $collection['amount'];
            $userTransaction->transaction_id = $collection['transaction_id'];
            $userTransaction->reason = 'Payment for pay per click';
            $userTransaction->created_at = date("Y-m-d G:i:s");
            $userTransaction->save();

            return true;
        }catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function fetchAllPayPerClickSubscriptions(){
        return UserPayPerClicks::with('show')->with('user')->get(); 
    }

    /**
     * @return mixed
     */
    public function fetchAllTransactions(){
        return UserTransaction::with('user')->get(); 
    }
}