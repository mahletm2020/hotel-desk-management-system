<?php

namespace App\Filament\Resources\StayResource\Pages;

use App\Filament\Resources\StayResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewStay extends ViewRecord
{
    protected static string $resource = StayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
