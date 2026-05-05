<?php

namespace App\Filament\Resources\GiftEventResource\Pages;

use App\Filament\Resources\GiftEventResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGiftEvent extends EditRecord
{
    protected static string $resource = GiftEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
