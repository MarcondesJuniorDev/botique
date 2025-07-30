<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupplierResource\Pages;
use App\Filament\Resources\SupplierResource\RelationManagers;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;
    protected static ?string $label = 'Fornecedor';
    protected static ?string $pluralLabel = 'Fornecedores';
    protected static ?string $navigationGroup = 'Cadastro';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $activeNavigationIcon = 'heroicon-s-truck';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome')
                    ->placeholder('Ex: Fornecedor XYZ')
                    ->required(),

                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->placeholder('Ex: fornecedor@xyz.com')
                    ->required(),

                Forms\Components\TextInput::make('phone')
                    ->label('Telefone')
                    ->tel()
                    ->mask('(99) 99999-9999')
                    ->placeholder('Ex: (11) 99999-9999')
                    ->required(),

                Forms\Components\TextInput::make('website')
                    ->label('Website')
                    ->placeholder('Ex: www.fornecedorxyz.com'),

                Forms\Components\TextInput::make('address')
                    ->label('Endereço')
                    ->placeholder('Ex: Rua XYZ, 123, Bairro, Cidade, Estado')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Telefone')
                    ->searchable(),

                Tables\Columns\TextColumn::make('website')
                    ->label('Site')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('address')
                    ->label('Endereço')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

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
            'index' => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'edit' => Pages\EditSupplier::route('/{record}/edit'),
        ];
    }
}
