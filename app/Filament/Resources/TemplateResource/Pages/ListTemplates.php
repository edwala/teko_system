<?php

namespace App\Filament\Resources\TemplateResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\TemplateResource;

class ListTemplates extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = TemplateResource::class;
}
