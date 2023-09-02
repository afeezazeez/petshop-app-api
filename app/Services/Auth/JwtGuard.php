<?php

namespace App\Services\Auth;

use Firebase\JWT\Key;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Firebase\JWT\JWT;

class JwtGuard implements Guard
{
    use GuardHelpers;

    protected $provider;

    public function __construct($provider)
    {
        $this->provider = $provider;
    }

    public function user()
    {
        if (!is_null($this->user)) {
            return $this->user;
        }

        $token = request()->bearerToken();

        if (!$token){
            return null;
        }

        try {
            $publicKey = file_get_contents(storage_path('app/public/keys/public-key.pem'));

            $decoded = JWT::decode($token, new Key($publicKey, 'RS256'));

            $this->user = $this->provider->retrieveById($decoded->user_uuid);

        } catch (\Exception $e) {
            return null;
        }

        return $this->user;
    }

    public function attempt(array $credentials = [], $remember = false)
    {
        $user = $this->provider->retrieveByCredentials($credentials);

        if ($user && $this->provider->validateCredentials($user, $credentials)) {

            $this->user = $user;
            return true;
        }

        return false;
    }



    // Implement other methods required by the Guard interface (check, attempt, etc.).
    public function validate(array $credentials = [])
    {
        // TODO: Implement validate() method.
    }
}
