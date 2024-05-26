<?php
declare(strict_types = 1);

namespace LeaderBoard\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    private $map = [
        \LeaderBoard\ORM\Repository\UserRepository::class => \LeaderBoard\ORM\Model\User::class,
        \LeaderBoard\ORM\Repository\TeamRepository::class => \LeaderBoard\ORM\Model\Team::class,
        \LeaderBoard\ORM\Repository\TeamUserRepository::class => \LeaderBoard\ORM\Model\TeamUser::class,
        \LeaderBoard\ORM\Repository\TeamUserCounterRepository::class => \LeaderBoard\ORM\Model\TeamUserCounter::class,
    ];

    public function register(): void
    {
        foreach ($this->map as $repositoryClass => $modelClass) {
            $this->app->singleton($repositoryClass, function () use ($repositoryClass, $modelClass) {
                return new $repositoryClass($this->app->make($modelClass));
            });
        }
    }
}
