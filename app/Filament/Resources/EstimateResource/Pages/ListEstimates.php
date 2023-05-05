<?php

namespace App\Filament\Resources\EstimateResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\EstimateResource;

class ListEstimates extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = EstimateResource::class;
}
