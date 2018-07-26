<?php

namespace Rpl\Framework\Route;

use DI\Annotation\Inject;
use Klein\Exceptions\HttpException;
use Klein\Request;
use Klein\Response;
use Rpl\Framework\Middleware\MiddlewareManagerTrait;
use Rpl\Framework\Middleware\RendererMiddleware;
use Rpl\Framework\ExceptionHandler\JsonExceptionHandler;

abstract class AbstractRoute implements RouterInterface
{
    use MiddlewareManagerTrait;

    /**
     * @Inject
     * @var RendererMiddleware
     */
    protected $rendererMiddleware;

    /**
     * @Inject
     * @var JsonExceptionHandler
     */
    protected $httpExceptionHandler;

    public abstract function initMiddlewares(): void;

    public function initRoute()
    {
        $this->initMiddlewares();
        $this->addMiddleware($this->rendererMiddleware);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @throws \Exception
     */
    public function handle(Request $request, Response $response): void
    {
        try {
            $response = $this->runMiddleware($request, $response);
            $response->send();
        } catch (HttpException $e) {
            $this->httpExceptionHandler->handle($e, $response);
        }
    }
}