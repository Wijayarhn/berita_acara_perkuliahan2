<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\BapVerifikasiController;
use App\Http\Controllers\Dosen\BapController as DosenBapController;
use App\Http\Controllers\Dosen\JadwalController as DosenJadwalController;
use App\Http\Controllers\Dosen\DosenReportController as DosenReportController;
use App\Http\Controllers\Admin\UserController as UserController;
use App\Http\Controllers\Mahasiswa\BapController as MahasiswaBapController;
use App\Http\Controllers\Mahasiswa\MahasiswaJadwalController as MahasiswaJadwalController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\DosenMiddleware;
use App\Http\Middleware\MahasiswaMiddleware;
// =================== REDIRECT DASHBOARD SESUAI ROLE ===================
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Dosen\DashboardController as DosenDashboardController;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboardController;

// =================== AUTH ===================
Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/', [AuthController::class, 'loginAction']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerSave'])->name('register.save');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// =================== ADMIN ===================
Route::middleware(['auth:admin', AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // 📅 Manajemen Jadwal
        Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
        Route::get('/jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create');
        Route::post('/jadwal/store', [JadwalController::class, 'store'])->name('jadwal.store');
        Route::get('jadwal/datatable', [JadwalController::class, 'datatable'])->name('jadwal.datatable'); // <- AJAX

        // ✅ Pisahkan GET dan POST untuk import
        Route::get('/jadwal/import', fn() => view('admin.jadwal.import'))->name('jadwal.import.form'); // ← GET
        Route::post('/jadwal/import', [JadwalController::class, 'import'])->name('jadwal.import');    // ← POST
        Route::get('/jadwal/{id}', [JadwalController::class, 'show'])->name('jadwal.show');
        Route::get('/jadwal/{id}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
        Route::put('/jadwal/{id}', [JadwalController::class, 'update'])->name('jadwal.update');
        Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');

        // ADMIN
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        // ✅ Verifikasi BAP
        Route::get('/bap/datatable', [BapVerifikasiController::class, 'datatable'])->name('bap.datatable');
        Route::get('/bap', [BapVerifikasiController::class, 'index'])->name('bap.index');
        Route::get('/bap/{id}', [BapVerifikasiController::class, 'show'])->name('bap.show');
        Route::post('/bap/{id}/verifikasi', [BapVerifikasiController::class, 'verifikasi'])->name('bap.verifikasi');
        Route::get('/bap/{id}/pdf', [BapVerifikasiController::class, 'exportPdf'])->name('export.pdf');
        // routes/web.php (di dalam group admin)


        // Tambahkan di dalam group route admin
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/dosen/datatable', [ReportController::class, 'datatableDosen'])->name('dosen.datatable');
            Route::get('/dosen/{id}/datatable', [ReportController::class, 'datatableDosenDetail'])
                ->whereNumber('id')->name('dosen.show.datatable');  // ✅ NEW

            Route::get('/dosen', [ReportController::class, 'indexDosen'])->name('dosen.index');
            Route::get('/dosen/{id}', [ReportController::class, 'showDosen'])->name('dosen.show');
            Route::get('/dosen/export/pdf', [ReportController::class, 'exportIndexPdf'])->name('dosen.exportIndexPdf');
            Route::get('/dosen/{id}/export/pdf', [ReportController::class, 'exportShowPdf'])->name('dosen.exportShowPdf');

            // BAP
            Route::get('/bap', [ReportController::class, 'indexBap'])->name('bap.index');
            Route::get('/bap/export', [ReportController::class, 'exportBapAll'])->name('bap.export');
        });
        // 👤 Manajemen User
        Route::get('/user', [UserController::class, 'index'])->name('user.index');
        Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
        // Detail, Edit, dan Hapus User (dinamis berdasarkan jenis user)
        Route::get('/user/{tipe}/{id}', [UserController::class, 'show'])->name('user.show');     // lihat detail user
        Route::get('/user/{tipe}/{id}/edit', [UserController::class, 'edit'])->name('user.edit'); // edit user
        Route::put('/user/{tipe}/{id}', [UserController::class, 'update'])->name('user.update');  // update user
        Route::delete('/user/{tipe}/{id}', [UserController::class, 'destroy'])->name('user.destroy'); // hapus user

        Route::get('/bap/export', [ReportController::class, 'exportBapAll'])->name('bap.export');
        Route::get('/jadwal/data', [JadwalController::class, 'data'])->name('jadwal.data');
    });

