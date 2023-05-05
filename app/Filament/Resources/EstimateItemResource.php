<?php

namespace App\Filament\Resources;

use App\Models\EstimateItem;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\EstimateItemResource\Pages;

class EstimateItemResource extends Resource
{
    protected static ?string $model = EstimateItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'name';

    //protected static ?string $navigationGroup = 'Hidden';
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    Select::make('estimate_id')
                        ->rules(['exists:estimates,id'])
                        ->required()
                        ->relationship('estimate', 'name')
                        ->searchable()
                        ->placeholder('Estimate')
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

                    TextInput::make('item_cost')
                        ->rules(['numeric'])
                        ->required()
                        ->numeric()
                        ->placeholder('Item Cost')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('count')
                        ->rules(['numeric'])
                        ->required()
                        ->numeric()
                        ->placeholder('Count')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('total_cost')
                        ->rules(['numeric'])
                        ->required()
                        ->numeric()
                        ->placeholder('Total Cost')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('vat')
                        ->rules(['numeric'])
                        ->required()
                        ->numeric()
                        ->placeholder('Vat')
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
                Tables\Columns\TextColumn::make('estimate.name')
                    ->toggleable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('name')
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
                Tables\Columns\TextColumn::make('item_cost')
                    ->toggleable()
                    ->searchable(true, null, true),
                Tables\Columns\TextColumn::make('count')
                    ->toggleable()
                    ->searchable(true, null, true),
                Tables\Columns\TextColumn::make('total_cost')
                    ->toggleable()
                    ->searchable(true, null, true),
                Tables\Columns\TextColumn::make('vat')
                    ->toggleable()
                    ->searchable(true, null, true),
            ])
            ->filters([
                DateRangeFilter::make('created_at'),

                SelectFilter::make('estimate_id')
                    ->relationship('estimate', 'name')
                    ->indicator('Estimate')
                    ->multiple()
                    ->label('Estimate'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEstimateItems::route('/'),
            'create' => Pages\CreateEstimateItem::route('/create'),
            'view' => Pages\ViewEstimateItem::route('/{record}'),
            'edit' => Pages\EditEstimateItem::route('/{record}/edit'),
        ];
    }
}
