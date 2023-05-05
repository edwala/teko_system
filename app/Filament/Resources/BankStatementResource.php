<?php

namespace App\Filament\Resources;

use App\Models\BankStatement;
use Chiiya\FilamentAccessControl\Traits\AuthorizesPageAccess;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\BankStatementResource\Pages;
use Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager;

class BankStatementResource extends Resource
{
    protected static ?string $model = BankStatement::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'date';

    protected static ?string $navigationGroup = 'Expenses';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    Select::make('month')
                        ->options([
                            1 => "1",
                            2 => "2",
                            3 => "3",
                            4 => "4",
                            5 => "5",
                            6 => "6",
                            7 => "7",
                            8 => "8",
                            9 => "9",
                            10 => "10",
                            11 => "11",
                            12 => "12"
                        ])
                        ->required()
                        ->placeholder('Month')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    FileUpload::make('file')
                        ->enableOpen()
                        ->enableDownload()
                        ->rules(['file', 'max:1024'])
                        ->required()
                        ->placeholder('File')
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
                Tables\Columns\ImageColumn::make('file'),
                Tables\Columns\TextColumn::make('company.name')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('date')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('month')
                    ->toggleable()
                    ->searchable(),
            ])
            ->filters([
                DateRangeFilter::make('created_at'),

                SelectFilter::make('company_id')
                    ->relationship('company', 'name')
                    ->indicator('Company')
                    ->multiple()
                    ->label('Company'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AuditsRelationManager::class,
            ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBankStatements::route('/'),
            'create' => Pages\CreateBankStatement::route('/create'),
            'view' => Pages\ViewBankStatement::route('/{record}'),
            'edit' => Pages\EditBankStatement::route('/{record}/edit'),
        ];
    }
}
