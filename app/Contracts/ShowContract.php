<?php

namespace App\Contracts;

/**
 * Interface ShowContract
 * @package App\Contracts
 */
interface ShowContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listShows(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findShowById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createShow(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateShow(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteShow($id);
}