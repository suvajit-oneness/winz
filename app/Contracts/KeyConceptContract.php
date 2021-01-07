<?php

namespace App\Contracts;

/**
 * Interface KeyconceptContract
 * @package App\Contracts
 */
interface KeyConceptContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listKeyconcepts(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findKeyconceptById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createKeyconcept(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateKeyconcept(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteKeyconcept($id);
}