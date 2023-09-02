<?php

namespace App\Traits;

use App\Models\JwtToken;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

trait JwtTokenHelper
{
    protected function generateToken($user): string
    {
        $privateKey = file_get_contents(storage_path('app/public/keys/private-key.pem'));
        $payload = [
            'iss' => config('app.url'),
            'aud' => config('app.url'),
            'iat' => time(),
            'exp' => time() + 600,
            'user_uuid' => $user->id
        ];

        $token = JWT::encode($payload, $privateKey, 'RS256');

        JwtToken::create(['user_id' => $user->id,'token_title' => 'access_token']);

        return $token;
    }

    protected function decodeToken($token)
    {
        $publicKey = file_get_contents(storage_path('app/public/keys/public-key.pem'));

        $decoded = JWT::decode($token, new Key($publicKey, 'RS256'));

        return $decoded->user_uuid;
    }
}
