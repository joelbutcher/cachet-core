<?php

namespace Cachet\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\Contracts\Config;
use Orchestra\Testbench\TestCase as Orchestra;
use Orchestra\Testbench\Workbench\Workbench;

abstract class TestCase extends Orchestra
{
    use RefreshDatabase, WithWorkbench;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Cachet\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    /**
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function defineEnvironment($app)
    {
        $app['config']->set([
            'auth.providers.users.model' => 'Workbench\\App\\User',
            'database.default' => 'testing',
            // 'query-builder.request_data_source' => 'body',
        ]);
    }

    public static function cachedConfigurationForWorkbench(): Config
    {
        $config = Workbench::configuration();

        $config['seeders'] = false;

        return $config;
    }
}
