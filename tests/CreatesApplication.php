<?php

namespace Tests;

use App\Exceptions\Handler;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Contracts\Debug\ExceptionHandler;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        // Improve error handling for Mockery mock exception
        // See: https://github.com/laravel/ideas/issues/2528
        $app->instance(ExceptionHandler::class, new class($app) extends Handler {
            public function render($request, \Throwable $e)
            {
                if ($e instanceof \Mockery\Exception) {
                    throw $e;
                }

                return parent::render($request, $e);
            }
        });

        return $app;
    }
}
