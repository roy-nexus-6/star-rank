<?php

namespace App\Filament\Resources\CelebrityResource\Pages;

use App\Filament\Resources\CelebrityResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCelebrities extends ListRecords
{
    protected static string $resource = CelebrityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
