<?php

namespace App\Providers\Services\Interface;

interface CRUDInterface
{
    public function store($data): bool;
    public function update($id, $data): bool;
    public function delete($id): bool;
}
