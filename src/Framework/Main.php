<?php

namespace Rpl\Framework;

use Klein\Klein;
use DI\Container;
use DI\ContainerBuilder;

class Main
{
    /**
     * @var
     */
    protected $entityManager;

    /**
     * DI container
     *
     * @var Container
     */
    private $container;

    public function __construct()
    {
        $this->createContainer();
        $this->registerRoutes();
    }

    /**
     * dispatch Klein route to handle requests
     *
     * @return void
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function run()
    {
        $this->container->get(Klein::class)->dispatch();
    }

    private function registerRoutes()
    {
        $this->container->get(RouteManager::class)->initRoutes();
    }

    /**
     * create dependency container, only need to create 1 container per app
     *
     * @return Container
     * @throws \Exception
     */
    private function createContainer(): Container
    {
        if (!$this->container) {
            $containerBuilder = new ContainerBuilder();
            $containerBuilder->useAnnotations(true);

            $containerBuilder->addDefinitions(__DIR__ . '/ContainerConfig.php');
            $containerBuilder->addDefinitions(__DIR__ . '/../App/AppContainerConfig.php');

            $this->container = $containerBuilder->build();
        }

        return $this->container;
    }
}
