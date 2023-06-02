<?php

namespace App\Filament\Resources\SecretResource\Pages;

use App\Filament\Resources\SecretResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSecret extends ViewRecord
{
    protected static string $resource = SecretResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
