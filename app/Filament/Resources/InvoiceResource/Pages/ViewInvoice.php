<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Models\Invoice;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\InvoiceResource;

class ViewInvoice extends ViewRecord
{
    protected static string $resource = InvoiceResource::class;



    protected function getActions(): array
    {
        //dd(get_defined_vars());
        //dd($this->record);

        return [
            EditAction::make(),
            Action::make('print')
                ->label('Print')
                //->url(route('invoice_generate', ['record' => Invoice::$record])),
                ->url(fn (): string => route('invoice_generate', ['recordID' => $this->record]))
                ->openUrlInNewTab(),
        ];

    }
}
