<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Services\Api\User\UserService;
use App\Http\Services\Api\User\UserServiceInterface;
use Illuminate\Support\ServiceProvider;

/**
 * Class ApiServiceProvider
 */
class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }
}
