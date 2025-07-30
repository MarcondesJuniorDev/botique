<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $label = 'Produto';
    protected static ?string $pluralLabel = 'Produtos';
    protected static ?string $navigationGroup = 'Cadastro';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-heart';
    protected static ?string $activeNavigationIcon = 'heroicon-s-heart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image')
                    ->label('Imagem do Produto')
                    ->columnSpanFull()
                    ->image(),

                Forms\Components\TextInput::make('name')
                    ->label('Nome do Produto')
                    ->required(),

                Forms\Components\TextInput::make('brand')
                    ->label('Marca do Produto')
                    ->required(),

                Forms\Components\TextInput::make('description')
                    ->label('Descrição do Produto')
                    ->required(),

                Forms\Components\TextInput::make('sku')
                    ->label('SKU')
                    ->required(),

                Forms\Components\Select::make('category_id')
                    ->label('Categoria')
                    ->placeholder('Selecione uma categoria')
                    ->relationship('category', 'name'),

                Forms\Components\TextInput::make('price')
                    ->label('Preço de Venda')
                    ->required()
                    ->numeric()
                    ->prefix('R$'),

                Forms\Components\TextInput::make('cost_price')
                    ->label('Preço de Custo')
                    ->required()
                    ->numeric()
                    ->prefix('R$'),

                Forms\Components\TextInput::make('stock')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Imagem')
                    ->circular(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('brand')
                    ->label('Marca')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Descrição')
                    ->searchable(),

                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Venda - R$')
                    ->money('BRL')
                    ->sortable(),

                Tables\Columns\TextColumn::make('cost_price')
                    ->label('Custo - R$')
                    ->money('BRL')
                    ->sortable(),

                Tables\Columns\TextColumn::make('stock')
                    ->label('Estoque')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Categoria')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
