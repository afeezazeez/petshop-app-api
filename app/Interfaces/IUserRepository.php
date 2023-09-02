<?php

namespace App\Interfaces;

use App\Models\User;

interface IUserRepository
{
    public function findAdminByEmail(string $email): User|null;

}
