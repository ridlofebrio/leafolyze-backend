<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {

        if (auth('web')->user()->access === 'penjual') {
            return [
                Actions\CreateAction::make(),
            ];
        }
        return [];
    }
}
