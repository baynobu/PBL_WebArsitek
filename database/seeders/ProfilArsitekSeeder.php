<?php

namespace Database\Seeders;

use App\Models\ProfilArsitek;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProfilArsitekSeeder extends Seeder
{
    public function run()
    {
        $arsitek = User::where('role', 'arsitek')->first();
        if ($arsitek) {
            ProfilArsitek::create([
                'user_id' => $arsitek->id,
                'foto' => 'foto.jpg',
                'deskripsi' => 'Arsitek profesional, berpengalaman di desain interior dan rumah tinggal.',
                'skill' => 'AutoCAD, SketchUp',
                'pengalaman' => '3 tahun bekerja di studio desain.'
            ]);
        }
    }
}
