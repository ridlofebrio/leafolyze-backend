<?php

namespace App\Services;

use App\Models\Disease;
use Illuminate\Support\Facades\Log;
use App\Services\Interfaces\DiseaseServiceInterface;

class DiseaseService implements DiseaseServiceInterface
{
    public function getAllDiseases()
    {
        try {
            return Disease::all();
        } catch (\Exception $e) {
            Log::error('Error fetching diseases: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getDiseaseById(int $id)
    {
        try {
            return Disease::findOrFail($id);
        } catch (\Exception $e) {
            Log::error("Error fetching disease ID {$id}: " . $e->getMessage());
            throw $e;
        }
    }
}
