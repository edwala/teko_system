<?php

namespace App\Filament\Resources\InvoiceItemResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\InvoiceItemResource;

class ListInvoiceItems extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = InvoiceItemResource::class;
}
