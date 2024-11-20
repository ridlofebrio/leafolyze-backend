<?php

namespace App\Services\Interfaces;

interface ProductServiceInterface
{
    public function getAllProducts();
    public function getProductById(int $id);
    public function createProduct(array $data);
    public function updateProduct(int $id, array $data);
    public function deleteProduct(int $id);
    public function getProductsByShop(int $shopId);
    public function getProductsByDisease(int $diseaseId);
}
