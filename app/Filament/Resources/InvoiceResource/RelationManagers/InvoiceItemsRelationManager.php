<?php

namespace App\Filament\Resources\InvoiceResource\RelationManagers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Contracts\HasRelationshipTable;
use Filament\Resources\{Form, Table};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class InvoiceItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'invoiceItems';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 0])->schema([
                TextInput::make('name')
                    ->rules(['max:255', 'string'])
                    ->placeholder('Name')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('item_cost')
                    ->rules(['numeric'])
                    ->numeric()
                    ->placeholder('Item Cost')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('count')
                    ->rules(['numeric'])
                    ->numeric()
                    ->placeholder('Count')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                /*
                TextInput::make('total_cost')
                    ->rules(['numeric'])
                    ->numeric()
                    ->placeholder('Total Cost')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),
                */

                TextInput::make('vat')
                    ->rules(['numeric'])
                    ->numeric()
                    ->placeholder('Vat')
                    ->default('21')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //Tables\Columns\TextColumn::make('invoice.name')->limit(50),
                Tables\Columns\TextColumn::make('name')->limit(50),
                Tables\Columns\TextColumn::make('item_cost'),
                Tables\Columns\TextColumn::make('count'),
                Tables\Columns\TextColumn::make('total_cost'),
                Tables\Columns\TextColumn::make('vat')
                ->label('VAT Rate'),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    'created_at',
                                    '>=',
                                    $date
                                )
                            )
                            ->when(
                                $data['created_until'],
                                fn(
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    'created_at',
                                    '<=',
                                    $date
                                )
                            );
                    }),

                MultiSelectFilter::make('invoice_id')->relationship(
                    'invoice',
                    'name'
                ),
            ])
            ->headerActions([
                //Tables\Actions\CreateAction::make()
                CreateAction::make()
                    ->using(function (HasRelationshipTable $livewire, array $data): Builder|Model|Relation {
                        //dd($data);
                        //$model = static::getModel()::create($data);
                        return $livewire->getRelationship()->create(
                            [
                                //'invoice_id' => $model->id,
                                'name' => $data['name'],
                                'item_cost' => $data['item_cost'],
                                'count' => $data['count'],
                                'total_cost' => ($data['count'] * $data['item_cost'] * ($data['vat'] / 100)) + ($data['count'] * $data['item_cost']),
                                'vat' => $data['vat'],
                            ]
                        );
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }
}
