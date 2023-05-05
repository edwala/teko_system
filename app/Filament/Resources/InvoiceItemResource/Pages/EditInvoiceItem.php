<?php

namespace App\Filament\Resources\InvoiceItemResource\Pages;

use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\InvoiceItemResource;

class EditInvoiceItem extends EditRecord
{
    protected static string $resource = InvoiceItemResource::class;
}
