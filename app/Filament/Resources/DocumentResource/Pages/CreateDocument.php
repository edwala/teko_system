<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\DocumentResource;
use Illuminate\Support\Facades\Auth;

class CreateDocument extends CreateRecord
{
    protected static string $resource = DocumentResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = Auth::user()->current_company_id;
        return $data;
    }
}
