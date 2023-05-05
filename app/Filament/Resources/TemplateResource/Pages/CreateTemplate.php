<?php

namespace App\Filament\Resources\TemplateResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\TemplateResource;
use Illuminate\Support\Facades\Auth;

class CreateTemplate extends CreateRecord
{
    protected static string $resource = TemplateResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = Auth::user()->current_company_id;
        return $data;
    }
}
