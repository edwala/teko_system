<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\EmployeeResource;

class EditEmployee extends EditRecord
{
    protected static string $resource = EmployeeResource::class;
}
