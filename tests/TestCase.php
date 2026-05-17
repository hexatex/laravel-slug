<?php

namespace Hexatex\LaravelSlug\Tests;

use Hexatex\LaravelSlug\LaravelSlugServiceProvider;
use Hexatex\LaravelSlug\Tests\TestObjects\TestSluggable;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Orchestra\Testbench\TestCase as Orchestra;
use \ReflectionClass;

abstract class TestCase extends Orchestra
{
    use DatabaseMigrations;

    protected function getPackageProviders($app)
    {
        return [
            LaravelSlugServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'base64:jqAF7i3K4aZ+6h/jN/jl9ZQRCn1c3LPGACxe+x7FpBQ=');
    }

    protected function getInaccessibleMethod($class, string $methodName)
    {
        $reflection = new ReflectionClass($class);
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method;
    }

    protected function setUp(): void
    {
        parent::setUp();

        Relation::enforceMorphMap(['test-sluggable' => TestSluggable::class]);
    }

    protected function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }
}
