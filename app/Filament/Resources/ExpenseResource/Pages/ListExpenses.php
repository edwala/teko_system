<?php

namespace App\Filament\Resources\ExpenseResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\ExpenseResource;

class ListExpenses extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = ExpenseResource::class;
}
