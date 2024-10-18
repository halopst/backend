<?php
namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExternalUserController extends Controller
{

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string',
                'password' => 'required|string|max:10', // Max 20 characters for password
            ]);
            
            $credentials = $request->only('email', 'password');

            //if (Auth::attempt($credentials)) {
                // Jika otentikasi berhasil
            //    return redirect()->intended('/dashboard');
            //}else {
                //dd("sdadas");
            return redirect()->back()
                    ->withErrors('Maaf Anda belum terdaftar');
            //}
        } catch (ValidationException $e) {
            return redirect()->back()
                             ->withErrors($e->validator)
                             ->withInput();
        }
        
        
        // Jika otentikasi gagal
        //eturn redirect()->intended('login-error');
        // return back()->withErrors([
        //     'email' => 'The provided credentials do not match our records.',
        // ]);
    }
}