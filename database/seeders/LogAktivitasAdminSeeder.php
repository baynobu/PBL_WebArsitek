<?php

namespace Database\Seeders;

use App\Models\LogAktivitasAdmin;
use App\Models\User;
use Illuminate\Database\Seeder;

class LogAktivitasAdminSeeder extends Seeder
{
    public function run()
    {
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            LogAktivitasAdmin::create([
                'admin_id' => $admin->id,
                'aktivitas' => 'Menguji seeders',
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Seeder'
            ]);
        }
    }
}
