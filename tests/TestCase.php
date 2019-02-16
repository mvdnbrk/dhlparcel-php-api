<?php

namespace Mvdnbrk\DhlParcel\Tests;

use Dotenv\Dotenv;
use Mvdnbrk\DhlParcel\Client;
use Dotenv\Exception\InvalidFileException;
use Dotenv\Exception\InvalidPathException;
use Mvdnbrk\DhlParcel\DhlParcelServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function setUp()
    {
        try {
            (new Dotenv('./', '.env'))->load();
        } catch (InvalidPathException $e) {
            //
        } catch (InvalidFileException $e) {
            die('The environment file is invalid: '.$e->getMessage());
        }

        $this->client = (new Client)->setUserId(
            getenv('DHLPARCEL_ID')
        )->setApiKey(
            getenv('DHLPARCEL_SECRET')
        );

        parent::setUp();
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('dhlparcel.id', getenv('DHLPARCEL_ID'));
        $app['config']->set('dhlparcel.secret', getenv('DHLPARCEL_SECRET'));
    }

    /**
     * Get package providers.  At a minimum this is the package being tested, but also
     * would include packages upon which our package depends, e.g. Cartalyst/Sentry
     * In a normal app environment these would be added to the 'providers' array in
     * the config/app.php file.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            DhlParcelServiceProvider::class,
        ];
    }
}
