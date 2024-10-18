<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Client;
use App\Models\User;

class VerifyGoogleToken
{
    
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        
        if (!$token) {
            return response()->json(400);
        }

        $client = new Client();
        $response = $client->get('https://oauth2.googleapis.com/tokeninfo?id_token=' . $token);

        if ($response->getStatusCode() != 200) {
            return response()->json(400);
            //return response()->json(['error' => 'Unauthorized'], 401);
        }

        $body = json_decode($response->getBody(), true);

        if (!$body || !isset($body['sub'])) {
            return response()->json(400);
            // return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Find or create a user based on the Google ID
        $user = User::updateOrCreate(
            ['google_id' => $body['sub']],
            [
                'name' => $body['name'],
                'email' => $body['email'],
                // Add any other fields you want to update
            ]
        );

        // Authenticate the user
        Auth::login($user);
        return $next($request);
    }
}
