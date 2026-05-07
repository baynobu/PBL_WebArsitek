<?php

namespace Database\Seeders;

use App\Models\VerifikasiUser;
use App\Models\User;
use Illuminate\Database\Seeder;

class VerifikasiUserSeeder extends Seeder
{
    public function run()
    {
        $arsitek = User::where('role', 'arsitek')->first();
        if ($arsitek) {
            VerifikasiUser::create([
                'user_id' => $arsitek->id,
                'status' => 'verified'
            ]);
        }
    }
}
