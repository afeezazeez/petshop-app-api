<?php

namespace App\Interfaces;

use App\Models\User;

interface IUserRepository
{
    public function findAdminByEmail(string $email): User|null;

    public function findUserByEmail(string $email): User|null;

    /**
     * @param array<string,mixed> $data
     */
    public function createAdmin(array $data): User;

    /**
     * @param array<string,mixed> $data
     */
    public function createUserAccount(array $data): User;


    /**
     * @return  array<string,mixed>
     */
    public function fetchUsers(): array;

    /**
     * @param array<string,mixed> $data
     */
    public function updateUser(string $uuid, array $data): User;

    public function deleteUser(string $uuid):void;





}
