<?php

namespace App\Services;

use App\Exceptions\ClientErrorException;
use App\Interfaces\IUserRepository;
use App\Traits\JwtTokenHelper;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    use JwtTokenHelper;

    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Login user with password
     *
     * @param array<string,mixed> $request
     * @return array<string, mixed>
     * @throws ClientErrorException
     * @throws AuthenticationException
     */
    public function login(array $request, string $user_type = "user"): array
    {
        if ($user_type === "admin"){
            $user = $this->userRepository->findAdminByEmail($request['email']);
        }else{
            $user = $this->userRepository->findUserByEmail($request['email']);
        }

        if (!$user || !is_string($user->password) || !password_verify($request['password'], $user->password)) {
            throw new ClientErrorException('Incorrect password!');
        }

        if (Auth::attempt($request)) {
            $user = Auth::user();
            if ($user !== null) {
                $user->update(['last_login_at' => now()]);
            }

            $token = $this->generateToken($user);
            return [
                'token' => $token
            ];
        }
        else {
           throw new AuthenticationException("Unauthorized");
        }

    }

}
