<?php

namespace Database\Seeders;

use App\Models\Portofolio;
use App\Models\User;
use Illuminate\Database\Seeder;

class PortofolioSeeder extends Seeder
{
    public function run()
    {
        $arsitek = User::where('role', 'arsitek')->first();
        if ($arsitek) {
            Portofolio::create([
                'user_id' => $arsitek->id,
                'judul' => 'Desain Rumah Minimalis',
                'deskripsi' => 'Proyek rumah tinggal dengan konsep minimalis modern.',
                'gambar' => 'rumah.jpg',
                'kategori' => 'Rumah'
            ]);
        }
    }
}
