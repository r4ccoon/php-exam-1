<?php

namespace Rpl\Framework\Middleware;

use Klein\Request;
use Klein\Response;

trait MiddlewareManagerTrait
{
    /**
     * @var array MiddlewareInterface[]
     */
    private $middlewares;

    public function __construct()
    {
        $this->middlewares = [];
    }

    public function addMiddleware(MiddlewareInterface $middleware)
    {
        array_push($this->middlewares, $middleware);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws \Exception
     */
    public function runMiddleware(Request $request, Response $response): Response
    {
        $resp = null;
        $returnObject = new SimpleEntityReturnObject();
        $attributeSet = new RequestAttributeSet();

        foreach ($this->middlewares as $mid) {
            $resp = $mid->run($request, $response, $returnObject, $attributeSet);

            // we will run all added middleware, however if one of the middleware return Response,
            // then it will stop looping and return the response directly
            if ($resp instanceof Response) {
                return $resp;
            }
        }

        if (!$resp) {
            throw new \Exception("one of the middleware must return Klein\Response");
        }
    }
}