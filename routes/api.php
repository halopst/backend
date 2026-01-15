<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\PetugasController;
use App\Http\Controllers\api\PenggunaController;
use App\Http\Controllers\api\ProvinsiController;
use App\Http\Controllers\api\KabupatenController;
use App\Http\Controllers\api\KonsultasiController;
use App\Http\Controllers\api\KeahlianController;
use App\Http\Controllers\api\NotificationController;
use App\Http\Controllers\api\SatkerController;
use App\Http\Controllers\api\WhatsappController;
use App\Http\Controllers\api\AidaController;
use App\Http\Middleware\VerifyGoogleToken;
use GuzzleHttp\Client;
use App\Models\User;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/petugas', PetugasController::class);
// Route::get('petugas-by-satker/{idSatker}', [PetugasController::class,'getPetugasSatker']);
// Route::get('petugas-by-keahlian/{idSatker}', [PetugasController::class,'getPetugasByKeahlian']);

// Route::apiResource('/keahlian', KeahlianController::class);

Route::get('daftar-kirim-notif-wa', [WhatsappController::class,'getDaftarKirim']);
Route::get('set-read-notif-wa/{id}', [WhatsappController::class,'setReadNotifWA']);

Route::get('get-konsultasi-notif', [KonsultasiController::class,'getKonsultasiNotif']);
Route::get('get-konsultasi-reminder', [KonsultasiController::class,'getKonsultasiReminder']);
Route::get('set-konsultasi-notif/{id_konsultasi}/kd_notif/{kd_notif}', [KonsultasiController::class,'setNotifKonsultasi']);

Route::get('isi-uuid', [KonsultasiController::class,'isiuuid']);

Route::apiResource('/aida', AidaController::class);
    Route::get('aida-by-pengguna/{idPengguna}', [AidaController::class,'getAidaByPengguna']);
    Route::put('aida-update-conv/{idAida}/update', [AidaController::class,'updateConversation']);
    Route::put('aida-hapus-conv/{idAida}', [AidaController::class,'deleteConversation']);
      
Route::middleware([VerifyGoogleToken::class])->group(function () {
    Route::apiResource('/provinsi', ProvinsiController::class);
    
    Route::apiResource('/kabupaten', KabupatenController::class);
    Route::get('kabupaten-by-prov/{idSatker}', [KabupatenController::class,'getKabByProv']);

    Route::apiResource('/pengguna', PenggunaController::class);

    Route::apiResource('/konsultasi', KonsultasiController::class);
    Route::get('konsultasi-by-pengguna/{idPengguna}', [KonsultasiController::class,'getKonsultasiByPengguna']);
    Route::get('reservasi-by-pengguna/{idPengguna}', [KonsultasiController::class,'getReservasiByPengguna']);
    Route::get('histori-by-pengguna/{idPengguna}', [KonsultasiController::class,'getHistoriByPengguna']);
    Route::put('konsultasi/{idKonsultasi}/batal', [KonsultasiController::class,'batalKonsultasi']);
    Route::put('konsultasi/{idKonsultasi}/feedback', [KonsultasiController::class,'feedbackKonsultasi']);

    Route::apiResource('/satker', KonsultasiController::class)->middleware(VerifyGoogleToken::class);

    Route::get('/notifikasi/{email}', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifikasi/{email}/mark-as-read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::get('/notifikasi/unread-count/{email}', [NotificationController::class, 'unreadCount'])->name('notifications.unreadCount');

    Route::get('petugas-by-satker/{idSatker}', [PetugasController::class,'getPetugasSatker']);
    Route::get('petugas-by-keahlian/{idSatker}', [PetugasController::class,'getPetugasByKeahlian']);

    Route::apiResource('/keahlian', KeahlianController::class);
}); 

Route::post('/verify-google-token', function (Request $request) {
    $token = $request->input('token');

    if (!$token) {
        return response()->json(['error' => 'Token not provided'], 400);
    }

    $client = new Client();
    $response = $client->get('https://oauth2.googleapis.com/tokeninfo?id_token=' . $token);

    if ($response->getStatusCode() != 200) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $body = json_decode($response->getBody(), true);

    if (!$body || !isset($body['sub'])) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // You can now use the $body information to authenticate the user in your app
    // For example, find or create a user in your database
    $user = User::updateOrCreate(
        ['google_id' => $body['sub']],
        ['name' => $body['name'],
        'email' => $body['email'],
            // Any other fields you want to update
        ]
    );

    // Generate a token for the user
    $token = $user->createToken('Personal Access Token')->accessToken;

    return response()->json(['token' => $token, 'user' => $user]);
});


