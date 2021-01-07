<?php

namespace App\Contracts;

/**
 * Interface BoardContract
 * @package App\Contracts
 */
interface BoardContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listBoards(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findBoardById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createBoard(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateBoard(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteBoard($id);
}