// =================== DOSEN ===================
Route::middleware(['auth:dosen', DosenMiddleware::class])
    ->prefix('dosen')
    ->name('dosen.')
    ->group(function () {
        // ✅ endpoint datatable (PASTIKAN di atas /jadwal/{id})
        Route::get('/jadwal/datatable', [DosenJadwalController::class, 'datatable'])->name('jadwal.datatable');

        // 📅 Jadwal Mengajar
        Route::get('/jadwal', [DosenJadwalController::class, 'index'])->name('jadwal.index');
        Route::get('/jadwal/{id}', [DosenJadwalController::class, 'show'])->name('jadwal.show');

        // DOSEN
        Route::get('/dashboard', [DosenDashboardController::class, 'index'])->name('dashboard');
        Route::get('/bap/datatable', [DosenBapController::class, 'datatable'])->name('bap.datatable');

        // Reports (DataTables endpoints)
        Route::get('/reports/datatable', [DosenReportController::class, 'datatableIndex'])
            ->name('reports.datatable');

        Route::get('/reports/jadwal/{jadwal}/datatable', [DosenReportController::class, 'datatableShow'])
            ->whereNumber('jadwal')->name('reports.show.datatable');
        // 🧾 BAP
        Route::get('/bap', [DosenBapController::class, 'index'])->name('bap.index');
        Route::get('/bap/create', [DosenBapController::class, 'create'])->name('bap.create');
        Route::post('/bap/store', [DosenBapController::class, 'store'])->name('bap.store');
        Route::get('/bap/{id}', [DosenBapController::class, 'show'])->name('bap.show');
        Route::get('/bap/{id}/pdf', [DosenBapController::class, 'exportPdf'])->name('bap.pdf');
        Route::get('/reports', [DosenReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/jadwal/{jadwal}', [DosenReportController::class, 'show'])->name('reports.show');
        Route::get('/reports/jadwal/{jadwal}/pdf', [DosenReportController::class, 'exportPdf'])->name('reports.pdf');
    });

// =================== MAHASISWA ===================
Route::middleware(['auth:mahasiswa', MahasiswaMiddleware::class])
    ->prefix('mahasiswa')
    ->name('mahasiswa.')
    ->group(function () {
        Route::get('/jadwal/datatable', [MahasiswaJadwalController::class, 'datatable'])->name('jadwal.datatable');

        Route::get('/jadwal', [MahasiswaJadwalController::class, 'index'])->name('jadwal.index');
        Route::get('/jadwal/{id}', [MahasiswaJadwalController::class, 'show'])->name('jadwal.show');

        // 🧾 BAP Aktif (DataTables endpoint) — ✅ letakkan SEBELUM /bap/{id}
        Route::get('/bap/datatable', [MahasiswaBapController::class, 'datatable'])->name('bap.datatable');
        Route::get('/bap/riwayat/datatable', [MahasiswaBapController::class, 'datatableRiwayat'])
            ->name('bap.riwayat.datatable');

        // MAHASISWA
        Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])->name('dashboard');
        // 🧾 BAP Aktif untuk TTD Mahasiswa
        Route::get('/bap/index', [MahasiswaBapController::class, 'index'])->name('bap.index');
        Route::get('/bap/riwayat', [MahasiswaBapController::class, 'riwayat'])->name('bap.riwayat');
        Route::get('/bap/{id}', [MahasiswaBapController::class, 'show'])->name('bap.show');
        Route::get('/bap/{id}/ttd', [MahasiswaBapController::class, 'formTtd'])->name('bap.form_ttd'); // Form
        Route::post('/bap/{id}/ttd', [MahasiswaBapController::class, 'ttd'])->name('bap.ttd'); // Submit

    });
