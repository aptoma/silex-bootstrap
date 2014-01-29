<?php

$app = require __DIR__ . '/../app/app.php';

if ($app instanceof Silex\Application) {
    $app->run();
} else {
    die('Failed to initialize application.');
}
