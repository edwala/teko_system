<?php

namespace App\Filament\Resources\ClientResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ClientResource;
use App\Filament\Traits\HasDescendingOrder;

class ListClients extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = ClientResource::class;
}
