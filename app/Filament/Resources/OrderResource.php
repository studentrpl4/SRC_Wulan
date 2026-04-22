<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
        TextInput::make('customer_id')
            ->label('Customer ID')
            ->disabled(),

        TextInput::make('total_price')
            ->label('Total Harga')
            ->disabled(),

        Select::make('status')
            ->label('Status Pesanan')
            ->options([
                'processing' => 'Diproses',
                'shipped'    => 'Dikirim',
                'completed'  => 'Selesai',
            ])
            ->required(),
    ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('customer.name')->label('Customer'),
            TextColumn::make('customer.phone')->label('Nomor Telp'),
            TextColumn::make('address')->label('Alamat'),
            TextColumn::make('order_items_count')
                ->label('Jumlah Item')
                ->formatStateUsing(fn ($state, $record) => $record->order_items_count . ' item'),
            TextColumn::make('total_price')->label('Total Harga'),
            BadgeColumn::make('status')
                ->label('Status')
                ->colors([
                    'warning' => 'processing',
                    'info'    => 'shipped',
                    'success' => 'completed',
                ])
                ->formatStateUsing(fn ($state) => [
                    'processing' => 'Diproses',
                    'shipped'    => 'Dikirim',
                    'completed'  => 'Selesai',
                ][$state] ?? $state),
        ])
        ->filters([])
        ->actions([
           Tables\Actions\EditAction::make(),
    Action::make('detail')
        ->label('Lihat Produk')
        ->button()
        ->modalHeading('Detail Pesanan')
        ->modalContent(fn ($record) => view('admin.orders.detail-modal', ['order' => $record])),
                ])
        ->bulkActions([]);
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        // Tambahkan withCount supaya order_items_count tersedia
        return parent::getEloquentQuery()->withCount('order_items');
    }
}
