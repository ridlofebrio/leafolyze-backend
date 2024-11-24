<?php

namespace App\Services\Interfaces;

interface ShopServiceInterface
{
    /**
     * Retrieve a shop by its ID.
     *
     * @param int $shopId
     * @return mixed
     */
    public function getShop(int $shopId);

    /**
     * Update a shop's information by its ID.
     *
     * @param int $shopId
     * @param array $data
     * @return mixed
     */
    public function updateShop(int $shopId, array $data);

    /**
     * Create a new shop with the given data.
     *
     * @param array $data
     * @return mixed
     */
    public function createShop(array $data);

    /**
     * Delete a shop by its ID.
     *
     * @param int $shopId
     * @return bool
     */
    public function deleteShop(int $shopId);
}
