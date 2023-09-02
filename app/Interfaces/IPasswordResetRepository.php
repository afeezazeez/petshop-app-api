<?php

namespace App\Interfaces;

use App\Models\PasswordReset;

interface IPasswordResetRepository
{


    public function createToken(string $email): string;

    public function getByEmail(string $email): PasswordReset|null;

    public function deleteToken(PasswordReset $passwordResetToken): void;
}
