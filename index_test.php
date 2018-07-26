<?php

use Rpl\Framework\Main;

require_once __DIR__ . '/vendor/autoload.php';

// load config from .env file
$dotenv = new Dotenv\Dotenv(__DIR__, ".env-test");
$dotenv->load();

$app = new Main();
$app->run();
