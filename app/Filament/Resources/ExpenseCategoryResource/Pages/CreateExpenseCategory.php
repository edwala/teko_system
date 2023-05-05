<?php

namespace App\Filament\Resources\ExpenseCategoryResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ExpenseCategoryResource;
use Illuminate\Support\Facades\Auth;

class CreateExpenseCategory extends CreateRecord
{
    protected static string $resource = ExpenseCategoryResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = Auth::user()->current_company_id;
        return $data;
    }
}
