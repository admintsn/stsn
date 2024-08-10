<?php

namespace App\Filament\Admin\Resources\TahunAjaranAktifResource\Pages;

use App\Filament\Admin\Resources\TahunAjaranAktifResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTahunAjaranAktifs extends ListRecords
{
    protected static string $resource = TahunAjaranAktifResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
