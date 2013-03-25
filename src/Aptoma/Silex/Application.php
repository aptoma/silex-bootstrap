<?php

namespace Aptoma\Silex;

use Aptoma\ErrorHandler;
use Silex\Application as BaseApplication;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\HttpFoundation\Request;

/**
 * Aptoma\Application extends Silex\Application and adds default behavior
 * and enhancements suited to our projects.
 *
 * @TODO: We should consider further subclassing this class to a more application
 *        specific set of features in the App namespace. This concrete class
 *        should provide the shared feature set ALL projects should use, and
 *        thus be suited for inclusion through Composer (to ease updates
 *        across projects).
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
        $app->finish(array($app, 'logExecTime'));
    }

    public function logExecTime(Request $request)
    {
        $execTime = round(microtime(true) - $this['timer.start'], 6) * 1000;
        $message = sprintf('Script executed in %sms.', $execTime);
        $context = array(
            'msExecTime' => $execTime,
            'method' => $request->getMethod(),
            'path' => $request->getPathInfo(),
        );
        if ($request->getQueryString()) {
            $context['query'] = $request->getQueryString();
        }
        if ($execTime < $this['timer.threshold_info']) {
            $this['logger']->debug($message, $context);
        } elseif ($execTime < $this['timer.threshold_warning']) {
            $this['logger']->info($message, $context);
        } else {
            $this['logger']->warn($message, $context);
        }
    }
}
