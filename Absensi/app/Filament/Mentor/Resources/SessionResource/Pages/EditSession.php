<?php

namespace App\Filament\Mentor\Resources\SessionResource\Pages;

use App\Filament\Mentor\Resources\SessionResource;
use Filament\Resources\Pages\EditRecord;

class EditSession extends EditRecord
{
    protected static string $resource = SessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
