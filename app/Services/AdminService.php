<?php

namespace App\Services;

use App\Http\Controllers\Api\Admin\AuthController;
use App\Interfaces\IUserRepository;
use App\Models\User;

class AdminService
{

    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Login user with password
     *
     * @param array<string,mixed> $request
     * @return array<string,mixed>
     */
    public function createAdmin(array $request): array
    {
        $user = $this->userRepository->createAdmin($request);
        $loginAdmin = app(AuthService::class)->login(['email' => $request['email'], 'password' => $request['password']]);

        $data = [
            'uuid' => $user->uuid,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'address' => $user->address,
            'phone_number' => $user->phone_number,
            'updated_at' => $user->updated_at,
            'created_at' => $user->created_at,
            'token' => $loginAdmin['token'],
        ];

        return $data;
    }
}
