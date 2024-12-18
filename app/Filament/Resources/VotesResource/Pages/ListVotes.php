<?php

namespace App\Filament\Resources\VoteResource\Pages;

use App\Filament\Resources\VoteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVote extends ListRecords
{
    protected static string $resource = VoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
