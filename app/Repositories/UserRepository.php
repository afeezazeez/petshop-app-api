<?php

namespace App\Repositories;

use App\Interfaces\IUserRepository;
use App\Models\User;

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


}
