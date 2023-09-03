<?php

namespace App\Services;

use App\Interfaces\IUserRepository;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class UserService
{
    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Create admin
     *
     * @param array<string,mixed> $request
     * @return array<string,mixed>
     */
    public function createUser(array $request): array
    {
        $data = array_diff_key($request, array_flip(['password', 'password_confirmation']));
        $data['password'] = "userpassword";
        $user = $this->userRepository->createUserAccount($data);
        $loginUser = app(AuthService::class)->login(['email' => $request['email'], 'password' => 'userpassword']);

        $data = [
            'uuid' => $user->uuid,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'address' => $user->address,
            'phone_number' => $user->phone_number,
            'is_marketing' => $user->is_marketing,
            'updated_at' => $user->updated_at,
            'created_at' => $user->created_at,
            'token' => $loginUser['token'],
        ];
        return $data;
    }


    /**
     * Update user
     *
     * @param array<string,mixed> $request
     */
    public function updateUser(array $request): User|null
    {
        $data = array_diff_key($request, array_flip(['password', 'password_confirmation']));
        return $this->userRepository->updateUserAccount($data);

    }

    /**
     * delete user
     *
     */
    public function deleteUser(): void
    {
        $this->userRepository->deleteAuthUser();

    }

}
