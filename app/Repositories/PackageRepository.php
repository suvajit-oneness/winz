<?php
namespace App\Repositories;

use App\Models\Package;
use App\Models\UserPackage;
use App\Models\UserTransaction;
use App\Models\User;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\PackageContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class PackageRepository
 *
 * @package \App\Repositories
 */
class PackageRepository extends BaseRepository implements PackageContract
{
    use UploadAble;

    /**
     * PackageRepository constructor.
     * @param Package $model
     */
    public function __construct(Package $model)
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
    public function listPackages(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findPackageById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Package|mixed
     */
    public function createPackage(array $params)
    {
        try {
            $collection = collect($params);

            $Package = new Package;
            $Package->name = $collection['name'];
            $Package->description = $collection['description'];
            $Package->valid_upto = $collection['valid_upto'];
            $Package->price = $collection['price'];
            $Package->offered_price = $collection['offered_price'];

            $Package->save();

            return $Package;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updatePackage(array $params)
    {
        $Package = $this->findPackageById($params['id']); 
        $collection = collect($params)->except('_token'); 

        $Package->name = $collection['name'];
        $Package->description = $collection['description'];
        $Package->valid_upto = $collection['valid_upto'];
        $Package->price = $collection['price'];
        $Package->offered_price = $collection['offered_price'];

        $Package->save();

        return $Package; 
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deletePackage($id)
    {
        $Package = $this->findPackageById($id);
        $Package->delete();
        return $Package;
    }

   /**
     * @param array $params
     * @return mixed
     */
    public function updateStatus(array $params){
        $Package = $this->findPackageById($params['id']);
        $collection = collect($params)->except('_token');
        $Package->status = $collection['check_status'];
        $Package->save();

        return $Package;
    }

    /**
     * @param array $params
     * @return boolean
     */
    public function storeUserPackageData(array $params)
    {
        try {
            $collection = collect($params);

            $userPackage = new UserPackage;
           
            $userPackage->user_id = $collection['user_id'];
            $userPackage->package_id = $collection['package_id'];
            $userPackage->subscription_end_date = date("Y-m-d", strtotime("+".$collection['valid_for']." day"));
            $userPackage->created_at = date("Y-m-d G:i:s");
            $userPackage->save();

            $userTransaction = new UserTransaction;
            $userTransaction->user_id = $collection['user_id'];
            $userTransaction->amount = $collection['amount'];
            $userTransaction->transaction_id = $collection['transaction_id'];
            $userTransaction->reason = 'Payment for subscription';
            $userTransaction->created_at = date("Y-m-d G:i:s");
            $userTransaction->save();

            $user = User::find($collection['user_id']);
            $user->is_premium = 1;
            $user->save();

            return true;
        }catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function fetchAllSubscriptions(){
        return UserPackage::with('package')->with('user')->get(); 
    }
}