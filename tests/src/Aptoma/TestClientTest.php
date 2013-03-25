<?php


namespace Aptoma;

use Symfony\Component\HttpFoundation\Request;

class TestClientTest extends BaseWebTestCase
{
    public function testPostJson()
    {
        $client = $this->getMock('\Aptoma\TestClient', array('request'), array($this->app));
        $client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('POST'),
                $this->equalTo('/url'),
                $this->equalTo(array()),
                $this->equalTo(array()),
                $this->equalTo(array()),
                $this->equalTo(json_encode(array('foo' => 'bar')))
            );

        $client->postJson('/url', array('foo' => 'bar'));
    }

    public function testPutJson()
    {
        $client = $this->getMock('\Aptoma\TestClient', array('request'), array($this->app));
        $client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('PUT'),
                $this->equalTo('/url'),
                $this->equalTo(array()),
                $this->equalTo(array()),
                $this->equalTo(array()),
                $this->equalTo(json_encode(array('foo' => 'bar')))
            );

        $client->putJson('/url', array('foo' => 'bar'));
    }
}
