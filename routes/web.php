<?php
use App\Models\Petugas;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\back\DashboardController;
use App\Http\Controllers\back\SatkerController;
use App\Http\Controllers\back\PetugasController;
use App\Http\Controllers\back\PenggunaController;
use App\Http\Controllers\back\KonsultasiController;
use App\Http\Controllers\back\KabupatenController;
use App\Http\Controllers\back\ProvinsiController;
use App\Http\Controllers\back\KeahlianController;
use App\Http\Controllers\back\BPSController;
use App\Http\Controllers\back\NotificationController;

use App\Http\Controllers\Auth\KeycloakAuthController;
use App\Http\Controllers\Auth\ExternalUserController;

use Illuminate\Support\Facades\Auth;



use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;



use Laravel\Socialite\Facades\Socialite;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::post('/login/external-user', [ExternalUserController::class, 'login']);
Route::get('/login/keycloak', [KeycloakAuthController::class, 'redirectToProvider']);

//redirect to callback 
Route::get('/', [KeycloakAuthController::class, 'handleProviderCallback']);

Route::post('/logout', [KeycloakAuthController::class, 'logout'])->name('logout');

// Rute untuk halaman login
Route::get('login', function () {
    if (session()->has('keycloak_user')) {
        return redirect('/dashboard');
    } else {
        return view('back.auth.login');
    }
})->name('login');

Route::get('login-error',function () {
    return view('back.auth.login',['error'=>'Akun Anda belum terdaftar, minta ke admin BPS Kabupaten/Provinsi untuk ditambahkan']);
});

Route::middleware(['auth'])->group(function () {
   // Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::resource('/satker', SatkerController::class)->only([
        'index','update', 'destroy', 'store'
    ]);
    
    Route::resource('/petugas', PetugasController::class);
    Route::get('/cekpetugas/{email_bps}', [PetugasController::class, 'checkExistOrNo']);
    Route::post('/get-petugas', [PetugasController::class,'getPetugas']);

    Route::resource('/pengguna', PenggunaController::class);

    Route::resource('/konsultasi', KonsultasiController::class);
    Route::post('/edit-status-konsultasi', [KonsultasiController::class,'updateStatus']);
    Route::post('/get-konsultasi', [KonsultasiController::class,'getKonsultasiById']);
    Route::post('/selesai-konsultasi', [KonsultasiController::class,'selesaiKonsultasi']);
    Route::post('/setujui-konsultasi', [KonsultasiController::class,'setujuiKonsultasi']);
    Route::post('/batal-konsultasi', [KonsultasiController::class,'batalKonsultasi']);
    
    Route::resource('/master-prov', ProvinsiController::class);
    Route::resource('/master-keahlian', KeahlianController::class);

    Route::resource('/keahlian', KeahlianController::class);

    Route::resource('/master-kabkot', KabupatenController::class);
    Route::post('get-master-kab', [KabupatenController::class, 'getKab']);

    Route::get('/pegawai/username/{username}', [BpsController::class, 'getPegawaiByUsername']);

    Route::get('/notifications/{email}', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/send-notification', [NotificationController::class, 'sendNotification']);
    Route::get('/notifications/unread-count/{email}', [NotificationController::class, 'unreadCount'])->name('notifications.unreadCount');
    Route::get('/notifications/{email}/mark-as-read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

});

// Route::get('/tambah-keahlian', function(){
//     $petugas=Petugas::find(6);
//     $keahlian=['17','18'];
//     $petugas->keahlian()->sync($keahlian);
// });



