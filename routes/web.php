<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EstimateController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\InvoiceItemController;
use App\Http\Controllers\EstimateItemController;
use App\Http\Controllers\BankStatementController;
use App\Http\Controllers\ExpenseCategoryController;
use Illuminate\Support\Str;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Invoice;
use App\Models\Invoice as INV;
use Spatie\Health\Http\Controllers\HealthCheckResultsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});

//Route::get('/xyz', function () { return view('welcome'); })->name('filament.pages.companies/create');
/*

Route::middleware(['auth'])
    ->get('/dashboard', function () {
        return view('dashboard');
    })
    ->name('dashboard');

require __DIR__ . '/auth.php';
*/

Route::prefix('/')
    ->middleware('auth')
    ->group(function () {
        Route::get('health', HealthCheckResultsController::class);

        Route::get('invoice-generate/{recordID}', function ($recordID) {

            //, $lektor, $client, $count, $price, $product

            /*
            $customer = new Buyer([
                'name'          => 'John Doe',
                'custom_fields' => [
                    'email' => 'test@example.com',
                ],
            ]);

            $item = (new InvoiceItem())->title('Service 1')->pricePerUnit(2);

            $invoice = Invoice::make()
                ->buyer($customer)
                ->discountByPercent(10)
                ->taxRate(15)
                ->shipping(1.99)
                ->addItem($item);

            return $invoice->stream();
*/

            $inv = INV::find($recordID);
            //dd($inv->invoiceItems);
            //dd($inv->company->company_name);

                $customer = new Buyer([
                    'name' => $inv->client->company_name,
                    'custom_fields' => [
                        'Adresa' => $inv->client->billing_address,
                        'IČO' => $inv->client->tax_id,
                        'DIČ' => $inv->client->vat_id,
                        //'email' => $inv->company->company_name,
                    ],
                ]);

                $seller = new Party([
                    'name' => $inv->company->company_name,
                    'custom_fields' => [
                        'Adresa' => $inv->company->billing_address,
                        'IČO' => $inv->company->tax_id,
                        'DIČ' => $inv->company->vat_id,
                        //'email' => $inv->company->company_name,
                    ],
                    'methods' => [
                        'method_of_payment' => "bank",
                        //'vs' => $inv->company->tax_id, //Je serial number
                        'account' => $inv->company->account,
                        'bank_code' => $inv->company->back_code,
                    ],
                ]);

                $items = array();
                foreach($inv->invoiceItems as $item) {
                    $items[] = (new InvoiceItem())
                        ->title($item->name)
                        ->pricePerUnit($item->item_cost)
                        ->quantity($item->count)
                        ->taxByPercent($item->vat);
                }

            $item = (new InvoiceItem())->title('Service 1')->pricePerUnit(2);

                $uuid = Str::uuid()->toString();


            $notes = [
                'your multiline',
                'additional notes',
                'in regards of delivery or something else',
            ];
            $notes = implode(";", $notes);

                $invoice = Invoice::make('Faktura')
                    ->series(date('Y'))
                    ->sequence(date('md') . $recordID)
                    ->serialNumberFormat('{SERIES}{SEQUENCE}')
                    ->seller($seller)
                    ->buyer($customer)
                    ->date(now())
                    ->dateFormat('d. m. Y')
                    ->currencySymbol('Kč')
                    ->currencyCode('CZK')
                    ->currencyFormat('{VALUE} {SYMBOL}')
                    ->currencyThousandsSeparator(' ')
                    ->currencyDecimalPoint(',')
                    ->addItems($items)
                    //->notes($notes)
                    //->addItem($item)
                    //->filename($uuid);
                    ->filename(date('Y') . date('md') . $recordID);

            //return $invoice->toHtml();
            return $invoice->stream();
            //return [$invoice->url(), date('Y') . date('md') . $recordID, $uuid];
        })->name('invoice_generate');
        Route::resource('bank-statements', BankStatementController::class);
        Route::resource('clients', ClientController::class);
        Route::resource('companies', CompanyController::class);
        Route::resource('documents', DocumentController::class);
        Route::resource('employees', EmployeeController::class);
        Route::resource('estimates', EstimateController::class);
        Route::resource('estimate-items', EstimateItemController::class);
        Route::resource('expenses', ExpenseController::class);
        Route::resource('expense-categories', ExpenseCategoryController::class);
        Route::resource('files', FileController::class);
        Route::resource('invoices', InvoiceController::class);
        Route::resource('invoice-items', InvoiceItemController::class);
        Route::resource('properties', PropertyController::class);
        Route::resource('services', ServiceController::class);
        Route::resource('templates', TemplateController::class);
        Route::resource('users', UserController::class);
    });

Route::middleware([
    'auth:sanctum',
    config('filament-companies.auth_session'),
    'verified'
])->group(function () {

});

Route::middleware([
    'auth:sanctum',
    config('filament-companies.auth_session'),
    'verified'
])->group(function () {

});
