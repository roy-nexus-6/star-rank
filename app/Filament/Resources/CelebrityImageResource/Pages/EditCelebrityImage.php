<?php

namespace App\Filament\Resources\CelebrityImageResource\Pages;

use App\Filament\Resources\CelebrityImageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCelebrityImage extends EditRecord
{
    protected static string $resource = CelebrityImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
