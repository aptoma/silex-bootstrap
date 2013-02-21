<?php

namespace Aptoma\Silex;

use Aptoma\BaseWebTestCase;
use Symfony\Component\HttpFoundation\Request;

class BaseWebTestCaseTest extends BaseWebTestCase
{
    public function testCreateApplication()
    {
        $app = $this->createApplication();
        $this->assertInstanceOf('Aptoma\Silex\Application', $app);
        $this->assertFalse($app['debug']);
    }

    public function testCreateClient()
    {
        $this->assertInstanceOf('Aptoma\TestClient', $this->createClient());
    }

    public function testCreateAuthorizedClient()
    {
        $client = $this->createAuthorizedClient(array('test_key' => 'test_value'));
        $this->assertEquals('test_value', $client->getServerParameter('test_key'));
        $this->assertEquals('username', $client->getServerParameter('PHP_AUTH_USER'));
        $this->assertEquals('password', $client->getServerParameter('PHP_AUTH_PW'));
    }
}
