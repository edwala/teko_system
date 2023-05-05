<?php

namespace App\Filament\Resources\ClientResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ClientResource;
use Illuminate\Support\Facades\Auth;

class CreateClient extends CreateRecord
{
    protected static string $resource = ClientResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = Auth::user()->current_company_id;
        return $data;
    }
}
