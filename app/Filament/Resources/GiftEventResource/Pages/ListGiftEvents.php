<?php

namespace App\Filament\Resources\GiftEventResource\Pages;

use App\Filament\Resources\GiftEventResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGiftEvents extends ListRecords
{
    protected static string $resource = GiftEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
