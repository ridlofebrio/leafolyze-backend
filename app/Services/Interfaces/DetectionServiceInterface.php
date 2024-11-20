<?php

namespace App\Services\Interfaces;

interface DetectionServiceInterface
{
    public function getAllDetections(int $userId);
    public function getDetectionById(int $id);
    public function createDetection(array $data);
    public function updateDetection(int $id, array $data);
    public function deleteDetection(int $id);
}