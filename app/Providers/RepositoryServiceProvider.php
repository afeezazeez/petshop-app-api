<?php

namespace App\Providers;

use App\Interfaces\IOrderRepository;
use App\Interfaces\IPasswordResetRepository;
use App\Interfaces\IUserRepository;
use App\Repositories\OrderRepository;
use App\Repositories\PasswordResetRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IOrderRepository::class, OrderRepository::class);
        $this->app->bind(IPasswordResetRepository::class, PasswordResetRepository::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
