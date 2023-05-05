<?php

namespace App\Filament\Resources\BankStatementResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\BankStatementResource;

class ListBankStatements extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = BankStatementResource::class;
}
