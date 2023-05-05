<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\EmployeeResource;

class ListEmployees extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = EmployeeResource::class;
}
