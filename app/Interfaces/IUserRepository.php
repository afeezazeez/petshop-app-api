<?php

namespace App\Interfaces;

use App\Models\User;

interface IUserRepository
{
    public function findAdminByEmail(string $email): User|null;

    /**
     * @param array<string,mixed> $data
     */
    public function createAdmin(array $data): User;

    /**
     * @return  array<string,mixed>
     */
    public function fetchUsers(): array;

}
