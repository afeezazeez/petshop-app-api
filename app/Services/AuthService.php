<?php

namespace App\Services;

use App\Exceptions\ClientErrorException;
use App\Interfaces\IUserRepository;

class AuthService
{

    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Login user with password
     *
     * @param array $request
     * @return array
     * @throws ClientErrorException
     */
    public function login(array $request): array
    {
        $user = $this->userRepository->findByEmail($request['email']);

        if (!password_verify($request['password'], $user->password)) {
            throw new ClientErrorException('Incorrect password!');
        }

        return  [];
    }

}
