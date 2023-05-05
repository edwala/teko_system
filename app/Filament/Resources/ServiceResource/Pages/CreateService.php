<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ServiceResource;
use Illuminate\Support\Facades\Auth;

class CreateService extends CreateRecord
{
    protected static string $resource = ServiceResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = Auth::user()->current_company_id;
        return $data;
    }
}
