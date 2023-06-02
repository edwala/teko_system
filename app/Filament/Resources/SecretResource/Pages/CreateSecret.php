<?php

namespace App\Filament\Resources\SecretResource\Pages;

use App\Filament\Resources\SecretResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSecret extends CreateRecord
{
    protected static string $resource = SecretResource::class;
}
