<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\EstimateController;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\TemplateController;
use App\Http\Controllers\Api\InvoiceItemController;
use App\Http\Controllers\Api\CompanyUsersController;
use App\Http\Controllers\Api\EstimateItemController;
use App\Http\Controllers\Api\BankStatementController;
use App\Http\Controllers\Api\DocumentFilesController;
use App\Http\Controllers\Api\ClientInvoicesController;
use App\Http\Controllers\Api\CompanyClientsController;
use App\Http\Controllers\Api\ClientEstimatesController;
use App\Http\Controllers\Api\ClientDocumentsController;
use App\Http\Controllers\Api\CompanyExpensesController;
use App\Http\Controllers\Api\CompanyInvoicesController;
use App\Http\Controllers\Api\CompanyServicesController;
use App\Http\Controllers\Api\ExpenseCategoryController;
use App\Http\Controllers\Api\ServiceExpensesController;
use App\Http\Controllers\Api\CompanyEmployeesController;
use App\Http\Controllers\Api\CompanyDocumentsController;
use App\Http\Controllers\Api\CompanyTemplatesController;
use App\Http\Controllers\Api\CompanyEstimatesController;
use App\Http\Controllers\Api\PropertyExpensesController;
use App\Http\Controllers\Api\CompanyPropertiesController;
use App\Http\Controllers\Api\EmployeeDocumentsController;
use App\Http\Controllers\Api\InvoiceInvoiceItemsController;
use App\Http\Controllers\Api\CompanyBankStatementsController;
use App\Http\Controllers\Api\EstimateEstimateItemsController;
use App\Http\Controllers\Api\ExpenseCategoryExpensesController;
use App\Http\Controllers\Api\CompanyExpenseCategoriesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('bank-statements', BankStatementController::class);

        Route::apiResource('clients', ClientController::class);

        // Client Invoices
        Route::get('/clients/{client}/invoices', [
            ClientInvoicesController::class,
            'index',
        ])->name('clients.invoices.index');
        Route::post('/clients/{client}/invoices', [
            ClientInvoicesController::class,
            'store',
        ])->name('clients.invoices.store');

        // Client Estimates
        Route::get('/clients/{client}/estimates', [
            ClientEstimatesController::class,
            'index',
        ])->name('clients.estimates.index');
        Route::post('/clients/{client}/estimates', [
            ClientEstimatesController::class,
            'store',
        ])->name('clients.estimates.store');

        // Client Documents
        Route::get('/clients/{client}/documents', [
            ClientDocumentsController::class,
            'index',
        ])->name('clients.documents.index');
        Route::post('/clients/{client}/documents', [
            ClientDocumentsController::class,
            'store',
        ])->name('clients.documents.store');

        Route::apiResource('companies', CompanyController::class);

        // Company Expenses
        Route::get('/companies/{company}/expenses', [
            CompanyExpensesController::class,
            'index',
        ])->name('companies.expenses.index');
        Route::post('/companies/{company}/expenses', [
            CompanyExpensesController::class,
            'store',
        ])->name('companies.expenses.store');

        // Company Employees
        Route::get('/companies/{company}/employees', [
            CompanyEmployeesController::class,
            'index',
        ])->name('companies.employees.index');
        Route::post('/companies/{company}/employees', [
            CompanyEmployeesController::class,
            'store',
        ])->name('companies.employees.store');

        // Company Clients
        Route::get('/companies/{company}/clients', [
            CompanyClientsController::class,
            'index',
        ])->name('companies.clients.index');
        Route::post('/companies/{company}/clients', [
            CompanyClientsController::class,
            'store',
        ])->name('companies.clients.store');

        // Company Bank Statements
        Route::get('/companies/{company}/bank-statements', [
            CompanyBankStatementsController::class,
            'index',
        ])->name('companies.bank-statements.index');
        Route::post('/companies/{company}/bank-statements', [
            CompanyBankStatementsController::class,
            'store',
        ])->name('companies.bank-statements.store');

        // Company Invoices
        Route::get('/companies/{company}/invoices', [
            CompanyInvoicesController::class,
            'index',
        ])->name('companies.invoices.index');
        Route::post('/companies/{company}/invoices', [
            CompanyInvoicesController::class,
            'store',
        ])->name('companies.invoices.store');

        // Company Documents
        Route::get('/companies/{company}/documents', [
            CompanyDocumentsController::class,
            'index',
        ])->name('companies.documents.index');
        Route::post('/companies/{company}/documents', [
            CompanyDocumentsController::class,
            'store',
        ])->name('companies.documents.store');

        // Company Users
        Route::get('/companies/{company}/users', [
            CompanyUsersController::class,
            'index',
        ])->name('companies.users.index');
        Route::post('/companies/{company}/users', [
            CompanyUsersController::class,
            'store',
        ])->name('companies.users.store');

        // Company Templates
        Route::get('/companies/{company}/templates', [
            CompanyTemplatesController::class,
            'index',
        ])->name('companies.templates.index');
        Route::post('/companies/{company}/templates', [
            CompanyTemplatesController::class,
            'store',
        ])->name('companies.templates.store');

        // Company Expense Categories
        Route::get('/companies/{company}/expense-categories', [
            CompanyExpenseCategoriesController::class,
            'index',
        ])->name('companies.expense-categories.index');
        Route::post('/companies/{company}/expense-categories', [
            CompanyExpenseCategoriesController::class,
            'store',
        ])->name('companies.expense-categories.store');

        // Company Services
        Route::get('/companies/{company}/services', [
            CompanyServicesController::class,
            'index',
        ])->name('companies.services.index');
        Route::post('/companies/{company}/services', [
            CompanyServicesController::class,
            'store',
        ])->name('companies.services.store');

        // Company Properties
        Route::get('/companies/{company}/properties', [
            CompanyPropertiesController::class,
            'index',
        ])->name('companies.properties.index');
        Route::post('/companies/{company}/properties', [
            CompanyPropertiesController::class,
            'store',
        ])->name('companies.properties.store');

        // Company Estimates
        Route::get('/companies/{company}/estimates', [
            CompanyEstimatesController::class,
            'index',
        ])->name('companies.estimates.index');
        Route::post('/companies/{company}/estimates', [
            CompanyEstimatesController::class,
            'store',
        ])->name('companies.estimates.store');

        Route::apiResource('documents', DocumentController::class);

        // Document Files
        Route::get('/documents/{document}/files', [
            DocumentFilesController::class,
            'index',
        ])->name('documents.files.index');
        Route::post('/documents/{document}/files', [
            DocumentFilesController::class,
            'store',
        ])->name('documents.files.store');

        Route::apiResource('employees', EmployeeController::class);

        // Employee Documents
        Route::get('/employees/{employee}/documents', [
            EmployeeDocumentsController::class,
            'index',
        ])->name('employees.documents.index');
        Route::post('/employees/{employee}/documents', [
            EmployeeDocumentsController::class,
            'store',
        ])->name('employees.documents.store');

        Route::apiResource('estimates', EstimateController::class);

        // Estimate Estimate Items
        Route::get('/estimates/{estimate}/estimate-items', [
            EstimateEstimateItemsController::class,
            'index',
        ])->name('estimates.estimate-items.index');
        Route::post('/estimates/{estimate}/estimate-items', [
            EstimateEstimateItemsController::class,
            'store',
        ])->name('estimates.estimate-items.store');

        Route::apiResource('estimate-items', EstimateItemController::class);

        Route::apiResource('expenses', ExpenseController::class);

        Route::apiResource(
            'expense-categories',
            ExpenseCategoryController::class
        );

        // ExpenseCategory Expenses
        Route::get('/expense-categories/{expenseCategory}/expenses', [
            ExpenseCategoryExpensesController::class,
            'index',
        ])->name('expense-categories.expenses.index');
        Route::post('/expense-categories/{expenseCategory}/expenses', [
            ExpenseCategoryExpensesController::class,
            'store',
        ])->name('expense-categories.expenses.store');

        Route::apiResource('files', FileController::class);

        Route::apiResource('invoices', InvoiceController::class);

        // Invoice Invoice Items
        Route::get('/invoices/{invoice}/invoice-items', [
            InvoiceInvoiceItemsController::class,
            'index',
        ])->name('invoices.invoice-items.index');
        Route::post('/invoices/{invoice}/invoice-items', [
            InvoiceInvoiceItemsController::class,
            'store',
        ])->name('invoices.invoice-items.store');

        Route::apiResource('invoice-items', InvoiceItemController::class);

        Route::apiResource('properties', PropertyController::class);

        // Property Expenses
        Route::get('/properties/{property}/expenses', [
            PropertyExpensesController::class,
            'index',
        ])->name('properties.expenses.index');
        Route::post('/properties/{property}/expenses', [
            PropertyExpensesController::class,
            'store',
        ])->name('properties.expenses.store');

        Route::apiResource('services', ServiceController::class);

        // Service Expenses
        Route::get('/services/{service}/expenses', [
            ServiceExpensesController::class,
            'index',
        ])->name('services.expenses.index');
        Route::post('/services/{service}/expenses', [
            ServiceExpensesController::class,
            'store',
        ])->name('services.expenses.store');

        Route::apiResource('templates', TemplateController::class);

        Route::apiResource('users', UserController::class);
    });
