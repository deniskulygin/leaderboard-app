<?php
declare(strict_types = 1);

namespace LeaderBoard\Providers;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\ServiceProvider;
use LeaderBoard\Exception\Handler;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->basePath('modules/LeaderBoard');

        $this->app->singleton(ExceptionHandler::class, Handler::class);
    }
}
