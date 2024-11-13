<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CelebrityResource\Pages;
use App\Filament\Resources\CelebrityResource\RelationManagers;
use App\Models\Celebrity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CelebrityResource extends Resource
{
    protected static ?string $model = Celebrity::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required() // 必須フィールド
                    ->maxLength(255)
                    ->label('名前'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('名前')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListCelebrities::route('/'),
            'create' => Pages\CreateCelebrity::route('/create'),
            'edit' => Pages\EditCelebrity::route('/{record}/edit'),
        ];
    }
}
