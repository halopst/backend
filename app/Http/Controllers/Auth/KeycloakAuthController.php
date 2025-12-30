<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;
use App\Models\User; // Pastikan Anda memiliki model User yang sesuai
use App\Models\Petugas;

class KeycloakAuthController extends Controller
{
    //
    // Redirect user ke halaman SSO Keycloak
    public function redirectToProvider()
    {
        //return Socialite::driver('keycloak')->redirect();
        return Socialite::driver('keycloak')->scopes([])->redirect();
    }

    // Handle callback dari SSO Keycloak
    public function handleProviderCallback(Request $request)
    {
        if (!session()->has('keycloak_user')) { 
            try {
                $user = Socialite::driver('keycloak')->stateless()->user();
                $request->session()->put('id_token', $user->token);
                $authUser = User::where('email', $user->getEmail())->first();
                $petugas = Petugas::where('email_bps',$user->getEmail())->first();
                
                //dd($petugas['foto']);
                if($authUser){
                    $request->session()->put('keycloak_user', [
                        'id' => $user->getId(),
                        'name' => $user->getName(),
                        'email' => $user->getEmail(),
                        'id_petugas' => $petugas['id'],
                        'urlFoto' => $petugas['foto'],
                        'status' => $petugas['status'],
                        'id_satker' => $petugas['id_satker'],
                        'nip_lama'=> $user->user['nip-lama'],
                        'nip_baru'=> $user->user['nip'],
                        'kd_organisasi'=> $user->user['organisasi'],
                        'kabupaten'=> $user->user['kabupaten'],
                        'golongan'=> $user->user['golongan'],
                        'jabatan'=> $user->user['jabatan'],
                        'eselon' => $user->user['eselon'],
                        'username' => $user->user['username'],
                        'first_name' => $user->user['first-name'],
                        'last_name' => $user->user['last-name'],
                        'token' => $user->token,
                        // Tambahkan data lain yang diperlukan
                    ]);
                   
                    Auth::login($authUser, true);
                    return redirect()->intended('/dashboard');
                }else{
                    return redirect()->intended('login-error');
                }
            } catch (\Exception $e) {
                Log::error('Error during Keycloak login:', ['error' => $e->getMessage()]);
                return redirect()->route('login');
                // return redirect()->route('login')->withErrors('Unable to login using Keycloak.');
            }
        }else{
            return redirect('/login');
        }
    }

    // Fungsi untuk menemukan atau membuat user
    protected function findOrCreateUser($keycloakUser)
    {
        $authUser = User::where('email', $keycloakUser->getEmail())->first();

        if ($authUser) {
            dd('masuk');
           return $authUser;
        }else{
            
        }

        dd($keycloakUser->user->name);
        dd('lanjut');
        return User::create([
            'name' => $keycloakUser->getName(),
            'email' => $keycloakUser->getEmail(),
        ]);
    }

    // Fungsi untuk logout
    public function logout(Request $request)
    {
        
        $logoutUrl = env('KEYCLOAK_BASE_URL') . '/protocol/openid-connect/logout?' . http_build_query([
            'id_token_hint' => session('keycloak_user')['token'],
            'post_logout_redirect_uri' => url('/')
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }
}
