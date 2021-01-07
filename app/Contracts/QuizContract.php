<?php

namespace App\Contracts;

/**
 * Interface QuizContract
 * @package App\Contracts
 */
interface QuizContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listQuizs(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findQuizById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createQuiz(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateQuiz(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteQuiz($id);
}