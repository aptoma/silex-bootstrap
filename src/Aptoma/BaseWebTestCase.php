<?php

namespace Aptoma;

use Silex\WebTestCase;

class BaseWebTestCase extends WebTestCase
{

    public function createApplication()
    {
        $app = require __DIR__.'/../../app/app.php';
        $app['debug'] = false;

        unset($app['exception_handler']);
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
     * @return TestClient
     */
    protected function createAuthorizedClient()
    {
        return $this->createClient(
            array(
                'PHP_AUTH_USER' => 'username',
                'PHP_AUTH_PW'   => 'password',
            )
        );
    }
}
