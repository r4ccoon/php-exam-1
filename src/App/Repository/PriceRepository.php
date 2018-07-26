<?php

namespace Rpl\App\Repository;

use Doctrine\ORM\EntityRepository;
use Rpl\App\Entities\Price;

class PriceRepository extends EntityRepository
{
    /**
     * @param Price $price
     * @return Price
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function insert(Price $price): Price
    {
        $this->_em->persist($price);
        $this->_em->flush();

        return $price;
    }

    /**
     * @param $productId
     * @return array array of Price
     */
    public function findByProductId($productId): array
    {
        return $this->findBy(["productId" => $productId], ["id" => "DESC"]);
    }
}