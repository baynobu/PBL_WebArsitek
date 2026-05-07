<?php

namespace Database\Seeders;

use App\Models\Rating;
use App\Models\Proyek;
use App\Models\User;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    public function run()
    {
        $proyek = Proyek::first();
        $arsitek = User::where('role', 'arsitek')->first();
        $client = User::where('role', 'client')->first();
        if ($proyek && $arsitek && $client) {
            Rating::create([
                'proyek_id' => $proyek->id,
                'arsitek_id' => $arsitek->id,
                'client_id' => $client->id,
                'nilai' => 5,
                'komentar' => 'Bagus'
            ]);
        }
    }
}
