<?php

namespace App\Filament\Resources\PropertyResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\PropertyResource;

class ListProperties extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = PropertyResource::class;
}
