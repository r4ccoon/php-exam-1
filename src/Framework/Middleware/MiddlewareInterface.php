<?php

namespace Rpl\Framework\Middleware;


use Klein\Request;
use Klein\Response;

Interface MiddlewareInterface
{
    /**
     * @param Request $request
     * @param Response $response
     * @param ReturnObjectInterface $returnObject
     * @param RequestAttributeSet $attributeSet
     * @return Response|null
     */
    public function run(
        Request $request,
        Response $response,
        ReturnObjectInterface $returnObject = null,
        RequestAttributeSet $attributeSet = null
    ): ?Response;
}