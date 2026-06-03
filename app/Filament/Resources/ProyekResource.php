<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProyekResource\Pages;
use App\Models\Proyek;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProyekResource extends Resource
{
    protected static ?string $model = Proyek::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel = 'Manajemen Proyek';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('client_id')
                ->label('Client')
                ->relationship('client', 'name')
                ->searchable()
                ->preload()
                ->required(),
            TextInput::make('judul')
                ->label('Judul')
                ->required()
                ->maxLength(100),
            Textarea::make('deskripsi')
                ->label('Deskripsi')
                ->rows(6)
                ->required(),
            TextInput::make('budget')
                ->label('Budget')
                ->numeric()
                ->required(),
            TextInput::make('deadline')
                ->label('Deadline')
                ->placeholder('YYYY-MM-DD')
                ->required(),
            TextInput::make('lokasi')
                ->label('Lokasi')
                ->maxLength(100),
            Select::make('status')
                ->label('Status')
                ->options([
                    'open' => 'Open',
                    'progress' => 'Progress',
                    'done' => 'Done',
                ])
                ->required(),
            Select::make('arsitek_terpilih_id')
                ->label('Arsitek Terpilih')
                ->relationship('arsitekTerpilih', 'name')
                ->searchable()
                ->preload()
                ->nullable(),
            DateTimePicker::make('open_at')->label('Open Sejak'),
            DateTimePicker::make('open_until')->label('Open Sampai'),
            TextInput::make('open_duration_days')
                ->label('Durasi Open (hari)')
                ->numeric()
                ->minValue(1),
            TextInput::make('progress_percent')
                ->label('Progress (%)')
                ->numeric()
                ->minValue(0)
                ->maxValue(100),
            Textarea::make('progress_note')
                ->label('Catatan Progress')
                ->rows(4),
            DateTimePicker::make('progress_updated_at')->label('Progress Diupdate'),
            Toggle::make('is_featured')->label('Featured'),
            Toggle::make('is_hidden')->label('Disembunyikan'),
            Select::make('moderated_by')
                ->label('Dimoderasi Oleh')
                ->relationship('moderatedBy', 'name')
                ->searchable()
                ->preload()
                ->nullable(),
            DateTimePicker::make('moderated_at')->label('Waktu Moderasi'),
            Textarea::make('moderation_note')
                ->label('Catatan Moderasi')
                ->rows(4),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('judul')->label('Judul')->searchable()->sortable(),
                TextColumn::make('client.name')->label('Client')->searchable(),
                TextColumn::make('status')->label('Status')->badge()->sortable(),
                TextColumn::make('progress_percent')->label('Progress')->suffix('%')->sortable(),
                TextColumn::make('open_duration_days')->label('Open')->suffix(' hari')->sortable(),
                IconColumn::make('is_featured')->label('Featured')->boolean(),
                IconColumn::make('is_hidden')->label('Hidden')->boolean(),
                TextColumn::make('deadline')->label('Deadline')->date(),
            ])
            ->filters([])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['client', 'arsitekTerpilih']);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProyeks::route('/'),
            'create' => Pages\CreateProyek::route('/create'),
            'edit' => Pages\EditProyek::route('/{record}/edit'),
        ];
    }
}
