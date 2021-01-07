<?php

namespace App\Contracts;

/**
 * Interface AdsContract
 * @package App\Contracts
 */
interface UserContract
{
	/**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listUsers(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findUserById(int $id);

    /**
     * @param int $id
     * @return mixed
     */

    /**
     * @param array $params
     * @return mixed
     */
    public function createUser(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateUser(array $params);
    public function getUserDetails(int $id);

    public function blockUser($id,$is_block);
    public function verify($id,$is_verified);
    public function updateUserStatus(array $params);
    /**
     * @param $id
     * @return bool
     */
    public function deleteUser($id);
}