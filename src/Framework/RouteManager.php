<?php

namespace Rpl\Framework;

use DI\Container;
use Klein\Klein;
use Rpl\Framework\Route\RouterInterface;

class RouteManager
{
    /**
     * @var Container
     */
    protected $container;

    /**
     *
     * @var Klein
     */
    private $router;

    public function __construct(Klein $router, Container $container)
    {
        $this->router = $router;
        $this->container = $container;
    }

    public function initRoutes()
    {
        $dir = join(
            DIRECTORY_SEPARATOR,
            [
                __DIR__,
                "..",
                "App",
                "Route"
            ]
        );

        foreach (glob($dir . '/*.php') as $file) {
            $qdn = $this->parseFilename($file);

            /**
             * @var RouterInterface $routeService
             */
            //print_r($this->container->getKnownEntryNames());
            $routeService = $this->container->get($qdn);
            $routeService->initRoute();
            
            $this->router->respond(
            // method e.g.: POST, GET
                $routeService->getMethods(),

                // route path
                $routeService->getHandledRoute(),

                // handler function
                [$routeService, "handle"]
            );
        }
    }

    /**
     * parse file path into fully qualified namespace + classname
     *
     * @param string $filePath
     * @return string
     */
    private function parseFilename(string $filePath): string
    {
        $parts = pathinfo($filePath);
        $fn = $parts["filename"];

        $qdn = "Rpl\App\Route\\" . $fn;

        return $qdn;
    }
}
