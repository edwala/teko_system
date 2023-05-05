<?php

namespace App\Filament\Resources\ExpenseResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ExpenseResource;
use Illuminate\Support\Facades\Auth;

class CreateExpense extends CreateRecord
{
    protected static string $resource = ExpenseResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = Auth::user()->current_company_id;
        return $data;
    }
}
