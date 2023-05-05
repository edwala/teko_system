<?php

namespace App\Filament\Resources\ExpenseCategoryResource\Pages;

use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\ExpenseCategoryResource;

class EditExpenseCategory extends EditRecord
{
    protected static string $resource = ExpenseCategoryResource::class;
}
