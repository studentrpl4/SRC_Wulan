<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PromoResource\Pages;
use App\Filament\Resources\PromoResource\RelationManagers;
use App\Models\PromoCode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;

class PromoResource extends Resource
{
    protected static ?string $model = PromoCode::class;

    protected static ?string $navigationIcon = 'bxs-discount';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Fieldset::make('Informasi Promo')
                    ->schema([
                        TextInput::make('code')
                            ->required()
                            ->maxLength(50)
                            ->unique(ignoreRecord: true)
                            ->placeholder('Contoh: HEMAT10'),

                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        Textarea::make('description')
                            ->nullable()
                            ->rows(3),
                    ]),

                Fieldset::make('Pengaturan Diskon')
                    ->schema([
                        Select::make('discount_type')
                            ->options([
                                'percentage' => 'Persentase (%)',
                                'fixed' => 'Potongan Tetap (Rp)',
                            ])
                            ->required(),

                        TextInput::make('discount_value')
                            ->required()
                            ->numeric()
                            ->minValue(1),

                        TextInput::make('min_purchase')
                            ->numeric()
                            ->default(0)
                            ->prefix('IDR'),

                        TextInput::make('max_discount')
                            ->numeric()
                            ->nullable()
                            ->prefix('IDR'),
                    ]),

                Fieldset::make('Batas Penggunaan')
                    ->schema([
                        TextInput::make('usage_limit')
                            ->numeric()
                            ->nullable()
                            ->helperText('Kosongkan jika tidak ada batas'),

                        TextInput::make('usage_count')
                            ->numeric()
                            ->default(0)
                            ->disabled(),

                        TextInput::make('usage_limit_per_user')
                            ->numeric()
                            ->default(1),
                    ]),

                Fieldset::make('Periode & Status')
                    ->schema([
                        Toggle::make('is_active')
                            ->default(true),

                        DateTimePicker::make('start_date')
                            ->nullable(),

                        DateTimePicker::make('end_date')
                            ->nullable()
                            ->afterOrEqual('start_date'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->searchable()
                    ->weight('bold')
                    ->copyable(),

                TextColumn::make('name')
                    ->searchable(),

                TextColumn::make('discount_type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'percentage' => 'info',
                        'fixed' => 'success',
                    }),

                TextColumn::make('discount_value')
                    ->formatStateUsing(function ($state, $record) {
                        return $record->discount_type === 'percentage'
                            ? $state . '%'
                            : 'Rp ' . number_format($state, 0, ',', '.');
                    }),

                TextColumn::make('min_purchase')
                    ->prefix('Rp ')
                    ->numeric(thousandsSeparator: '.'),

                TextColumn::make('usage_count')
                    ->label('Terpakai')
                    ->formatStateUsing(fn ($state, $record) => $state . ' / ' . ($record->usage_limit ?? '∞')),

                IconColumn::make('is_active')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->label('Aktif'),

                TextColumn::make('end_date')
                    ->label('Berakhir')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('discount_type')
                    ->label('Tipe Diskon')
                    ->options([
                        'percentage' => 'Persentase',
                        'fixed' => 'Potongan Tetap',
                    ]),

                TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
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
            'index' => Pages\ListPromos::route('/'),
            'create' => Pages\CreatePromo::route('/create'),
            'edit' => Pages\EditPromo::route('/{record}/edit'),
        ];
    }
}
