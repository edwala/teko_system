<?php

namespace App\Filament\Resources\EstimateResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\EstimateResource;
use Illuminate\Support\Facades\Auth;

class CreateEstimate extends CreateRecord
{
    protected static string $resource = EstimateResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = Auth::user()->current_company_id;

        return $data;
    }
}
