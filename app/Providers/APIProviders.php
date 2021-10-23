<?php

namespace App\Providers;

use App\Core\API\Repositories\ContentRepository;
use App\Core\API\Repositories\Contracts\IContentRepository;
use App\Core\API\Repositories\Contracts\IUserRepository;
use App\Core\API\Repositories\UserRepository;
use App\Core\API\Services\ContentService;
use App\Core\API\Services\Contracts\IContentService;
use App\Core\API\Services\Contracts\IUserService;
use App\Core\API\Services\UserService;
use Illuminate\Support\ServiceProvider;

class APIProviders extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // REPOSITORIES
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IContentRepository::class, ContentRepository::class);

        // SERVICES
        $this->app->bind(IUserService::class, UserService::class);
        $this->app->bind(IContentService::class, ContentService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
