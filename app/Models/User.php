<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Panel;

#[Fillable(['name', 'email', 'password', 'role', 'phone_number', 'whatsapp_number'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function profilArsitek()
    {
        return $this->hasOne(ProfilArsitek::class, 'user_id');
    }

    public function portofolio()
    {
        return $this->hasMany(Portofolio::class, 'user_id');
    }

    public function proyek()
    {
        return $this->hasMany(Proyek::class, 'client_id');
    }

    public function proposal()
    {
        return $this->hasMany(Proposal::class, 'arsitek_id');
    }

    public function verifikasiUser()
    {
        return $this->hasOne(VerifikasiUser::class, 'user_id');
    }

    public function logAktivitasAdmin()
    {
        return $this->hasMany(LogAktivitasAdmin::class, 'admin_id');
    }

    public function ratingSebagaiArsitek()
    {
        return $this->hasMany(Rating::class, 'arsitek_id');
    }

    public function ratingSebagaiClient()
    {
        return $this->hasMany(Rating::class, 'client_id');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
