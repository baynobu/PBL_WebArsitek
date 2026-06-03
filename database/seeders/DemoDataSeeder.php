<?php

namespace Database\Seeders;

use App\Models\LandingPageContent;
use App\Models\LogAktivitasAdmin;
use App\Models\Portofolio;
use App\Models\ProfilArsitek;
use App\Models\Proposal;
use App\Models\Proyek;
use App\Models\ProyekTask;
use App\Models\Rating;
use App\Models\User;
use App\Models\VerifikasiUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin PBL',
            'email' => 'admin@mail.com',
            'email_verified_at' => now()->subDays(18),
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone_number' => '081200000001',
            'whatsapp_number' => '081200000001',
        ]);

        $clients = [
            'rahman' => User::create([
                'name' => 'Rahman Saputra',
                'email' => 'rahman@mail.com',
                'email_verified_at' => now()->subDays(14),
                'password' => Hash::make('password'),
                'role' => 'client',
                'phone_number' => '081300000101',
                'whatsapp_number' => '081300000101',
            ]),
            'maya' => User::create([
                'name' => 'Maya Andini',
                'email' => 'maya@mail.com',
                'email_verified_at' => now()->subDays(13),
                'password' => Hash::make('password'),
                'role' => 'client',
                'phone_number' => '081300000102',
                'whatsapp_number' => '081300000102',
            ]),
            'sentosa' => User::create([
                'name' => 'PT. Sentosa Property',
                'email' => 'sentosa@mail.com',
                'email_verified_at' => now()->subDays(12),
                'password' => Hash::make('password'),
                'role' => 'client',
                'phone_number' => '081300000103',
                'whatsapp_number' => '081300000103',
            ]),
            'bina' => User::create([
                'name' => 'PT. Bina Kreasi Nusantara',
                'email' => 'bina@mail.com',
                'email_verified_at' => now()->subDays(11),
                'password' => Hash::make('password'),
                'role' => 'client',
                'phone_number' => '081300000104',
                'whatsapp_number' => '081300000104',
            ]),
        ];

        $architects = [
            'nisa' => User::create([
                'name' => 'Nisa Aulia, S.Ars',
                'email' => 'nisa@mail.com',
                'email_verified_at' => now()->subDays(10),
                'password' => Hash::make('password'),
                'role' => 'arsitek',
                'phone_number' => '081400000201',
                'whatsapp_number' => '081400000201',
            ]),
            'dimas' => User::create([
                'name' => 'Dimas Pratama, IAI',
                'email' => 'dimas@mail.com',
                'email_verified_at' => now()->subDays(9),
                'password' => Hash::make('password'),
                'role' => 'arsitek',
                'phone_number' => '081400000202',
                'whatsapp_number' => '081400000202',
            ]),
            'sabrina' => User::create([
                'name' => 'Sabrina Putri, S.Ars',
                'email' => 'sabrina@mail.com',
                'email_verified_at' => now()->subDays(8),
                'password' => Hash::make('password'),
                'role' => 'arsitek',
                'phone_number' => '081400000203',
                'whatsapp_number' => '081400000203',
            ]),
            'raka' => User::create([
                'name' => 'Raka Mahendra',
                'email' => 'raka@mail.com',
                'email_verified_at' => null,
                'password' => Hash::make('password'),
                'role' => 'arsitek',
                'phone_number' => '081400000204',
                'whatsapp_number' => '081400000204',
            ]),
        ];

        foreach (['nisa', 'dimas', 'sabrina'] as $architectKey) {
            VerifikasiUser::create([
                'user_id' => $architects[$architectKey]->id,
                'status' => 'verified',
                'admin_id' => $admin->id,
                'created_at' => now()->subDays(8),
            ]);
        }

        VerifikasiUser::create([
            'user_id' => $architects['raka']->id,
            'status' => 'pending',
            'created_at' => now()->subDay(),
        ]);

        $profiles = [
            ['nisa', 'demo/profile-nisa.svg', 'Arsitek spesialis rumah tinggal tropis dan desain interior hangat dengan pendekatan human-centered.', 'AutoCAD, SketchUp, Lumion, Interior Design', '7 tahun menangani rumah tinggal, renovasi, dan interior kafe.'],
            ['dimas', 'demo/profile-dimas.svg', 'Fokus pada proyek komersial, hospitality, dan fasad bangunan modern dengan identitas kuat.', 'Revit, 3Ds Max, BIM, Facade Design', '9 tahun memimpin proyek kantor, retail, dan hospitality.'],
            ['sabrina', 'demo/profile-sabrina.svg', 'Menggabungkan estetika kontemporer dengan efisiensi ruang untuk hunian premium dan villa.', 'SketchUp, Enscape, Residential Planning', '5 tahun menangani villa, townhouse, dan proyek pengembangan properti.'],
        ];

        foreach ($profiles as [$key, $foto, $deskripsi, $skill, $pengalaman]) {
            ProfilArsitek::create([
                'user_id' => $architects[$key]->id,
                'foto' => $foto,
                'deskripsi' => $deskripsi,
                'skill' => $skill,
                'pengalaman' => $pengalaman,
            ]);
        }

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
                'client_id' => $clients['rahman']->id,
                'judul' => 'Desain Rumah Tinggal Minimalis 2 Lantai',
                'deskripsi' => 'Rumah tinggal 2 lantai dengan area kerja kecil, taman belakang, dan nuansa minimalis modern.',
                'budget' => 8500000,
                'deadline' => now()->addDays(18)->toDateString(),
                'lokasi' => 'Malang',
                'status' => 'open',
                'open_at' => now()->subDays(3),
                'open_until' => now()->addDays(15),
                'open_duration_days' => 18,
                'progress_percent' => 0,
                'progress_note' => 'Menunggu proposal arsitek terbaik.',
                'progress_updated_at' => now()->subDay(),
                'is_featured' => true,
                'is_hidden' => false,
            ]),
            'cafe' => Proyek::create([
                'client_id' => $clients['maya']->id,
                'judul' => 'Renovasi Cafe Industrial',
                'deskripsi' => 'Renovasi cafe agar lebih instagrammable, efisien, dan cocok untuk target anak muda.',
                'budget' => 12000000,
                'deadline' => now()->addDays(24)->toDateString(),
                'lokasi' => 'Surabaya',
                'status' => 'open',
                'open_at' => now()->subDays(5),
                'open_until' => now()->addDays(19),
                'open_duration_days' => 24,
                'progress_percent' => 0,
                'progress_note' => 'Brief awal sudah dibagikan ke kandidat arsitek.',
                'progress_updated_at' => now()->subDay(),
                'is_featured' => true,
                'is_hidden' => false,
            ]),
            'kantor' => Proyek::create([
                'client_id' => $clients['rahman']->id,
                'judul' => 'Interior Kantor Start-up',
                'deskripsi' => 'Desain interior kantor start-up yang modern, terbuka, dan nyaman untuk kolaborasi tim.',
                'budget' => 15000000,
                'deadline' => now()->addDays(21)->toDateString(),
                'lokasi' => 'Bandung',
                'status' => 'progress',
                'arsitek_terpilih_id' => $architects['nisa']->id,
                'open_at' => now()->subDays(14),
                'open_until' => now()->subDays(7),
                'open_duration_days' => 7,
                'progress_percent' => 70,
                'progress_note' => 'Layout final dan material board sedang dipersiapkan.',
                'progress_updated_at' => now()->subHours(12),
                'is_featured' => false,
                'is_hidden' => false,
            ]),
            'ruko' => Proyek::create([
                'client_id' => $clients['sentosa']->id,
                'judul' => 'Ruko 2 Lantai Modern',
                'deskripsi' => 'Ruko komersial 2 lantai dengan fasad modern dan layout yang mendukung aktivitas bisnis.',
                'budget' => 18000000,
                'deadline' => now()->subDays(8)->toDateString(),
                'lokasi' => 'Yogyakarta',
                'status' => 'done',
                'arsitek_terpilih_id' => $architects['dimas']->id,
                'open_at' => now()->subDays(42),
                'open_until' => now()->subDays(32),
                'open_duration_days' => 10,
                'progress_percent' => 100,
                'progress_note' => 'Serah terima desain dan dokumen teknis sudah selesai.',
                'progress_updated_at' => now()->subDays(4),
                'is_featured' => false,
                'is_hidden' => false,
                'moderated_by' => $admin->id,
                'moderated_at' => now()->subDays(4),
                'moderation_note' => 'Proyek selesai dan layak ditampilkan sebagai portofolio publik.',
            ]),
            'villa' => Proyek::create([
                'client_id' => $clients['maya']->id,
                'judul' => 'Masterplan Villa Kontemporer',
                'deskripsi' => 'Masterplan villa kontemporer dengan landscape, kolam renang, dan ruang santai outdoor.',
                'budget' => 25000000,
                'deadline' => now()->addDays(38)->toDateString(),
                'lokasi' => 'Bali',
                'status' => 'open',
                'open_at' => now()->subDays(2),
                'open_until' => now()->addDays(36),
                'open_duration_days' => 38,
                'progress_percent' => 0,
                'progress_note' => 'Proyek baru dipublikasikan ke marketplace.',
                'progress_updated_at' => now()->subHours(8),
                'is_featured' => true,
                'is_hidden' => false,
            ]),
            'showroom' => Proyek::create([
                'client_id' => $clients['bina']->id,
                'judul' => 'Showroom Produk Interior',
                'deskripsi' => 'Showroom interior dengan display modular, jalur pengunjung nyaman, dan pencahayaan hangat.',
                'budget' => 20000000,
                'deadline' => now()->addDays(27)->toDateString(),
                'lokasi' => 'Jakarta',
                'status' => 'open',
                'open_at' => now()->subDays(4),
                'open_until' => now()->addDays(23),
                'open_duration_days' => 27,
                'progress_percent' => 0,
                'progress_note' => 'Menunggu shortlist proposal dari arsitek terverifikasi.',
                'progress_updated_at' => now()->subHours(6),
                'is_featured' => false,
                'is_hidden' => false,
            ]),
            'klinik' => Proyek::create([
                'client_id' => $clients['sentosa']->id,
                'judul' => 'Renovasi Klinik Estetik Modern',
                'deskripsi' => 'Renovasi klinik dengan fokus pada kenyamanan pasien, alur ruang, dan identitas visual premium.',
                'budget' => 22000000,
                'deadline' => now()->addDays(32)->toDateString(),
                'lokasi' => 'Semarang',
                'status' => 'progress',
                'arsitek_terpilih_id' => $architects['sabrina']->id,
                'open_at' => now()->subDays(19),
                'open_until' => now()->subDays(9),
                'open_duration_days' => 10,
                'progress_percent' => 60,
                'progress_note' => 'Konsep interior dan zoning layanan sudah disetujui client.',
                'progress_updated_at' => now()->subHours(20),
                'is_featured' => false,
                'is_hidden' => false,
            ]),
        ];

        $proposalRows = [
            [$projects['rumah']->id, $architects['nisa']->id, 7800000, 14, 'Pendekatan desain menekankan pencahayaan alami, ventilasi silang, dan efisiensi ruang keluarga.', 'pending', now()->subDays(9)],
            [$projects['rumah']->id, $architects['sabrina']->id, 8200000, 16, 'Konsep fasad bersih dengan ruang tengah yang lebih terbuka dan modern.', 'pending', now()->subDays(8)],
            [$projects['cafe']->id, $architects['dimas']->id, 11000000, 21, 'Konsep industrial hangat dengan area foto, bar utama, dan sirkulasi efektif.', 'pending', now()->subDays(7)],
            [$projects['cafe']->id, $architects['sabrina']->id, 11800000, 24, 'Nuansa industrial dipadukan elemen premium agar lebih menonjol di media sosial.', 'pending', now()->subDays(6)],
            [$projects['villa']->id, $architects['nisa']->id, 22000000, 30, 'Masterplan villa dengan zona privat, semi publik, dan area landscape seimbang.', 'pending', now()->subDays(5)],
            [$projects['showroom']->id, $architects['dimas']->id, 19500000, 20, 'Layout showroom modular dengan fokus pada pengalaman pengunjung dan branding.', 'pending', now()->subDays(4)],
            [$projects['kantor']->id, $architects['nisa']->id, 14000000, 18, 'Ruang kolaborasi fleksibel, area kerja terbuka, dan material yang clean.', 'accepted', now()->subDays(12)],
            [$projects['kantor']->id, $architects['dimas']->id, 15200000, 20, 'Usulan alternatif yang lebih corporate dan cocok untuk tim bertumbuh.', 'rejected', now()->subDays(11)],
            [$projects['ruko']->id, $architects['dimas']->id, 17500000, 25, 'Fasad modern, area komersial efisien, dan material yang mudah dirawat.', 'accepted', now()->subDays(20)],
            [$projects['ruko']->id, $architects['sabrina']->id, 18200000, 26, 'Alternatif tampilan ruko dengan aksen premium untuk meningkatkan nilai jual.', 'rejected', now()->subDays(19)],
            [$projects['klinik']->id, $architects['sabrina']->id, 21000000, 24, 'Alur ruang pasien lebih nyaman dengan konsep interior estetik dan higienis.', 'accepted', now()->subDays(15)],
            [$projects['klinik']->id, $architects['dimas']->id, 21400000, 25, 'Pendekatan klinik modern dengan area tunggu yang lebih efisien.', 'rejected', now()->subDays(14)],
        ];

        foreach ($proposalRows as [$projectId, $architectId, $price, $days, $description, $status, $createdAt]) {
            Proposal::create([
                'proyek_id' => $projectId,
                'arsitek_id' => $architectId,
                'harga_tawaran' => $price,
                'estimasi_waktu' => $days,
                'deskripsi' => $description,
                'status' => $status,
                'created_at' => $createdAt,
            ]);
        }

        $taskRows = [
            [$projects['kantor']->id, [
                ['Konfirmasi brief ruang kerja', 'Client dan arsitek menyepakati kebutuhan utama ruang.', 2, true, $architects['nisa']->id],
                ['Finalisasi layout zona kerja', 'Membagi area kerja, meeting, dan lounge.', 3, true, $architects['nisa']->id],
                ['Preview material board', 'Menentukan palet warna dan material utama.', 2, true, $architects['nisa']->id],
                ['Revisi akhir presentasi', 'Menyesuaikan presentasi final sebelum serah konsep.', 3, false, null],
            ]],
            [$projects['ruko']->id, [
                ['Survey existing building', 'Cek kondisi lapangan dan pengukuran awal.', 2, true, $architects['dimas']->id],
                ['Konsep fasad final', 'Menyepakati arah tampilan bangunan.', 3, true, $architects['dimas']->id],
                ['Gambar kerja struktur', 'Menyusun detail teknis struktur dan bukaan.', 3, true, $architects['dimas']->id],
                ['Serah terima dokumen', 'Dokumen final diserahkan ke client.', 2, true, $architects['dimas']->id],
            ]],
            [$projects['klinik']->id, [
                ['Review alur pasien', 'Menyusun flow area tunggu, konsultasi, dan tindakan.', 3, true, $architects['sabrina']->id],
                ['Moodboard interior', 'Menentukan tone warna dan material utama.', 2, true, $architects['sabrina']->id],
                ['Layout ruang tindakan', 'Menentukan penempatan ruang tindakan dan storage.', 3, false, null],
                ['Revisi signage', 'Penyesuaian identitas visual klinik.', 2, false, null],
            ]],
        ];

        foreach ($taskRows as [$projectId, $tasks]) {
            foreach ($tasks as [$title, $description, $weight, $isDone, $doneBy]) {
                ProyekTask::create([
                    'proyek_id' => $projectId,
                    'title' => $title,
                    'description' => $description,
                    'weight' => $weight,
                    'is_done' => $isDone,
                    'done_at' => $isDone ? now()->subDays(3) : null,
                    'done_by' => $doneBy,
                ]);
            }
        }

        $projects['kantor']->recalculateProgress();
        $projects['ruko']->recalculateProgress();
        $projects['klinik']->recalculateProgress();

        Rating::create([
            'proyek_id' => $projects['ruko']->id,
            'arsitek_id' => $architects['dimas']->id,
            'client_id' => $clients['sentosa']->id,
            'nilai' => 5,
            'komentar' => 'Komunikasi sangat jelas, hasil desain rapi, dan sesuai target bisnis kami.',
            'created_at' => now()->subDays(2),
        ]);

        Rating::create([
            'proyek_id' => $projects['kantor']->id,
            'arsitek_id' => $architects['nisa']->id,
            'client_id' => $clients['rahman']->id,
            'nilai' => 4,
            'komentar' => 'Desainnya bagus, modern, dan sangat membantu proses presentasi internal.',
            'created_at' => now()->subDay(),
        ]);

        $landingContents = [
            ['hero', 'badge', '🏗️ Marketplace Lowongan Kerja Arsitek Profesional', 'text', 1],
            ['hero', 'title_part_1', 'Hubungkan Ide', 'text', 2],
            ['hero', 'title_part_2', 'Dengan Talenta Arsitek', 'text', 3],
            ['hero', 'subtitle', 'Platform terpercaya untuk menemukan, merekrut, dan berkolaborasi dengan arsitek profesional berbasis proyek kontrak dan freelance.', 'text', 4],
            ['hero', 'primary_cta', 'Mulai Sekarang', 'text', 5],
            ['hero', 'secondary_cta', 'Login', 'text', 6],
            ['stats', 'projects_count', '100+ Lowongan Proyek', 'text', 1],
            ['stats', 'architect_count', '250+ Arsitek Profesional', 'text', 2],
            ['stats', 'rating_score', '4.8/5 Rating', 'text', 3],
            ['feature', 'account_role', 'Daftar sebagai Arsitek, Client, atau Admin. Verifikasi akun untuk keamanan maksimal.', 'text', 1],
            ['feature', 'marketplace', 'Client posting lowongan dengan judul, deskripsi, budget, deadline, dan lokasi yang jelas.', 'text', 2],
            ['feature', 'proposal_system', 'Arsitek submit proposal dengan harga, durasi, dan penawaran unik mereka untuk setiap proyek.', 'text', 3],
            ['feature', 'progress_tracking', 'Progress proyek dipantau melalui checklist task sehingga status kerja lebih transparan.', 'text', 4],
        ];

        foreach ($landingContents as [$section, $key, $value, $type, $sortOrder]) {
            LandingPageContent::create([
                'section' => $section,
                'key' => $key,
                'value' => $value,
                'type' => $type,
                'sort_order' => $sortOrder,
                'is_active' => true,
            ]);
        }

        LogAktivitasAdmin::create([
            'admin_id' => $admin->id,
            'aktivitas' => 'Meninjau data demo marketplace arsitek dan progress proyek',
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
            'aktivitas' => 'Memastikan data proposal, task progress, dan rating demo tersedia',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Seeder Demo',
        ]);
    }
}
