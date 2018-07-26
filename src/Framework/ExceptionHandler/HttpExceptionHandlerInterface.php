<?php

namespace Rpl\Framework\ExceptionHandler;

use Klein\Exceptions\HttpException;
use Klein\Response;

interface HttpExceptionHandlerInterface
{
    public function handle(HttpException $exception, Response $response): void;
}