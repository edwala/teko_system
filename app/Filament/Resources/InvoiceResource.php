<?php

namespace App\Filament\Resources;

use App\Models\Invoice;
use Filament\{Forms\Components\Repeater, Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\InvoiceResource\Pages;
use JetBrains\PhpStorm\NoReturn;
use Ramsey\Uuid\Type\Integer;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'name';


    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make(['default' => 1])->schema([
                Grid::make(['default' => 0])->schema([
                    Select::make('client_id')
                        ->rules(['exists:clients,id'])
                        ->required()
                        ->relationship('client', 'company_name')
                        ->searchable()
                        ->preload()
                        ->placeholder('Client')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),


                    TextInput::make('number')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Number')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('name')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Name')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),


                    DatePicker::make('due_date')
                        ->rules(['date'])
                        ->required()
                        ->placeholder('Due Date')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    /*
                    TextInput::make('cost')
                        ->rules(['numeric'])
                        ->numeric()
                        ->placeholder('Cost without vat')
                        ->required(),
                    TextInput::make('total_cost')
                        ->rules(['numeric'])
                        ->numeric()
                        ->placeholder('Total Cost')
                        ->required(),
                    TextInput::make('vat')
                        ->rules(['numeric'])
                        ->numeric()
                        ->placeholder('VAT')
                        ->default('21')
                        ->required(),
                    */
                ]),
            ]),

            Repeater::make('invoice_items')
                ->schema([
                    TextInput::make('name')->required(),
                    TextInput::make('item_cost')
                        ->rules(['numeric'])
                        ->numeric()
                        ->placeholder('Item Cost')
                        ->required(),
                    TextInput::make('count')
                        ->rules(['numeric'])
                        ->numeric()
                        ->placeholder('Count')
                        ->required(),
                    TextInput::make('vat')
                        ->rules(['numeric'])
                        ->numeric()
                        ->placeholder('VAT')
                        ->default('21')
                        ->required(),
                ])
                ->columns(4)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            //->poll('60s')
            ->columns([
                Tables\Columns\TextColumn::make('client.company_name')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('number')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('name')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('due_date')
                    ->toggleable()
                    ->searchable()
                    ->date(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('print')
                    ->label('Print')
                    //->url(route('invoice_generate', ['record' => Invoice::$record])),
                    ->url(fn (Invoice $record): string => route('invoice_generate', ['recordID' => $record]))
                    ->openUrlInNewTab(),
            ])
            ->filters([
                DateRangeFilter::make('created_at'),

                SelectFilter::make('company_id')
                    ->relationship('company', 'name')
                    ->indicator('Company')
                    ->multiple()
                    ->label('Company'),

                SelectFilter::make('client_id')
                    ->relationship('client', 'company_name')
                    ->indicator('Client')
                    ->multiple()
                    ->label('Client'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            InvoiceResource\RelationManagers\InvoiceItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'view' => Pages\ViewInvoice::route('/{record}'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}
