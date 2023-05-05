<?php

namespace App\Filament\Resources\ExpenseCategoryResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\ExpenseCategoryResource;

class ListExpenseCategories extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = ExpenseCategoryResource::class;
}
