<?php

namespace Aptoma;

use Symfony\Component\HttpKernel\Client as BaseClient;

class TestClient extends BaseClient
{
    /**
     * Shortcut method for simple POSTing JSON-encoded data
     *
     * @param $url
     * @param $data
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    public function postJson($url, $data)
    {
        return $this->request(
            'POST',
            $url,
            array(),
            array(),
            array(),
            json_encode($data)
        );
    }

    /**
     * Shortcut method for simple PUTing of JSON-encoded data
     *
     * @param $url
     * @param $data
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    public function putJson($url, $data)
    {
        return $this->request(
            'PUT',
            $url,
            array(),
            array(),
            array(),
            json_encode($data)
        );
    }

    /**
     * Override getResponse to provide actual return value hinting.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getResponse()
    {
        return parent::getResponse();
    }
}
