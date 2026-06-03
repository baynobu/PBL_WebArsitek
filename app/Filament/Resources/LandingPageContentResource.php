<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LandingPageContentResource\Pages;
use App\Models\LandingPageContent;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LandingPageContentResource extends Resource
{
    protected static ?string $model = LandingPageContent::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Konten Landing Page';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('section')
                ->label('Section')
                ->options([
                    'hero' => 'Hero',
                    'stats' => 'Stats',
                    'feature' => 'Feature',
                    'footer' => 'Footer',
                    'other' => 'Other',
                ])
                ->searchable()
                ->required(),
            TextInput::make('key')
                ->label('Key')
                ->required()
                ->maxLength(100),
            Textarea::make('value')
                ->label('Value')
                ->rows(6)
                ->required(),
            Select::make('type')
                ->label('Type')
                ->options([
                    'text' => 'Text',
                    'html' => 'HTML',
                    'number' => 'Number',
                ])
                ->required(),
            TextInput::make('sort_order')
                ->label('Urutan')
                ->numeric()
                ->required(),
            Toggle::make('is_active')->label('Aktif'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('section')->label('Section')->sortable()->searchable(),
                TextColumn::make('key')->label('Key')->searchable(),
                TextColumn::make('type')->label('Type')->sortable(),
                TextColumn::make('sort_order')->label('Urutan')->sortable(),
                IconColumn::make('is_active')->label('Aktif')->boolean(),
                TextColumn::make('updated_at')->label('Diupdate')->dateTime(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLandingPageContents::route('/'),
            'create' => Pages\CreateLandingPageContent::route('/create'),
            'edit' => Pages\EditLandingPageContent::route('/{record}/edit'),
        ];
    }
}
