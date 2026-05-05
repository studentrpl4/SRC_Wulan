<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GiftEventResource\Pages;
use App\Filament\Resources\GiftEventResource\RelationManagers;
use App\Models\GiftEvent;
use App\Models\PromoCode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GiftEventResource extends Resource
{
    protected static ?string $model = GiftEvent::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?string $navigationGroup = 'Membership';

    protected static ?string $navigationLabel = 'Gift Event';

    protected static ?string $modelLabel = 'Gift Event';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Info Event')->columns(2)->schema([
                Forms\Components\TextInput::make('name')->label('Nama Event')->required(),
                Forms\Components\TextInput::make('min_purchase')
                    ->label('Minimum Pembelian (Rp)')->prefix('Rp')->numeric()->required(),
                Forms\Components\TextInput::make('duration_days')
                    ->label('Durasi (hari)')->numeric()->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, $set, $get) {
                        if ($get('start_date')) {
                            $set('end_date', \Carbon\Carbon::parse($get('start_date'))->addDays((int) $state));
                        }
                    }),
                Forms\Components\DateTimePicker::make('start_date')
                    ->label('Mulai')->required()->reactive()
                    ->afterStateUpdated(function ($state, $set, $get) {
                        if ($get('duration_days')) {
                            $set('end_date', \Carbon\Carbon::parse($state)->addDays((int) $get('duration_days')));
                        }
                    }),
                Forms\Components\DateTimePicker::make('end_date')
                    ->label('Berakhir')->disabled()->dehydrated(),
                Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
            ]),

            Forms\Components\Section::make('Hadiah')->schema([
                Forms\Components\Select::make('gift_type')
                    ->label('Tipe Hadiah')
                    ->options(['physical' => 'Barang Fisik', 'promo' => 'Promo/Voucher'])
                    ->required()->live(),

                // Kalau fisik
                Forms\Components\TextInput::make('gift_name')
                    ->label('Nama Hadiah')
                    ->visible(fn ($get) => $get('gift_type') === 'physical'),
                Forms\Components\Textarea::make('gift_description')
                    ->label('Deskripsi Hadiah')
                    ->visible(fn ($get) => $get('gift_type') === 'physical'),

                // Kalau promo
                Forms\Components\Select::make('promo_id')
                    ->label('Pilih Promo')
                    ->relationship('promo', 'name')
                    ->visible(fn ($get) => $get('gift_type') === 'promo')
                    ->searchable()
                    ->preload(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Event')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('gift_type')
                    ->label('Tipe Hadiah')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'physical' => 'info',
                        'promo' => 'success',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'physical' => 'Barang Fisik',
                        'promo' => 'Promo/Voucher',
                    }),

                Tables\Columns\TextColumn::make('min_purchase')
                    ->label('Min. Pembelian')
                    ->prefix('Rp ')
                    ->numeric(thousandsSeparator: '.')
                    ->sortable(),

                Tables\Columns\TextColumn::make('start_date')
                    ->label('Mulai')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('end_date')
                    ->label('Berakhir')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('gift_type')
                    ->label('Tipe Hadiah')
                    ->options([
                        'physical' => 'Barang Fisik',
                        'promo' => 'Promo/Voucher',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListGiftEvents::route('/'),
            'create' => Pages\CreateGiftEvent::route('/create'),
            'edit' => Pages\EditGiftEvent::route('/{record}/edit'),
        ];
    }
}
