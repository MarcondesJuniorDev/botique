<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Sale;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SaleResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SaleResource\RelationManagers;

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

                Forms\Components\Repeater::make('items')
                    ->label('Itens da Venda')
                    ->relationship('items')
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->label('Produto')
                            ->placeholder('Escolha um produto')
                            ->relationship('product', 'name')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (Forms\Set $set, $state, Forms\Get $get) {
                                $product = \App\Models\Product::find($state);
                                if ($product) {
                                    $set('unit_price', $product->price);
                                    $set('subtotal', $product->price * ($get('quantity') ?? 1));
                                }
                            }),

                        Forms\Components\TextInput::make('quantity')
                            ->label('Quantidade')
                            ->required()
                            ->numeric()
                            ->reactive()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Forms\Set $set, $state, Forms\Get $get) {
                                $price = $get('unit_price') ?? 0;
                                if ($state > 0) {
                                    $set('subtotal', $price * $state);
                                }
                            }),

                        Forms\Components\TextInput::make('unit_price')
                            ->label('Preço Unitário')
                            ->numeric()
                            ->readOnly()
                            ->prefix('R$ '),

                        Forms\Components\TextInput::make('subtotal')
                            ->label('Subtotal')
                            ->numeric()
                            ->prefix('R$ ')
                            ->readOnly(),

                    ])
                    ->columns(4)
                    ->defaultItems(1)
                    ->minItems(1)
                    ->columnSpanFull()
                    ->addAction(function (Get $get, Set $set) {
                        $total_amount = collect($get('items'))->sum('subtotal');
                        $set('total_amount', $total_amount);
                    }),

                Forms\Components\TextInput::make('total_amount')
                    ->label('Total da Venda')
                    ->numeric()
                    ->prefix('R$ ')
                    ->default(0)
                    ->readOnly()
                    ->dehydrated(true)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Forms\Set $set, $state, Forms\Get $get) {
                        $items = $get('items') ?? [];
                        $total = collect($items)->sum('subtotal');
                        $set('total_amount', $total);
                    })
                    ->afterStateHydrated(function (Forms\Set $set, Forms\Get $get) {
                        $items = $get('items') ?? [];
                        $total = collect($items)->sum('subtotal');
                        $set('total_amount', $total);
                    }),


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
