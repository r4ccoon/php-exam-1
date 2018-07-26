<?php

namespace Rpl\App\Repository;

use DI\Annotation\Inject;
use Doctrine\ORM\EntityManager;
use Rpl\App\Entities\Product;

class ProductRepository
{
    /**
     * @Inject("orm")
     * @var EntityManager
     */
    protected $em;

    /**
     * @return EntityManager
     */
    public function getEm(): EntityManager
    {
        return $this->em;
    }

    /**
     * @param Product $product
     * @return Product
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function insert(Product $product): Product
    {
        $this->getEm()->persist($product);
        $this->getEm()->flush();

        return $product;
    }
}