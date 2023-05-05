<?php

namespace App\Filament\Resources;

use App\Models\Client;
use Closure;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\ClientResource\Pages;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'company_name';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    TextInput::make('company_name')
                        ->rules(['max:255', 'string'])
                        ->required()
                        //->dehydrated(false)
                        ->placeholder('Company Name')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('billing_address')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Billing Address')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('tax_id')
                        //->view('components.ico-input')
                        ->reactive()
                        ->label('Po vložení kompletního IČO se automaticky vyplní název firmy, adresa a DIČ.')
                        ->afterStateUpdated(function (Closure $set, $state) {
                            $ares = self::ARES($state);
                            $address = $ares["ares_ulice_fin"].", ".$ares["ares_cp_fin"].", ".$ares["ares_mesto_fin"].", ".$ares["ares_psc_fin"];
                            $set('company_name', $ares["ares_firma_fin"]);
                            $set('billing_address', $address);
                            $set('vat_id', $ares["ares_dic_fin"]);
                        })
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Tax Id')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('vat_id')
                        ->rules(['max:255', 'string'])
                        ->nullable()
                        ->placeholder('Vat Id')
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
            //->poll('60s')
            ->columns([
                Tables\Columns\TextColumn::make('company_name')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('billing_address')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('tax_id')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('vat_id')
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
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ClientResource\RelationManagers\InvoicesRelationManager::class,
            ClientResource\RelationManagers\EstimatesRelationManager::class,
            ClientResource\RelationManagers\DocumentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'view' => Pages\ViewClient::route('/{record}'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }

    private static function ARES($ico) {
        $ares = [];
        $ares["ares_ico_fin"] = "";
        $ares["ares_dic_fin"] = "";
        $ares["ares_firma_fin"] = "";
        $ares["ares_ulice_fin"]	= "";
        $ares["ares_cp_fin"]  = "";
        $ares["ares_cp1_fin"]	= "";
        $ares["ares_cp2_fin"]	= "";
        $ares["ares_mesto_fin"]	= "";
        $ares["ares_psc_fin"]	= "";
        $ares["ares_stav_fin"] = "";

        $file = @file_get_contents("http://wwwinfo.mfcr.cz/cgi-bin/ares/darv_bas.cgi?ico=" . $ico);

        if($file)
        {
            $xml = @simplexml_load_string($file);
        }

        if($xml)
        {
            $ns = $xml->getDocNamespaces();
            $data = $xml->children($ns['are']);
            $el = $data->children($ns['D'])->VBAS;

            if (strval($el->ICO) == $ico)
            {
                $ares["ares_ico_fin"] = strval($el->ICO);
                $ares["ares_dic_fin"] = strval($el->DIC);
                $ares["ares_firma_fin"] = strval($el->OF);
                $ares["ares_ulice_fin"]	= strval($el->AA->NU);
                $ares["ares_cp1_fin"]	= strval($el->AA->CD);
                $ares["ares_cp2_fin"]	= strval($el->AA->CO);
                if($ares["ares_cp2_fin"] != ""){ $ares["ares_cp_fin"] = $ares["ares_cp1_fin"]."/".$ares["ares_cp2_fin"]; }else{ $ares["ares_cp_fin"] = $ares["ares_cp1_fin"]; }
                $ares["ares_mesto_fin"]	= strval($el->AA->N);
                $ares["ares_psc_fin"]	= strval($el->AA->PSC);
                $ares["ares_stav_fin"] = 1;
            }
            else
            {
                $ares["ares_stav_fin"] 	= 'IČO firmy nebylo nalezeno';
            }
            return $ares;
        }
        else
        {
            $ares["ares_stav_fin"] 	= 'Databáze ARES není dostupná';
        }
    }
}
