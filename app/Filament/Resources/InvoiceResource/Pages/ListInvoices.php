<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\InvoiceResource;

class ListInvoices extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = InvoiceResource::class;
}
