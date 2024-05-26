<?php
declare(strict_types = 1);

namespace LeaderBoard\Documentation\Providers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;
use LeaderBoard\Documentation\Console\Commands\BuildSwagger;
use LeaderBoard\Documentation\Services\AssetHandler;
use LeaderBoard\Documentation\Services\SwaggerBuilder;
use Illuminate\Routing\Router;

class DocumentationServiceProvider extends ServiceProvider
{
    /**
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        $this->bootRouter();

        $path = realpath(__DIR__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config'
            . DIRECTORY_SEPARATOR . 'swagger.php';

        $this->mergeConfigFrom($path, 'swagger');

        $this->app->view->addLocation(__DIR__ . '/../resources/views');
    }

    public function register(): void
    {
        $this->app->singleton(
            AssetHandler::class,
            fn() => (new AssetHandler($this->app->make('config')))
                ->setUrlGenerator($this->app->make('url'))
        );

        $this->app->bind(SwaggerBuilder::class);

        $this->registerCommand();
    }

    /**
     * @return void
     */
    private function registerCommand(): void
    {
        $this->app->singleton('command.build.swagger', BuildSwagger::class);

        $this->commands(['command.build.swagger']);
    }

    /**
     * @throws BindingResolutionException
     */
    private function bootRouter(): void
    {
        /** @var Router $router */
        $router = $this->app->make('router');
        $router
            ->prefix('api')
            ->namespace('LeaderBoard\Documentation\Http\Controllers')
            ->group(function () use ($router) {
                $this->mapRoutes($router);
            });
    }

    private function mapRoutes(Router $router): void
    {
        $router->get('/documentation', ['uses' => 'DocumentationController@documentation']);

        $router->get('/documentation/asset/{asset}', [
            'as' => 'documentation.asset',
            'uses' => 'DocumentationController@asset',
        ]);
    }
}
