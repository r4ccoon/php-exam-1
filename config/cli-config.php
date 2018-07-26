<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Rpl\Framework\DoctrineFactory;

if (getenv("APP_ENV") == "TEST") {
    $envPath = ".env-test";
} else {
    $envPath = ".env";
}

$dotenv = new Dotenv\Dotenv(__DIR__ . "/../", $envPath);
$dotenv->load();

// replace with mechanism to retrieve EntityManager in your app
$entityManager = DoctrineFactory::createEntityManager();

return ConsoleRunner::createHelperSet($entityManager);
