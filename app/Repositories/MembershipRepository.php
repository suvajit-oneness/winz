<?php
namespace App\Repositories;

use App\Contracts\MembershipContract;
use App\Models\Membership;
use App\Models\UserTransaction;
use App\Traits\UploadAble;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;

/**
 * Class MembershipRepository
 *
 * @package \App\Repositories
 */
class MembershipRepository extends BaseRepository implements MembershipContract
{
    use UploadAble;

    /**
     * MembershipRepository constructor.
     * @param Membership $model
     */
    public function __construct(Membership $model)
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
    public function listMemberships(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findMembershipById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Membership|mixed
     */
    public function createMembership(array $params)
    {
        try {
            $collection = collect($params);

            $Membership = new Membership;
            $Membership->title = $collection['title'];
            $Membership->description = $collection['description'];
            $Membership->price = $collection['price'];
            //$Membership->offered_price = $collection['offered_price'];

            $Membership->save();

            return $Membership;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateMembership(array $params)
    {
        $Membership = $this->findMembershipById($params['id']); 
        $collection = collect($params)->except('_token'); 

        $Membership->title = $collection['title'];
        $Membership->description = $collection['description'];
        $Membership->price = $collection['price'];

        $Membership->save();

        return $Membership; 
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteMembership($id)
    {
        $Membership = $this->findMembershipById($id);
        $Membership->delete();
        return $Membership;
    }

   /**
     * @param array $params
     * @return mixed
     */
    public function updateStatus(array $params){
        $Membership = $this->findMembershipById($params['id']);
        $collection = collect($params)->except('_token');
        $Membership->is_active = $collection['is_active'];
        $Membership->save();

        return $Membership;
    }
}