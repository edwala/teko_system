<?php

namespace App\Filament\Resources\BankStatementResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\BankStatementResource;
use Illuminate\Support\Facades\Auth;

class CreateBankStatement extends CreateRecord
{
    protected static string $resource = BankStatementResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = Auth::user()->current_company_id;
        return $data;
    }
}
