<?php

namespace App\Filament\Admin\Resources\JumlahSantriResource\Pages;

use App\Filament\Admin\Resources\JumlahSantriResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJumlahSantri extends EditRecord
{
    protected static string $resource = JumlahSantriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
