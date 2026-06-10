<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VerifikasiUser;
use App\Models\Proyek;
use App\Models\Proposal;
use App\Models\LandingPageContent;
use App\Models\LogAktivitasAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard with tabbed content.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        $tab = $request->query('tab', 'dashboard');

        // Tab 1: Dashboard Overview Data
        $totalProyekPlatform = Proyek::count();
        $unmoderatedProjects = Proyek::with('client')
            ->whereNull('moderated_at')
            ->latest()
            ->get();
        $proyekPendingModerasi = $unmoderatedProjects->count();

        $totalProposalSistem = Proposal::count();
        $recentProposals = Proposal::with(['arsitek', 'proyek'])
            ->latest()
            ->limit(5)
            ->get();

        // Tab 2: User Verification List (Unverified users)
        $unverifiedUsers = User::with('verifikasiUser')
            ->whereNull('email_verified_at')
            ->where('role', '!=', 'admin')
            ->latest()
            ->get();

        // Tab 3: Projects List (All projects for management)
        $allProjects = Proyek::with(['client', 'arsitekTerpilih'])
            ->latest()
            ->paginate(15, ['*'], 'projects_page')
            ->withQueryString();

        // Tab 4: Landing Page Contents List
        $landingContents = LandingPageContent::orderBy('section')
            ->orderBy('sort_order')
            ->get();

        return view('dashboard', compact(
            'user',
            'tab',
            'totalProyekPlatform',
            'unmoderatedProjects',
            'proyekPendingModerasi',
            'totalProposalSistem',
            'recentProposals',
            'unverifiedUsers',
            'allProjects',
            'landingContents'
        ));
    }

    /**
     * Approve user verification.
     */
    public function approveUser(Request $request, User $user)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $user->email_verified_at = Carbon::now();
        $user->save();

        $ver = $user->verifikasiUser;
        if ($ver) {
            $ver->status = 'verified';
            $ver->admin_id = Auth::id();
            $ver->save();
        } else {
            VerifikasiUser::create([
                'user_id' => $user->id,
                'status' => 'verified',
                'admin_id' => Auth::id(),
                'created_at' => Carbon::now()
            ]);
        }

        // Log admin activity
        LogAktivitasAdmin::create([
            'admin_id' => Auth::id(),
            'aktivitas' => 'Menyetujui verifikasi untuk pengguna: ' . $user->name . ' (ID: ' . $user->id . ')',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return redirect()->route('dashboard', ['tab' => 'users'])->with('success', 'Pengguna berhasil diverifikasi.');
    }

    /**
     * Reject user verification.
     */
    public function rejectUser(Request $request, User $user)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $user->email_verified_at = null;
        $user->save();

        $ver = $user->verifikasiUser;
        if ($ver) {
            $ver->status = 'rejected';
            $ver->admin_id = Auth::id();
            $ver->save();
        } else {
            VerifikasiUser::create([
                'user_id' => $user->id,
                'status' => 'rejected',
                'admin_id' => Auth::id(),
                'created_at' => Carbon::now()
            ]);
        }

        // Log admin activity
        LogAktivitasAdmin::create([
            'admin_id' => Auth::id(),
            'aktivitas' => 'Menolak verifikasi untuk pengguna: ' . $user->name . ' (ID: ' . $user->id . ')',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return redirect()->route('dashboard', ['tab' => 'users'])->with('success', 'Verifikasi pengguna berhasil ditolak.');
    }

    /**
     * Toggle project featured status.
     */
    public function toggleProjectFeatured(Request $request, Proyek $proyek)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $proyek->is_featured = !$proyek->is_featured;
        $proyek->moderated_by = Auth::id();
        $proyek->moderated_at = Carbon::now();
        $proyek->save();

        // Log activity
        LogAktivitasAdmin::create([
            'admin_id' => Auth::id(),
            'aktivitas' => 'Mengubah status featured proyek "' . $proyek->judul . '" menjadi: ' . ($proyek->is_featured ? 'Ya' : 'Tidak'),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return redirect()->route('dashboard', ['tab' => 'projects'])->with('success', 'Status featured proyek berhasil diperbarui.');
    }

    /**
     * Toggle project hidden status.
     */
    public function toggleProjectHidden(Request $request, Proyek $proyek)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $proyek->is_hidden = !$proyek->is_hidden;
        $proyek->moderated_by = Auth::id();
        $proyek->moderated_at = Carbon::now();
        $proyek->save();

        // Log activity
        LogAktivitasAdmin::create([
            'admin_id' => Auth::id(),
            'aktivitas' => 'Mengubah visibilitas proyek "' . $proyek->judul . '" menjadi: ' . ($proyek->is_hidden ? 'Sembunyi' : 'Tampil'),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return redirect()->route('dashboard', ['tab' => 'projects'])->with('success', 'Visibilitas proyek berhasil diperbarui.');
    }

    /**
     * Store new landing page content.
     */
    public function storeLandingContent(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $data = $request->validate([
            'section' => 'required|string|in:hero,stats,feature,footer,other',
            'key' => 'required|string|max:100|unique:landing_page_contents,key',
            'value' => 'required|string',
            'type' => 'required|string|in:text,html,number',
            'sort_order' => 'required|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->has('is_active');

        LandingPageContent::create($data);

        // Log activity
        LogAktivitasAdmin::create([
            'admin_id' => Auth::id(),
            'aktivitas' => 'Menambahkan konten landing page baru dengan key: ' . $data['key'],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return redirect()->route('dashboard', ['tab' => 'landing'])->with('success', 'Konten landing page berhasil ditambahkan.');
    }

    /**
     * Update landing page content.
     */
    public function updateLandingContent(Request $request, LandingPageContent $content)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $data = $request->validate([
            'section' => 'required|string|in:hero,stats,feature,footer,other',
            'key' => 'required|string|max:100|unique:landing_page_contents,key,' . $content->id,
            'value' => 'required|string',
            'type' => 'required|string|in:text,html,number',
            'sort_order' => 'required|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->has('is_active');

        $content->update($data);

        // Log activity
        LogAktivitasAdmin::create([
            'admin_id' => Auth::id(),
            'aktivitas' => 'Memperbarui konten landing page dengan key: ' . $content->key,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return redirect()->route('dashboard', ['tab' => 'landing'])->with('success', 'Konten landing page berhasil diperbarui.');
    }

    /**
     * Destroy landing page content.
     */
    public function destroyLandingContent(Request $request, LandingPageContent $content)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $key = $content->key;
        $content->delete();

        // Log activity
        LogAktivitasAdmin::create([
            'admin_id' => Auth::id(),
            'aktivitas' => 'Menghapus konten landing page dengan key: ' . $key,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return redirect()->route('dashboard', ['tab' => 'landing'])->with('success', 'Konten landing page berhasil dihapus.');
    }
}
