<?php

namespace App\Services\Interfaces;

interface DiseaseServiceInterface
{
    public function getAllDiseases();
    public function getDiseaseById(int $id);
}
