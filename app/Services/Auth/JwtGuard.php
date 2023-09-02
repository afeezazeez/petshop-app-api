<?php

namespace App\Services\Auth;

use App\Exceptions\ClientErrorException;
use App\Models\User;
use Firebase\JWT\Key;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Firebase\JWT\JWT;
use  Illuminate\Contracts\Auth\UserProvider;

class JwtGuard implements Guard
{
    use GuardHelpers;

    protected   $provider;


    public function __construct(?UserProvider $provider)
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

            if (!$publicKey){
                throw new ClientErrorException("Error encountered while fetching public key");
            }

            $decoded = JWT::decode($token, new Key($publicKey, 'RS256'));
            $user = User::where('uuid',($decoded->user_uuid))->first();
            if ($user){
                $this->user = $this->provider->retrieveById($user->id);
            }

        } catch (\Exception $e) {
            return null;
        }

        return $this->user;
    }

    /**
     *
     *
     * @param array<string,mixed> $credentials
     */
    public function attempt(array $credentials = []): bool
    {
        $user = $this->provider->retrieveByCredentials($credentials);

        if ($user && $this->provider->validateCredentials($user, $credentials)) {

            $this->user = $user;
            return true;
        }

        return false;
    }



    /**
     * @param array<string,mixed> $credentials
     *
     */
    public function validate(array $credentials = []):bool
    {
        return true;
    }


}
