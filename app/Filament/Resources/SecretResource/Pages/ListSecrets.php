<?php

namespace App\Filament\Resources\SecretResource\Pages;

use App\Filament\Resources\SecretResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSecrets extends ListRecords
{
    protected static string $resource = SecretResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
