<?php

use Illuminate\Contracts\Http\Kernel as HttpKernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel...
$app = require_once __DIR__.'/../bootstrap/app.php';

/** @var \Illuminate\Contracts\Http\Kernel $kernel */
$kernel = $app->make(HttpKernel::class);

$request = Request::capture();
$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);

