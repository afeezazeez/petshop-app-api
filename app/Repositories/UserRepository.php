<?php

namespace App\Repositories;

use App\Interfaces\IUserRepository;
use App\Models\User;
use Illuminate\Support\Arr;


class UserRepository implements IUserRepository
{

    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }


    /**
     * Find user by email
     *
     * @param string $email
     * @return User|null
     */
    public function findAdminByEmail(string $email): User|null
    {
        return $this->model->where('email', $email)
            ->where('is_admin',1)->first();
    }

    /**
     * Create admin
     * @param array<string,mixed> $data
     * @return User
     */


    public function createAdmin(array $data): User
    {
        $data = Arr::add($data, 'is_admin', 1);
        return $this->model->create($data);
    }

}
