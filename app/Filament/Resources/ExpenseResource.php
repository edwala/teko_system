<?php

namespace App\Filament\Resources;

use App\Models\Expense;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\ExpenseResource\Pages;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationGroup = 'Expenses';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    TextInput::make('name')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Name')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    FileUpload::make('file')
                        ->enableOpen()
                        ->enableDownload()
                        ->rules(['file'])
                        ->nullable()
                        ->placeholder('File')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('type')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Type')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('expense_category_id')
                        ->rules(['exists:expense_categories,id'])
                        ->required()
                        ->relationship('expenseCategory', 'name')
                        ->searchable()
                        ->preload()
                        ->placeholder('Expense Category')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('suplier')
                        ->rules(['max:255', 'string'])
                        ->nullable()
                        ->placeholder('Suplier')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('property_id')
                        ->rules(['exists:properties,id'])
                        ->nullable()
                        ->relationship('property', 'name')
                        ->searchable()
                        ->preload()
                        ->placeholder('Property')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('service_id')
                        ->rules(['exists:services,id'])
                        ->nullable()
                        ->relationship('service', 'name')
                        ->searchable()
                        ->preload()
                        ->placeholder('Service')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('60s')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('type')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('expenseCategory.name')
                    ->toggleable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('suplier')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('property.name')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('service.name')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
            ])
            ->filters([
                DateRangeFilter::make('created_at'),

                SelectFilter::make('company_id')
                    ->relationship('company', 'name')
                    ->indicator('Company')
                    ->multiple()
                    ->label('Company'),

                SelectFilter::make('expense_category_id')
                    ->relationship('expenseCategory', 'name')
                    ->indicator('ExpenseCategory')
                    ->multiple()
                    ->label('ExpenseCategory'),

                SelectFilter::make('property_id')
                    ->relationship('property', 'name')
                    ->indicator('Property')
                    ->multiple()
                    ->label('Property'),

                SelectFilter::make('service_id')
                    ->relationship('service', 'name')
                    ->indicator('Service')
                    ->multiple()
                    ->label('Service'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'view' => Pages\ViewExpense::route('/{record}'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
        ];
    }
}
