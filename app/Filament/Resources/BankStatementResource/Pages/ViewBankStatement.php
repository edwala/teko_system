<?php

namespace App\Filament\Resources\BankStatementResource\Pages;

use Chiiya\FilamentAccessControl\Traits\AuthorizesPageAccess;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\BankStatementResource;

class ViewBankStatement extends ViewRecord
{
    protected static string $resource = BankStatementResource::class;

}
