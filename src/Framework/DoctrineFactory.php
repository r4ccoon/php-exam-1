<?php

namespace Rpl\Framework;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class DoctrineFactory
{
    public static function createEntityManager()
    {
        if (getenv("APP_ENV") == "dev") {
            $isDevMode = true;
        } else {
            $isDevMode = false;
        }

        $paths = array(__DIR__ . "/../app/entities");

        // the connection configuration
        $dbParams = array(
            'driver' => 'pdo_mysql',
            'user' => getenv("DATABASE_USER"),
            'password' => getenv("DATABASE_PASSWORD"),
            'dbname' => getenv("DATABASE_NAME"),
            'host' => getenv("DATABASE_HOST"),
        );

        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);

        $entityManager = EntityManager::create($dbParams, $config);

        try {
            $entityManager->getConnection()->connect();
        } catch (\Exception $e) {
            self::createDatabase(
                $dbParams['dbname'],
                [
                    'driver' => 'pdo_mysql',
                    'user' => getenv("DATABASE_USER"),
                    'password' => getenv("DATABASE_PASSWORD"),
                    'host' => getenv("DATABASE_HOST"),
                ]
            );
        }

        return $entityManager;
    }

    private static function createDatabase($name, array $config): void
    {
        /** @var \Doctrine\DBAL\Connection */
        $tmpConnection = \Doctrine\DBAL\DriverManager::getConnection($config);

        // Check if the database already exists
        if (in_array($name, $tmpConnection->getSchemaManager()->listDatabases())) {
            return;
        }

        // Create the database
        $tmpConnection->getSchemaManager()->createDatabase($name);
        $tmpConnection->close();
    }
}
