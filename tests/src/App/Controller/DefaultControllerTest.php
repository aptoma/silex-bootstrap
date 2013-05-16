<?php

namespace App\Controller;

use App\BaseWebTestCase;

class DefaultControllerTest extends BaseWebTestCase
{
    public function testIndexContent()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Silex Bootstrap', $crawler->filter('h1')->text());
    }
}
