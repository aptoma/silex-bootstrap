<?php

namespace Aptoma;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ErrorHandlerTest extends BaseWebTestCase
{
    public function testHandleShouldReturnNullIfRequestDoesNotAcceptJsonResponse()
    {
        $request = new Request();
        $request->headers->set('Accept', 'application/xml');

        $errorHandler = new ErrorHandler($this->app);
        $errorHandler->setRequest($request);

        $this->assertNull($errorHandler->handle(new HttpException(404), 404));
    }

    public function testHandleShouldReturnNullIfNoValidRequestIsAvailable()
    {
        $errorHandler = new ErrorHandler($this->app);

        $this->assertNull($errorHandler->handle(new HttpException(404), 404));
    }

    public function testHandleShouldNotReturnNullIfValidRequestIsAvailable()
    {
        $errorHandler = new ErrorHandler($this->app);
        $request = new Request();
        $request->headers->set('Accept', 'application/json');
        $this->app['request'] = $request;

        $this->assertNotNull($errorHandler->handle(new HttpException(404), 404));
    }

    public function testHandleShouldReturnJsonResponse()
    {
        $request = new Request();
        $request->headers->set('Accept', 'application/json');

        $errorHandler = new ErrorHandler($this->app);
        $errorHandler->setRequest($request);

        $response = $errorHandler->handle(new HttpException(404, 'Foo Bar'), 400);
        $body = json_decode($response->getContent(), true);

        $this->assertInstanceOf('\Symfony\Component\HttpFoundation\JsonResponse', $response);
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals(
            array(
                'status' => 404,
                'code' => 400,
                'message' => 'Foo Bar',
            ),
            $body
        );
    }
}
