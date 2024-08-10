<?php

namespace App\Filament\Admin\Resources\StatusSantriResource\Pages;

use App\Filament\Admin\Resources\StatusSantriResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStatusSantris extends ListRecords
{
    protected static string $resource = StatusSantriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
