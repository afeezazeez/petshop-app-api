<?php

namespace App\Interfaces;

use App\Models\User;

interface IUserRepository
{
    public function findByEmail(string $email): User|null;

}
