<?php

namespace App\Contracts;

/**
 * Interface PackageContract
 * @package App\Contracts
 */
interface PackageContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listPackages(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findPackageById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createPackage(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updatePackage(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deletePackage($id);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateStatus(array $params);
}