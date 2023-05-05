<?php

namespace App\Filament\Resources\PropertyResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PropertyResource;
use Illuminate\Support\Facades\Auth;

class CreateProperty extends CreateRecord
{
    protected static string $resource = PropertyResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = Auth::user()->current_company_id;
        return $data;
    }
}
