<?php

namespace Aptoma\Silex;

use Aptoma\ErrorHandler;
use Silex\Application as BaseApplication;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\HttpFoundation\Request;

/**
 * Aptoma\Applicataion extends Silex\Application and adds default behavior
 * and enhancements suited to our projects.
 *
 * @author Gunnar Lium <gunnar@aptoma.com>
 */
class Application extends BaseApplication
{

    public function __construct(array $values = array())
    {
        parent::__construct($values);

        $app = $this;

        $errorHandler = new ErrorHandler($app);
        $app->error(array($errorHandler, 'handle'));

        $app->register(
            new MonologServiceProvider(),
            array(
                'monolog.name' => $app['monolog.name'],
                'monolog.level' => $app['monolog.level'],
                'monolog.logfile' => $app['monolog.logfile'],
            )
        );

        $app->register(new ServiceControllerServiceProvider());

        $app->register(
            new TwigServiceProvider(),
            array(
                'twig.path' => $app['twig.path'],
                'twig.options' => $app['twig.options']
            )
        );

        // Register timer function
        $app->finish(
            function (Request $request) use ($app) {
                $execTime = round(microtime(true) - $app['timer.start'], 6) * 1000;
                $message = sprintf('Script executed in %sms.', $execTime);
                $context = array(
                    'msExecTime' => $execTime,
                    'method' => $request->getMethod(),
                    'path' => $request->getPathInfo(),
                );
                if ($request->getQueryString()) {
                    $context['query'] = $request->getQueryString();
                }
                if ($execTime < $app['timer.threshold_info']) {
                    $app['logger']->debug($message, $context);
                } elseif ($execTime < $app['timer.threshold_warning']) {
                    $app['logger']->info($message, $context);
                } else {
                    $app['logger']->warn($message, $context);
                }
            }
        );
    }
}
