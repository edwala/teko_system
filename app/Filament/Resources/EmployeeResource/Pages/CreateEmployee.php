<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\EmployeeResource;
use Illuminate\Support\Facades\Auth;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = Auth::user()->current_company_id;
        return $data;
    }
}
