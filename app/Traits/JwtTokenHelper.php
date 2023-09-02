<?php

namespace App\Traits;

use App\Exceptions\ClientErrorException;
use App\Models\JwtToken;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

trait JwtTokenHelper
{

    /**
     * Generate Token
     * @param User|null $user
     * @throws ClientErrorException
     */
    protected function generateToken($user): string
    {
        $privateKey = file_get_contents(storage_path('app/public/keys/private-key.pem'));
        $payload = [
            'iss' => config('app.url'),
            'aud' => config('app.url'),
            'iat' => time(),
            'exp' => time() + 3600,
            'user_uuid' => $user?->id
        ];
        if (!$privateKey){
            throw new ClientErrorException("Error encountered while fetching private key");
        }
        $token = JWT::encode($payload, $privateKey, 'RS256');

        JwtToken::create(['user_id' => $user?->id,'token_title' => 'access_token']);

        return $token;
    }

    /**
     * @throws ClientErrorException
     */
    protected function decodeToken(string $token):string
    {
        $publicKey = file_get_contents(storage_path('app/public/keys/public-key.pem'));

        if (!$publicKey){
            throw new ClientErrorException("Error encountered while fetching public key");
        }

        $decoded = JWT::decode($token, new Key($publicKey, 'RS256'));

        return $decoded->user_uuid;
    }
}
