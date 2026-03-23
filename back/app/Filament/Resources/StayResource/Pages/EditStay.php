<?php

namespace App\Filament\Resources\StayResource\Pages;

use App\Filament\Resources\StayResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStay extends EditRecord
{
    protected static string $resource = StayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
