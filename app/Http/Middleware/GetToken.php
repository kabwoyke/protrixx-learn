<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;

class GetToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        try {
            // Try to get token from cache, or generate a new one
            $token = Cache::remember('mpesa_access_token', 3600, function () {
                $consumer_key = env('CONSUMER_KEY');
                $consumer_secret = env('CONSUMER_SECRET');
                $auth_key = base64_encode($consumer_key . ":" . $consumer_secret);

                $response = Http::withHeaders([
                    'Authorization' => "Basic " . $auth_key
                ])->get("https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials");

                return $response["access_token"];
            });

            $request->request->add(['token' => $token]);

            return $next($request);
        } catch (\Throwable $th) {
            Log::error('Failed to get M-Pesa token: ' . $th->getMessage());

            return $next($request);
        }

    }
}
