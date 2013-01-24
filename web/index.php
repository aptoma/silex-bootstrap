<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpKernel\Debug\ErrorHandler;
ErrorHandler::register(); // Convert errors to exceptions

$app = require __DIR__ . '/../app/app.php';
if ($app instanceof Silex\Application) {
    $app->run();
}
