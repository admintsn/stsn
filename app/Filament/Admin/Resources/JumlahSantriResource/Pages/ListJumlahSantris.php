<?php

namespace App\Filament\Admin\Resources\JumlahSantriResource\Pages;

use App\Filament\Admin\Resources\JumlahSantriResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJumlahSantris extends ListRecords
{
    protected static string $resource = JumlahSantriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
