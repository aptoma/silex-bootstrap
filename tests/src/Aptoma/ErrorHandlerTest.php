<?php

namespace Aptoma;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ErrorHandlerTest extends BaseWebTestCase
{
    public function testErrorHandlerShouldReturnNullIfAcceptedContentTypeIsNotJson()
    {
        $errorHandler = new ErrorHandler($this->app);
        $errorHandler->setRequest(
            new Request(
                array(),
                array(),
                array(),
                array(),
                array(),
                array('HTTP_ACCEPT' => 'application/xml')
            )
        );

        $this->assertNull($errorHandler->handle(new HttpException(404), 404));
    }

    public function testErrorHandlerShouldReturnJsonDataWithMessageAndStatisCode()
    {
        $errorHandler = new ErrorHandler($this->app);
        $errorHandler->setRequest(
            new Request(
                array(),
                array(),
                array(),
                array(),
                array(),
                array('HTTP_ACCEPT' => 'application/json')
            )
        );

        $response = $errorHandler->handle(new HttpException(404, 'Error'), 400);
        $data = json_decode($response->getContent(), true);
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\JsonResponse', $response);
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('Error', $data['message']);
        $this->assertEquals(404, $data['status']);
        $this->assertEquals(400, $data['code']);
    }
}
