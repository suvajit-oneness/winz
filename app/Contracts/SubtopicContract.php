<?php

namespace App\Contracts;

/**
 * Interface TopicContract
 * @package App\Contracts
 */
interface SubtopicContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listSubtopics(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findSubtopicById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createSubtopic(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateSubtopic(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteSubtopic($id);
}