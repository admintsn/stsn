<?php

namespace App\Filament\Admin\Resources\StatusSantriResource\Pages;

use App\Filament\Admin\Resources\StatusSantriResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStatusSantri extends EditRecord
{
    protected static string $resource = StatusSantriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
