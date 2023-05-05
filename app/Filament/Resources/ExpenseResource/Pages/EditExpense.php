<?php

namespace App\Filament\Resources\ExpenseResource\Pages;

use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\ExpenseResource;

class EditExpense extends EditRecord
{
    protected static string $resource = ExpenseResource::class;
}
