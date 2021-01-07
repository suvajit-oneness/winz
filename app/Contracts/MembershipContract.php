<?php

namespace App\Contracts;

/**
 * Interface MembershipContract
 * @package App\Contracts
 */
interface MembershipContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listMemberships(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findMembershipById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createMembership(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateMembership(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteMembership($id);
}