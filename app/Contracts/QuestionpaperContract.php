<?php

namespace App\Contracts;

/**
 * Interface QuestionpaperContract
 * @package App\Contracts
 */
interface QuestionpaperContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listQuestionpapers(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findQuestionpaperById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createQuestionpaper(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateQuestionpaper(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteQuestionpaper($id);
}