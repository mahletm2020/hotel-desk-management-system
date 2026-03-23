<?php

namespace App\Filament\Resources\StayResource\Pages;

use App\Filament\Resources\StayResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStays extends ListRecords
{
    protected static string $resource = StayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
