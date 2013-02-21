<?php

namespace Aptoma;

use Aptoma\Silex\Application;
use Silex\WebTestCase;

class BaseWebTestCase extends WebTestCase
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @return Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../../app/app.php';
        $app['debug'] = false;
        $app['exception_handler']->disable();

        return $app;
    }

    /**
     * Creates a TestClient.
     *
     * @param array $server An array of server parameters
     *
     * @return TestClient A Client instance
     */
    public function createClient(array $server = array())
    {
        return new TestClient($this->app, $server);
    }

    /**
     * Create a client with basic auth credentials.
     *
     * @param array $server
     * @return TestClient
     */
    protected function createAuthorizedClient(array $server = array())
    {
        return $this->createClient(
            array_merge(
                array(
                    'PHP_AUTH_USER' => 'username',
                    'PHP_AUTH_PW'   => 'password',
                ),
                $server
            )
        );
    }
}
