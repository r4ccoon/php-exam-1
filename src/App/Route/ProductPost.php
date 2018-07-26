<?php

namespace Rpl\App\Route;

use DI\Annotation\Inject;
use Rpl\Framework\Middleware\JwtValidatorMiddleware;
use Rpl\App\Middlewares\ProductCreateHandler;
use Rpl\App\Middlewares\ProductValidatorMiddleware;
use Rpl\Framework\Route\AbstractRoute;

class ProductPost extends AbstractRoute
{
    /**
     * @Inject
     * @var JwtValidatorMiddleware
     */
    protected $jwtValidatorMiddleware;

    /**
     * @Inject
     * @var ProductValidatorMiddleware
     */
    protected $productValidatorMiddleware;

    /**
     * @Inject
     * @var ProductCreateHandler
     */
    protected $productCreateHandler;

    public function initMiddlewares(): void
    {
     //   $this->addMiddleware($this->jwtValidatorMiddleware);
        $this->addMiddleware($this->productValidatorMiddleware);
        $this->addMiddleware($this->productCreateHandler);
    }

    public function getMethods(): array
    {
        return ["POST"];
    }

    public function getHandledRoute(): string
    {
        return "/v1/products";
    }
}
