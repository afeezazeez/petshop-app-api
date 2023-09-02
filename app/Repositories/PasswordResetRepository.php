<?php

namespace App\Repositories;

use App\Interfaces\IPasswordResetRepository;
use App\Models\PasswordReset;

class PasswordResetRepository implements IPasswordResetRepository
{

    protected PasswordReset $model;

    public function __construct(PasswordReset $model)
    {
        $this->model = $model;
    }


    /**
     * Create token
     *
     * @param string $email
     */
    public function createToken(string $email): string
    {
        return  $this->model->create(['email'=> $email])->token;
    }

    /**
     * get token by email
     *
     * @param string $email
     */
    public function getByEmail(string $email): PasswordReset|null
    {
        return  $this->model->where('email',$email)->first();
    }

    /**
     * delete token
     *
     */
    public function deleteToken(PasswordReset $passwordResetToken): void
    {
         $passwordResetToken->delete();
    }


}
