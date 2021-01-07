<?php

namespace App\Contracts;

/**
 * Interface TopicContract
 * @package App\Contracts
 */
interface TopicContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listTopics(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findTopicById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createTopic(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateTopic(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteTopic($id);
}