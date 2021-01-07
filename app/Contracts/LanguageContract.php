<?php

namespace App\Contracts;

/**
 * Interface LanguageContract
 * @package App\Contracts
 */
interface LanguageContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listLanguages(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findLanguageById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createLanguage(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateLanguage(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteLanguage($id);
}