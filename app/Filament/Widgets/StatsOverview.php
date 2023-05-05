<?php

namespace App\Filament\Widgets;

use App\Models\Document;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Employees', Employee::count()),
            Card::make('Documents', Document::count()),
            Card::make('Invoices', Invoice::count()),
            Card::make('Average item value', round(InvoiceItem::avg('total_cost'), 2) . " CZK"),
            Card::make('Sum', round(InvoiceItem::sum('total_cost'), 2) . " CZK"),
        ];
    }
}
