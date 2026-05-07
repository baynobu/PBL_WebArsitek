<?php

namespace Database\Seeders;

use App\Models\Proyek;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProyekSeeder extends Seeder
{
    public function run()
    {
        $client = User::where('role', 'client')->first();
        if ($client) {
            Proyek::create([
                'client_id' => $client->id,
                'judul' => 'Desain Cafe',
                'deskripsi' => 'Mendesain cafe dengan konsep industrial.',
                'budget' => 5000000,
                'deadline' => '2025-02-01',
                'lokasi' => 'Malang',
                'status' => 'open'
            ]);
        }
    }
}
