<?php

namespace App\Filament\Resources\InvoiceItemResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\InvoiceItemResource;

class CreateInvoiceItem extends CreateRecord
{
    protected static string $resource = InvoiceItemResource::class;
}
