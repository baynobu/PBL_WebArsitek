<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VerifikasiUserResource\Pages;
use App\Models\LogAktivitasAdmin;
use App\Models\User;
use App\Models\VerifikasiUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Action;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class VerifikasiUserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-identification';
    protected static ?string $navigationLabel = 'Verifikasi User';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama')->searchable(),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('role')->label('Role')->sortable(),
                TextColumn::make('created_at')->label('Terdaftar')->dateTime(),
            ])
            ->actions([
                Action::make('approve')
                    ->label('Approve')
                    ->requiresConfirmation()
                    ->color('success')
                    ->action(function (User $record) {
                        $record->email_verified_at = Carbon::now();
                        $record->save();

                        // update verifikasi_user record if exists
                        $ver = $record->verifikasiUser;
                        if ($ver instanceof VerifikasiUser) {
                            $ver->status = 'verified';
                            $ver->admin_id = Auth::id();
                            $ver->save();
                        }

                        // log admin activity
                        $log = new LogAktivitasAdmin();
                        $log->admin_id = Auth::id();
                        $log->aktivitas = 'Approved verification for user_id: ' . $record->id;
                        $log->ip_address = Request::ip();
                        $log->user_agent = Request::userAgent();
                        $log->save();
                    }),
                Action::make('reject')
                    ->label('Reject')
                    ->requiresConfirmation()
                    ->color('danger')
                    ->action(function (User $record) {
                        // For reject, we can ensure email_verified_at stays null and optionally log
                        $record->email_verified_at = null;
                        $record->save();

                        $ver = $record->verifikasiUser;
                        if ($ver instanceof VerifikasiUser) {
                            $ver->status = 'rejected';
                            $ver->admin_id = Auth::id();
                            $ver->save();
                        }

                        $log = new LogAktivitasAdmin();
                        $log->admin_id = Auth::id();
                        $log->aktivitas = 'Rejected verification for user_id: ' . $record->id;
                        $log->ip_address = Request::ip();
                        $log->user_agent = Request::userAgent();
                        $log->save();
                    }),
            ])
            ->filters([]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereNull('email_verified_at');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVerifikasiUsers::route('/'),
        ];
    }
}
