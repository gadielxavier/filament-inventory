<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemResource\Pages;
use App\Filament\Resources\ItemResource\RelationManagers;
use App\Models\Inventory\Item;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Estoque';

    protected static ?string $modelLabel = 'Itens e Serviços';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Select::make('item_group_id')
                    ->label('Grupo de Item')
                    ->relationship('itemGroup', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->required(),
                TextInput::make('price')
                    ->label('Preço')
                    ->numeric()
                    ->prefix('R$')
                    ->maxValue(42949672.95),
                TextInput::make('sale_price')
                    ->label('Preço de venda')
                    ->numeric()
                    ->prefix('R$')
                    ->maxValue(42949672.95),
                Select::make('measurement_unit_id')
                    ->label('Unidade de Medida')
                    ->relationship('measurementUnit', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('abbreviation')
                            ->label('Abreviação')
                            ->required()
                            ->maxLength(8),
                    ])
                    ->required(),
                Toggle::make('iventory_item')
                    ->label('Item de estoque')
                    ->required(),
                Toggle::make('sale_item')
                    ->label('Item de venda')
                    ->required(),
                Toggle::make('purchase_item')
                    ->label('Item de compra')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->extraAttributes(['style' => 'max-width:260px'])
                    ->wrap()
                    ->searchable(),
                TextColumn::make('itemGroup.name')
                    ->label('Grupo')
                    ->searchable(),
                ToggleColumn::make('iventory_item')
                    ->label('Item de estoque'),
                ToggleColumn::make('sale_item')
                    ->label('Item de venda'),
                ToggleColumn::make('purchase_item')
                    ->label('Item de compra'),
                TextColumn::make('price')
                    ->label('Preço de custo')
                    ->money(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }
}
