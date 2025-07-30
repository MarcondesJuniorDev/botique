<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseResource\Pages;
use App\Filament\Resources\PurchaseResource\RelationManagers;
use App\Models\Purchase;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PurchaseResource extends Resource
{
    protected static ?string $model = Purchase::class;
    protected static ?string $label = 'Compra';
    protected static ?string $pluralLabel = 'Compras';
    protected static ?string $navigationGroup = 'Cadastro';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $activeNavigationIcon = 'heroicon-s-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('supplier_id')
                    ->label('Fornecedor')
                    ->required()
                    ->placeholder('Selecione um fornecedor')
                    ->relationship('supplier', 'name'),

                Forms\Components\DatePicker::make('purchase_date')
                    ->label('Data da Compra')
                    ->required(),

                Forms\Components\TextInput::make('total_amount')
                    ->label('Valor Total')
                    ->required()
                    ->numeric()
                    ->prefix('R$ ')
                    ->default(0),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'pendente' => 'Pendente',
                        'concluido' => 'Concluido',
                        'cancelado' => 'Cancelado',
                    ])
                    ->default('pendente')
                    ->required(),

                Forms\Components\Textarea::make('notes')
                    ->label('Notas')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('supplier.name')
                    ->label('Fornecedor')
                    ->badge()
                    ->numeric()
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('purchase_date')
                    ->label('Data da Compra')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Valor Total')
                    ->money('BRL')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'pendente' => 'warning',
                        'concluido' => 'success',
                        'cancelado' => 'danger',
                    })
                    ->searchable(),

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
            'index' => Pages\ListPurchases::route('/'),
            'create' => Pages\CreatePurchase::route('/create'),
            'edit' => Pages\EditPurchase::route('/{record}/edit'),
        ];
    }
}
