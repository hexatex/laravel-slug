<?php

namespace Hexatex\LaravelSlug;

use Hexatex\LaravelSlug\Slug\Builders\Builder;
use Hexatex\LaravelSlug\Slug\Builders\BuilderFactory;
use Hexatex\LaravelSlug\Slug\Builders\DefaultBuilder;
use Hexatex\LaravelSlug\Slug\Builders\DefaultBuilderFactory;
use Hexatex\LaravelSlug\Slug\Contracts\Slug;
use Hexatex\LaravelSlug\Slug\Contracts\SlugRepository;
use Hexatex\LaravelSlug\Slug\Contracts\SlugService;
use Hexatex\LaravelSlug\Slug\Slug as ConcreteSlug;
use Hexatex\LaravelSlug\Slug\SlugRepository as ConcreteSlugRepository;
use Hexatex\LaravelSlug\Slug\SlugService as ConcreteSlugService;
use Illuminate\Support\ServiceProvider;

class LaravelSlugServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'hexatex');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'hexatex');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/slug.php', 'slug');
        $this->app->bind(Builder::class, DefaultBuilder::class);
        $this->app->bind(BuilderFactory::class, DefaultBuilderFactory::class);
        $this->app->bind(Slug::class, ConcreteSlug::class);
        $this->app->bind(SlugService::class, ConcreteSlugService::class);
        $this->app->bind(SlugRepository::class, ConcreteSlugRepository::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/slug.php' => config_path('slug.php'),
        ], 'laravel-slug.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/hexatex'),
        ], 'slug.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/hexatex'),
        ], 'slug.assets');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/hexatex'),
        ], 'slug.lang');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
