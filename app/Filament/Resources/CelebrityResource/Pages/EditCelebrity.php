<?php

namespace App\Filament\Resources\CelebrityResource\Pages;

use App\Filament\Resources\CelebrityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCelebrity extends EditRecord
{
    protected static string $resource = CelebrityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
