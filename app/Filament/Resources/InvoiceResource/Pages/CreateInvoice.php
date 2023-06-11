<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\InvoiceResource;
use Illuminate\Support\Facades\Auth;

class CreateInvoice extends CreateRecord
{
    protected static string $resource = InvoiceResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = Auth::user()->current_company_id;
        $data['number'] = Invoice::where('company_id', Auth::user()->current_company_id)->count() + 1;
        $data['datum_zdanitelneho_plneni'] = $data['datum_vystaveni'];
        $data['name'] = 'FA' . date('Y')  . $data['number'] . ' - ' . Client::find($data['client_id'])->company_name;
        return $data;
    }

    protected function handleRecordCreation(array $data): Invoice
    {
        $model = static::getModel()::create($data);
        foreach($data['invoice_items'] as $invoice_item) {
            InvoiceItem::create([
                'invoice_id' => $model->id,
                'name' => $invoice_item['name'],
                'item_cost' => $invoice_item['item_cost'],
                'count' => $invoice_item['count'],
                'total_cost' => ($invoice_item['count'] * $invoice_item['item_cost'] * ($invoice_item['vat'] / 100)) + ($invoice_item['count'] * $invoice_item['item_cost']),
                'vat' => $invoice_item['vat'],
            ]);
        }

        //dd($model->id);
        return $model;
    }
}
