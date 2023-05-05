<?php

namespace App\Filament\Resources\FileResource\Pages;

use App\Filament\Resources\FileResource;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;

class ListFiles extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = FileResource::class;
}
