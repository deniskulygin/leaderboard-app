<?php
declare(strict_types = 1);

namespace LeaderBoard\Providers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use LeaderBoard\Http\Middleware\TeamAdminUserMiddleware;
use LeaderBoard\Http\Middleware\TeamUserMiddleware;

class RouteServiceProvider extends ServiceProvider
{
    private const UNIQUE_ID_PATTERN = '[a-z0-9]{40}';

    /**
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        /** @var Router $router */
        $router = $this->app->make('router');

        $router->namespace('LeaderBoard\Http\Controllers')
            ->middleware('auth:sanctum')
            ->group(fn() => $this->mapRoutes($router));
    }

    private function mapRoutes(Router $router): void
    {
        /** @uses  \LeaderBoard\Http\Controllers\Team\CreateController::__invoke */
        $router->post('/teams', 'Team\CreateController');

        /** @uses  \LeaderBoard\Http\Controllers\Team\DeleteController::__invoke */
        $router->delete('/teams/{teamUniqueId}', 'Team\DeleteController')
            ->where('teamUniqueId', self::UNIQUE_ID_PATTERN)
            ->middleware(TeamAdminUserMiddleware::class);

        /** @uses  \LeaderBoard\Http\Controllers\Team\GetController::__invoke */
        $router->get('/teams/{teamUniqueId}', 'Team\GetController')
            ->where('teamUniqueId', self::UNIQUE_ID_PATTERN)
            ->middleware(TeamUserMiddleware::class);

        /** @uses  \LeaderBoard\Http\Controllers\Team\ListController::__invoke */
        $router->get('/teams', 'Team\ListController');

        /** @uses  \LeaderBoard\Http\Controllers\Team\Counter\CreateController::__invoke */
        $router->post('/teams/{teamUniqueId}/counters', 'Team\Counter\CreateController')
            ->where('teamUniqueId', self::UNIQUE_ID_PATTERN)
            ->middleware(TeamUserMiddleware::class);

        /** @uses  \LeaderBoard\Http\Controllers\Team\Counter\ListController::__invoke */
        $router->get('/teams/{teamUniqueId}/counters', 'Team\Counter\ListController')
            ->where('teamUniqueId', self::UNIQUE_ID_PATTERN)
            ->middleware(TeamUserMiddleware::class);

        /** @uses  \LeaderBoard\Http\Controllers\Team\Counter\GetController::__invoke */
        $router->get('/teams/{teamUniqueId}/counters/{counterUniqueId}', 'Team\Counter\GetController')
            ->where('teamUniqueId', self::UNIQUE_ID_PATTERN)
            ->where('counterUniqueId', self::UNIQUE_ID_PATTERN)
            ->middleware(TeamUserMiddleware::class);

        /** @uses  \LeaderBoard\Http\Controllers\Team\Counter\IncrementController::__invoke */
        $router->patch(
            '/teams/{teamUniqueId}/counters/{counterUniqueId}/increment',
            'Team\Counter\IncrementController'
        )
            ->where('teamUniqueId', self::UNIQUE_ID_PATTERN)
            ->where('counterUniqueId', self::UNIQUE_ID_PATTERN)
            ->middleware(TeamUserMiddleware::class);

        /** @uses  \LeaderBoard\Http\Controllers\Team\Counter\DeleteController::__invoke */
        $router->delete('/teams/{teamUniqueId}/counters/{counterUniqueId}', 'Team\Counter\DeleteController')
            ->where('teamUniqueId', self::UNIQUE_ID_PATTERN)
            ->where('counterUniqueId', self::UNIQUE_ID_PATTERN)
            ->middleware(TeamUserMiddleware::class);

        /** @uses  \LeaderBoard\Http\Controllers\Team\User\CreateController::__invoke */
        $router->post('/teams/{teamUniqueId}/users/{userUniqueId}', 'Team\User\CreateController')
            ->where('teamUniqueId', self::UNIQUE_ID_PATTERN)
            ->where('userUniqueId', self::UNIQUE_ID_PATTERN)
            ->middleware(TeamAdminUserMiddleware::class);

        /** @uses  \LeaderBoard\Http\Controllers\Team\User\DeleteController::__invoke */
        $router->delete('/teams/{teamUniqueId}/users/{userUniqueId}', 'Team\User\DeleteController')
            ->where('teamUniqueId', self::UNIQUE_ID_PATTERN)
            ->where('userUniqueId', self::UNIQUE_ID_PATTERN)
            ->middleware(TeamUserMiddleware::class);
    }
}
