<?php

namespace App\Filament\Resources\EstimateItemResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\EstimateItemResource;

class ListEstimateItems extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = EstimateItemResource::class;
}
