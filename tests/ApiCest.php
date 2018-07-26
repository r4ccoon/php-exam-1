<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Rpl\Framework\DoctrineFactory;

class ApiCest
{
    public function _before(\ApiTester $I)
    {
        $dotenv = new Dotenv\Dotenv(__DIR__ . '/../', ".env-test");
        $dotenv->load();

        $em = DoctrineFactory::createEntityManager();
        $persister = $em->getUnitOfWork()->getEntityPersister('\Rpl\App\Entities\Product');

        $all = $persister->loadAll([]);
        foreach ($all as $prod) {
            $em->remove($prod);
        }

        $em->flush();
    }

    public function _after(\ApiTester $I)
    {
        // todo: delete test database
    }

    public function tryApi(ApiTester $I)
    {
        $params = [
            "name" => "barassewa",
            "sku" => "awffffffffffe",
            "price" => [
                "value" => 5,
                "currency" => "CNY"
            ]
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/v1/products', $params);
        $I->seeResponseCodeIs(200);
    }
}