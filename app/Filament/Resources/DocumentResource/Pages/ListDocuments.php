<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\DocumentResource;

class ListDocuments extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = DocumentResource::class;
}
