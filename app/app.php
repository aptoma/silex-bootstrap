<?php
$startTime = microtime(true);
require_once __DIR__ . '/../vendor/autoload.php';

// This is the default config. See `deploy_config/README.md' for more info.
$config = array(
    'debug' => true,
    'timer.start' => $startTime,
    'monolog.name' => 'silex-bootstrap',
    'monolog.level' => \Monolog\Logger::DEBUG,
    'monolog.logfile' => __DIR__ . '/log/app.log',
    'twig.path' => __DIR__ . '/../src/App/views',
    'twig.options' => array(
        'cache' => __DIR__ . '/cache/twig',
    ),
);

// Apply custom config if available
if (file_exists(__DIR__ . '/config.php')) {
    include __DIR__ . '/config.php';
}

// Initialize Application
$app = new App\Silex\Application($config);

/**
 * Register controllers as services
 * @link http://silex.sensiolabs.org/doc/providers/service_controller.html
 **/
$app['app.default_controller'] = $app->share(
    function () use ($app) {
        return new \App\Controller\DefaultController($app['twig'], $app['logger']);
    }
);

// Map routes to controllers
include __DIR__ . '/routing.php';

return $app;
