<?php

namespace Rpl\App\Middlewares;

use Klein\Exceptions\HttpException;
use Klein\Request;
use Klein\Response;
use Rpl\Framework\Middleware\MiddlewareInterface;
use Rpl\Framework\Middleware\RequestAttributeSet;
use Rpl\Framework\Middleware\ReturnObjectInterface;

class ProductValidatorMiddleware implements MiddlewareInterface
{
    /**
     * @param Request $request
     * @param Response $response
     * @param ReturnObjectInterface $returnObject
     * @param RequestAttributeSet|null $attributeSet
     * @return Response|null
     */
    public function run(
        Request $request,
        Response $response,
        ReturnObjectInterface $returnObject = null,
        RequestAttributeSet $attributeSet = null
    ): ?Response {
        $this->checkValidity($request, $attributeSet);

        return null;
    }

    private function checkValidity(Request $request, RequestAttributeSet $attributeSet): void
    {
        $parsed = json_decode($request->body(), true);

        if ($parsed) {
            $reqFields = ["sku", "name", "price"];
            $reqPriceFields = ["value", "currency"];

            foreach ($reqFields as $reqField) {
                if (!isset($parsed[$reqField])) {
                    throw new HttpException("invalid request body, missing " . $reqField, 400);
                }

                if ($reqField == "price") {
                    if (isset($parsed["price"])) {
                        foreach ($reqPriceFields as $priceField) {
                            if (!isset($parsed[$reqField][$priceField])) {
                                throw new HttpException(
                                    "invalid request body, missing price field " .
                                    $priceField, 400
                                );
                            }
                        }
                    }
                }
            }

            $attributeSet->set("product", $parsed);
        }
    }
}