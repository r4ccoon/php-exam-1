<?php

namespace Rpl\Framework\Entity;

use DI\Annotation\Inject;
use Doctrine\ORM\EntityManager;

trait RepositoryTrait
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
}