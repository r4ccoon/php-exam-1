<?php

namespace Rpl\App\Middlewares;


use Klein\Exceptions\HttpException;
use Klein\Request;
use Klein\Response;
use Rpl\App\Entities\Product;
use Rpl\App\Serializer\ProductSerializer;
use Rpl\App\Service\ProductCreateService;
use Rpl\Framework\Middleware\MiddlewareInterface;
use Rpl\Framework\Middleware\RequestAttributeSet;
use Rpl\Framework\Middleware\ReturnObjectInterface;
use Rpl\Framework\Middleware\SimpleEntityReturnObject;

class ProductCreateHandler implements MiddlewareInterface
{
    /**
     * @var ProductCreateService
     */
    protected $productCreateService;

    /**
     * @var ProductSerializer
     */
    protected $serializer;

    public function __construct(ProductCreateService $productCreateService, ProductSerializer $serializer)
    {
        $this->productCreateService = $productCreateService;
        $this->serializer = $serializer;
    }

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
        if ($attributeSet->has("product")) {
            $product = $attributeSet->get("product");
        } else {
            $product = json_decode($request->body(), true);
        }

        $newProduct = new Product();
        $newProduct->setName($product['name']);
        $newProduct->setSku($product['sku']);

        $iso3 = $product['price']['currency'];
        $value = $product['price']['value'];

        try {
            $newProduct = $this->productCreateService->create($newProduct, $value, $iso3);

        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), 500);
        }

        if ($returnObject instanceof ReturnObjectInterface) {
            $returnObject->setObject($newProduct);
            $returnObject->setSerializer($this->serializer);
        }

        return null;
    }
}