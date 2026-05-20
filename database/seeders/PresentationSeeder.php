<?php

namespace Database\Seeders;

use App\Models\LogAktivitasAdmin;
use App\Models\Portofolio;
use App\Models\ProfilArsitek;
use App\Models\Proposal;
use App\Models\Proyek;
use App\Models\Rating;
use App\Models\User;
use App\Models\VerifikasiUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PresentationSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin PBL',
            'email' => 'admin@mail.com',
            'email_verified_at' => now()->subDays(10),
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $clients = [
            User::create([
                'name' => 'Rahman Saputra',
                'email' => 'rahman@mail.com',
                'email_verified_at' => now()->subDays(8),
                'password' => Hash::make('password'),
                'role' => 'client',
            ]),
            User::create([
                'name' => 'Maya Andini',
                'email' => 'maya@mail.com',
                'email_verified_at' => now()->subDays(7),
                'password' => Hash::make('password'),
                'role' => 'client',
            ]),
            User::create([
                'name' => 'PT. Sentosa Property',
                'email' => 'sentosa@mail.com',
                'email_verified_at' => now()->subDays(6),
                'password' => Hash::make('password'),
                'role' => 'client',
            ]),
        ];

        $architects = [
            'nisa' => User::create([
                'name' => 'Nisa Aulia, S.Ars',
                'email' => 'nisa@mail.com',
                'email_verified_at' => now()->subDays(5),
                'password' => Hash::make('password'),
                'role' => 'arsitek',
            ]),
            'dimas' => User::create([
                'name' => 'Dimas Pratama, IAI',
                'email' => 'dimas@mail.com',
                'email_verified_at' => now()->subDays(4),
                'password' => Hash::make('password'),
                'role' => 'arsitek',
            ]),
            'sabrina' => User::create([
                'name' => 'Sabrina Putri, S.Ars',
                'email' => 'sabrina@mail.com',
                'email_verified_at' => now()->subDays(3),
                'password' => Hash::make('password'),
                'role' => 'arsitek',
            ]),
            'raka' => User::create([
                'name' => 'Raka Mahendra',
                'email' => 'raka@mail.com',
                'email_verified_at' => null,
                'password' => Hash::make('password'),
                'role' => 'arsitek',
            ]),
        ];

        VerifikasiUser::create([
            'user_id' => $architects['nisa']->id,
            'status' => 'verified',
            'admin_id' => $admin->id,
            'created_at' => now()->subDays(5),
        ]);

        VerifikasiUser::create([
            'user_id' => $architects['dimas']->id,
            'status' => 'verified',
            'admin_id' => $admin->id,
            'created_at' => now()->subDays(4),
        ]);

        VerifikasiUser::create([
            'user_id' => $architects['sabrina']->id,
            'status' => 'verified',
            'admin_id' => $admin->id,
            'created_at' => now()->subDays(3),
        ]);

        VerifikasiUser::create([
            'user_id' => $architects['raka']->id,
            'status' => 'pending',
            'created_at' => now()->subDays(1),
        ]);

        ProfilArsitek::create([
            'user_id' => $architects['nisa']->id,
            'foto' => 'demo/profile-nisa.svg',
            'deskripsi' => 'Arsitek spesialis rumah tinggal tropis dan desain interior hangat dengan pendekatan human-centered.',
            'skill' => 'AutoCAD, SketchUp, Lumion, Interior Design',
            'pengalaman' => '7 tahun menangani rumah tinggal, renovasi, dan interior kafe.',
        ]);

        ProfilArsitek::create([
            'user_id' => $architects['dimas']->id,
            'foto' => 'demo/profile-dimas.svg',
            'deskripsi' => 'Fokus pada proyek komersial, hospitality, dan fasad bangunan modern dengan identitas kuat.',
            'skill' => 'Revit, 3Ds Max, BIM, Facade Design',
            'pengalaman' => '9 tahun memimpin proyek kantor, retail, dan hospitality.',
        ]);

        ProfilArsitek::create([
            'user_id' => $architects['sabrina']->id,
            'foto' => 'demo/profile-sabrina.svg',
            'deskripsi' => 'Menggabungkan estetika kontemporer dengan efisiensi ruang untuk hunian premium dan villa.',
            'skill' => 'SketchUp, Enscape, Residential Planning',
            'pengalaman' => '5 tahun menangani villa, townhouse, dan proyek pengembangan properti.',
        ]);

        $portfolioData = [
            [$architects['nisa']->id, 'Rumah Tinggal Tropis', 'Desain rumah dengan pencahayaan alami dan sirkulasi udara maksimal.', 'demo/portfolio-1.svg', 'Rumah Tinggal'],
            [$architects['nisa']->id, 'Interior Ruang Keluarga', 'Penataan ruang keluarga modern yang hangat dan fungsional.', 'demo/portfolio-2.svg', 'Interior'],
            [$architects['dimas']->id, 'Cafe Industrial Hangout', 'Konsep cafe industrial dengan lighting dramatis dan layout efisien.', 'demo/portfolio-3.svg', 'Komersial'],
            [$architects['dimas']->id, 'Kantor Start-up Modern', 'Workspace terbuka dengan nuansa profesional dan fleksibel.', 'demo/portfolio-4.svg', 'Kantor'],
            [$architects['sabrina']->id, 'Villa Kontemporer', 'Villa premium dengan bukaan lebar dan teras semi outdoor.', 'demo/portfolio-5.svg', 'Villa'],
            [$architects['sabrina']->id, 'Fasad Rumah Premium', 'Perancangan fasad yang menonjolkan karakter elegan dan bersih.', 'demo/portfolio-6.svg', 'Fasad'],
        ];

        foreach ($portfolioData as [$userId, $judul, $deskripsi, $gambar, $kategori]) {
            Portofolio::create([
                'user_id' => $userId,
                'judul' => $judul,
                'deskripsi' => $deskripsi,
                'gambar' => $gambar,
                'kategori' => $kategori,
            ]);
        }

        $projects = [
            'rumah' => Proyek::create([
                'client_id' => $clients[0]->id,
                'judul' => 'Desain Rumah Tinggal Minimalis 2 Lantai',
                'deskripsi' => 'Membutuhkan desain rumah tinggal 2 lantai dengan area kerja kecil, taman belakang, dan nuansa minimalis modern.',
                'budget' => 8500000,
                'deadline' => now()->addDays(20)->toDateString(),
                'lokasi' => 'Malang',
                'status' => 'open',
            ]),
            'cafe' => Proyek::create([
                'client_id' => $clients[1]->id,
                'judul' => 'Renovasi Cafe Industrial',
                'deskripsi' => 'Renovasi cafe yang sudah berjalan agar lebih instagrammable, efisien, dan cocok untuk target anak muda.',
                'budget' => 12000000,
                'deadline' => now()->addDays(30)->toDateString(),
                'lokasi' => 'Surabaya',
                'status' => 'open',
            ]),
            'kantor' => Proyek::create([
                'client_id' => $clients[0]->id,
                'judul' => 'Interior Kantor Start-up',
                'deskripsi' => 'Pencarian arsitek untuk desain interior kantor start-up yang modern, terbuka, dan nyaman untuk kolaborasi.',
                'budget' => 15000000,
                'deadline' => now()->addDays(25)->toDateString(),
                'lokasi' => 'Bandung',
                'status' => 'progress',
                'arsitek_terpilih_id' => $architects['nisa']->id,
            ]),
            'ruko' => Proyek::create([
                'client_id' => $clients[2]->id,
                'judul' => 'Ruko 2 Lantai Modern',
                'deskripsi' => 'Proyek ruko komersial 2 lantai dengan fasad modern dan layout yang mendukung aktivitas bisnis.',
                'budget' => 18000000,
                'deadline' => now()->subDays(5)->toDateString(),
                'lokasi' => 'Yogyakarta',
                'status' => 'done',
                'arsitek_terpilih_id' => $architects['dimas']->id,
            ]),
            'villa' => Proyek::create([
                'client_id' => $clients[1]->id,
                'judul' => 'Masterplan Villa Kontemporer',
                'deskripsi' => 'Pembuatan masterplan villa kontemporer dengan landscape, kolam renang, dan ruang santai outdoor.',
                'budget' => 25000000,
                'deadline' => now()->addDays(45)->toDateString(),
                'lokasi' => 'Bali',
                'status' => 'open',
            ]),
        ];

        $proposalOpen = [
            [$projects['rumah']->id, $architects['nisa']->id, 7800000, 14, 'Pendekatan desain fokus pada pencahayaan alami, ventilasi silang, dan efisiensi ruang keluarga.'],
            [$projects['rumah']->id, $architects['sabrina']->id, 8200000, 16, 'Mengusulkan konsep fasad bersih dengan ruang tengah yang lebih terbuka dan modern.'],
            [$projects['cafe']->id, $architects['dimas']->id, 11000000, 21, 'Konsep industrial hangat dengan area foto, bar utama, dan jalur sirkulasi yang lebih efektif.'],
            [$projects['cafe']->id, $architects['sabrina']->id, 11800000, 24, 'Menggabungkan nuansa industrial dengan elemen premium agar lebih menonjol di media sosial.'],
            [$projects['villa']->id, $architects['nisa']->id, 22000000, 30, 'Masterplan villa dengan pembagian zona privat, semi publik, dan area landscape yang seimbang.'],
        ];

        foreach ($proposalOpen as [$projectId, $architectId, $price, $days, $description]) {
            Proposal::create([
                'proyek_id' => $projectId,
                'arsitek_id' => $architectId,
                'harga_tawaran' => $price,
                'estimasi_waktu' => $days,
                'deskripsi' => $description,
                'status' => 'pending',
                'created_at' => now()->subDays(random_int(1, 9)),
            ]);
        }

        Proposal::create([
            'proyek_id' => $projects['kantor']->id,
            'arsitek_id' => $architects['nisa']->id,
            'harga_tawaran' => 14000000,
            'estimasi_waktu' => 18,
            'deskripsi' => 'Proposal desain interior kantor yang menekankan ruang kolaborasi, area kerja fleksibel, dan nuansa profesional.',
            'status' => 'accepted',
            'created_at' => now()->subDays(12),
        ]);

        Proposal::create([
            'proyek_id' => $projects['ruko']->id,
            'arsitek_id' => $architects['dimas']->id,
            'harga_tawaran' => 17500000,
            'estimasi_waktu' => 25,
            'deskripsi' => 'Proposal desain ruko dengan fasad modern, layout komersial yang efisien, dan material mudah perawatan.',
            'status' => 'accepted',
            'created_at' => now()->subDays(20),
        ]);

        Proposal::create([
            'proyek_id' => $projects['rumah']->id,
            'arsitek_id' => $architects['dimas']->id,
            'harga_tawaran' => 9000000,
            'estimasi_waktu' => 17,
            'deskripsi' => 'Proposal alternatif untuk rumah minimalis dengan pendekatan fasad yang lebih tegas dan modern.',
            'status' => 'rejected',
            'created_at' => now()->subDays(6),
        ]);

        Rating::create([
            'proyek_id' => $projects['ruko']->id,
            'arsitek_id' => $architects['dimas']->id,
            'client_id' => $clients[2]->id,
            'nilai' => 5,
            'komentar' => 'Komunikasi sangat jelas, hasil desain rapi, dan sesuai target bisnis kami.',
            'created_at' => now()->subDays(2),
        ]);

        Rating::create([
            'proyek_id' => $projects['kantor']->id,
            'arsitek_id' => $architects['nisa']->id,
            'client_id' => $clients[0]->id,
            'nilai' => 4,
            'komentar' => 'Desainnya bagus, modern, dan sangat membantu proses presentasi internal.',
            'created_at' => now()->subDay(),
        ]);

        LogAktivitasAdmin::create([
            'admin_id' => $admin->id,
            'aktivitas' => 'Meninjau data demo verifikasi dan proyek presentasi',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Seeder Demo',
        ]);

        LogAktivitasAdmin::create([
            'admin_id' => $admin->id,
            'aktivitas' => 'Menyetujui verifikasi beberapa akun arsitek demo',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Seeder Demo',
        ]);

        LogAktivitasAdmin::create([
            'admin_id' => $admin->id,
            'aktivitas' => 'Memastikan data proposal dan rating demo tersedia untuk presentasi',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Seeder Demo',
        ]);
    }
}
