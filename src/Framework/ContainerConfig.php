<?php
// container config, please add your new service/dependency

use Rpl\Framework\DoctrineFactory;

return [
    "orm" => DoctrineFactory::createEntityManager()
];
