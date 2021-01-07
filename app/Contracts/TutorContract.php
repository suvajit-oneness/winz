<?php

namespace App\Contracts;

/**
 * Interface TutorContract
 * @package App\Contracts
 */
interface TutorContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listTutors(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findTutorById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createTutor(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateTutor(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteTutor($id);
}