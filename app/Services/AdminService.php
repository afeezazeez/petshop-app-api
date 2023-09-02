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
     * fetch users
     *
     * @return array<string,mixed>
     */
    public function fetchUsers(): array
    {
        return $this->userRepository->fetchUsers();
    }



    /**
     * Create admin
     *
     * @param array<string,mixed> $request
     * @return array<string,mixed>
     */
    public function createAdmin(array $request): array
    {
        $user = $this->userRepository->createAdmin($request);
        $loginAdmin = app(AuthService::class)->login(['email' => $request['email'], 'password' => $request['password']]);

        return $this->fetch($user, $loginAdmin['token']);
    }


    /**
     * Create admin
     *
     * @param array<string,mixed> $request
     */
    public function updateUser(string $uuid,array $request): User
    {
        $data = array_diff_key($request, array_flip(['password', 'password_confirmation']));
        return $this->userRepository->updateUser($uuid,$data);

    }

    /**
     * Create admin
     *
     */
    public function deleteUser(string $uuid):void
    {
        $this->userRepository->deleteUser($uuid);

    }

    /**
     * @param User $user
     * @param $token
     * @return array
     * @return array<string,mixed>
     */
    public function fetch(User $user, string $token): array
    {
        $data = [
            'uuid' => $user->uuid,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'address' => $user->address,
            'phone_number' => $user->phone_number,
            'updated_at' => $user->updated_at,
            'created_at' => $user->created_at,
            'token' => $token,
        ];

        return $data;
    }


}
