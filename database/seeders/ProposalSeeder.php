<?php

namespace Database\Seeders;

use App\Models\Proposal;
use App\Models\Proyek;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProposalSeeder extends Seeder
{
    public function run()
    {
        $proyek = Proyek::first();
        $arsitek = User::where('role', 'arsitek')->first();
        if ($proyek && $arsitek) {
            Proposal::create([
                'proyek_id' => $proyek->id,
                'arsitek_id' => $arsitek->id,
                'harga_tawaran' => 4500000,
                'estimasi_waktu' => 14,
                'deskripsi' => 'Saya siap mengerjakan proyek ini dengan baik.',
                'status' => 'pending'
            ]);
        }
    }
}
