<?php

namespace App\Services;

use App\Interfaces\IPasswordResetRepository;
use App\Interfaces\IUserRepository;

class PasswordResetService
{
    private IPasswordResetRepository $passwordResetRepository;

    public function __construct(IPasswordResetRepository $passwordResetRepository,IUserRepository $userRepository)
    {
        $this->passwordResetRepository = $passwordResetRepository;
        $this->userRepository = $userRepository;
    }


    /**
     * Create token
     *
     */
    public function createToken(string $email): string
    {

        $existingToken = $this->passwordResetRepository->getByEmail($email);

        if ($existingToken) {
           $this->passwordResetRepository->deleteToken($existingToken);
        }
       return $this->passwordResetRepository->createToken($email);

    }
}
