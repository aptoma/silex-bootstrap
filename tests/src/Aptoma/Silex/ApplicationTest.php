<?php


namespace Aptoma\Silex;

use Aptoma\BaseWebTestCase;
use Symfony\Component\HttpFoundation\Request;

class ApplicationTest extends BaseWebTestCase
{
    public function testLoggerIsRegistered()
    {
        $this->assertTrue($this->app->offsetExists('logger'));
    }

    public function testServiceControllerIsRegistered()
    {
        $this->assertTrue($this->app->offsetExists('resolver'));
        $this->assertInstanceOf('Silex\ServiceControllerResolver', $this->app['resolver']);
    }

    public function testTwigIsRegistered()
    {
        $this->assertTrue($this->app->offsetExists('twig'));
    }
}
