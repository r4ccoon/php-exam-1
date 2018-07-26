<?php

namespace Rpl\Framework\Middleware;

use Klein\Request;
use Klein\Response;
use Rpl\Framework\Exception\NonSerializableException;

class RendererMiddleware implements MiddlewareInterface
{
    /**
     * @param Request $request
     * @param Response $response
     * @param ReturnObjectInterface $returnObject
     * @param RequestAttributeSet|null $attributeSet
     * @return Response|null
     * @throws NonSerializableException
     */
    public function run(
        Request $request,
        Response $response,
        ReturnObjectInterface $returnObject = null,
        RequestAttributeSet $attributeSet = null
    ): ?Response {
        if ($returnObject !== null) {
            // check for content negotiation
            if ($request->headers()->exists("Accept")) {
                $contentType = $request->headers()->get("Accept");
                if ($this->isContentType("xml", $contentType)) {
                    //$response->body("ok");
                    // todo: make sure it return html using twig maybe
                    $this->jsonResponse($response, $returnObject);
                } else {
                    $this->jsonResponse($response, $returnObject);
                }
            }
        }

        return $response;
    }

    /**
     * @param string $ct comma separated content type / mime
     * @param string $fromBrowser
     * @return bool
     */
    private function isContentType(string $ct, string $fromBrowser): bool
    {
        return strpos($fromBrowser, $ct) > 0;
    }

    /**
     * @param $response
     * @param $returnObject
     * @throws NonSerializableException
     */
    private function jsonResponse(&$response, $returnObject)
    {
        $response->headers()->set("Content-Type", "application/json");
        if ($returnObject instanceof ReturnObjectInterface) {
            $serializer = $returnObject->getSerializer();
            $response->body($serializer->serialize($returnObject->getObject()));
            //$response->body("[]");
        } else {
            throw new NonSerializableException("Serializing non compatible object");
        }
    }
}