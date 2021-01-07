<?php

namespace App\Contracts;

/**
 * Interface ClassContract
 * @package App\Contracts
 */
interface ClassContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listClass(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findClassById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createClass(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateClass(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteClass($id);
}