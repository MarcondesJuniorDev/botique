<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaleResource\Pages;
use App\Filament\Resources\SaleResource\RelationManagers;
use App\Models\Sale;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;
    protected static ?string $label = 'Venda';
    protected static ?string $pluralLabel = 'Vendas';
    protected static ?string $navigationGroup = 'Cadastro';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $activeNavigationIcon = 'heroicon-s-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('customer_id')
                    ->label('Cliente')
                    ->placeholder('Selecione um cliente')
                    ->relationship('customer', 'name')
                    ->required(),

                Forms\Components\DatePicker::make('sale_date')
                    ->label('Data da Venda')
                    ->default(now())
                    ->required(),

                Forms\Components\TextInput::make('total_amount')
                    ->label('Valor Total')
                    ->required()
                    ->numeric()
                    ->prefix('R$ ')
                    ->default(0),

                Forms\Components\Select::make('payment_method')
                    ->label('Método de Pagamento')
                    ->options([
                        'dinheiro' => 'Dinheiro',
                        'cartao_credito' => 'Cartão de Crédito',
                        'cartao_debito' => 'Cartão de Débito',
                        'pix' => 'Pix',
                    ])
                    ->default('dinheiro')
                    ->required(),

                Forms\Components\Textarea::make('notes')
                    ->label('Notas')
                    ->placeholder('Adicione detalhes sobre a venda')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Cliente')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('sale_date')
                    ->label('Data da Venda')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Valor Total')
                    ->sortable()
                    ->money('BRL'),

                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Método de Pagamento')
                    ->badge()
                    ->color(
                        fn($state): string => match ($state) {
                            'dinheiro' => 'success',
                            'cartao_credito' => 'primary',
                            'cartao_debito' => 'warning',
                            'pix' => 'info',
                            default => 'gray',
                        }
                    )
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
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'),
            'edit' => Pages\EditSale::route('/{record}/edit'),
        ];
    }
}
