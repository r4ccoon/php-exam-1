<?php

namespace Rpl\Framework\ExceptionHandler;

use Klein\Exceptions\HttpException;
use Klein\Response;

class JsonExceptionHandler implements HttpExceptionHandlerInterface
{
    public function handle(HttpException $exception, Response $response): void
    {
        $response->code($exception->getCode());
        $response->json(
            [
                "error" => $exception->getMessage(),
                "trace" => $exception->getTraceAsString()
            ]
        );
    }
}