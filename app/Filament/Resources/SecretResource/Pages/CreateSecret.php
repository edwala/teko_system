<?php

namespace App\Filament\Resources\SecretResource\Pages;

use App\Filament\Resources\SecretResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateSecret extends CreateRecord
{
    protected static string $resource = SecretResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = Auth::user()->current_company_id;
        return $data;
    }
}
