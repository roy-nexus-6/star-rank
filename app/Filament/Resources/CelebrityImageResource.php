<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CelebrityImageResource\Pages;
use App\Filament\Resources\CelebrityImageResource\RelationManagers;
use App\Models\CelebrityImage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CelebrityImageResource extends Resource
{
    protected static ?string $model = CelebrityImage::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('celebrity_id')
                    ->relationship('celebrity', 'name') // 芸能人を選択（リレーション）
                    ->required()
                    ->label('芸能人'),
                TextInput::make('image_path')
                    ->required()
                    ->label('画像パス')
                    ->placeholder('Google Drive の URL を入力してください'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('celebrity.name') // 芸能人名
                    ->label('芸能人')
                    ->sortable()
                    ->searchable(),
                ImageColumn::make('image_path') // 画像プレビュー
                    ->label('画像')
                    ->size(100), // サムネイルサイズを指定
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
            'index' => Pages\ListCelebrityImage::route('/'),
            'create' => Pages\CreateCelebrityImage::route('/create'),
            'edit' => Pages\EditCelebrityImage::route('/{record}/edit'),
        ];
    }
}
