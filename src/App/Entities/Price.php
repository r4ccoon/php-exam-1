<?php

namespace Rpl\App\Entities;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Rpl\Framework\Entity\EntityInterface;
use Rpl\Framework\serializer\SerializableInterface;

/**
 * @Entity(repositoryClass="Rpl\App\Repository\PriceRepository")
 */
class Price implements EntityInterface, SerializableInterface
{
    /**
     * @Id @Column(type="integer") @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @Column(type="string", length=32, nullable=false)
     * @var string
     */
    private $productId;

    /**
     * @Column(type="float", nullable=false)
     * @var string
     */
    private $value;

    /**
     * @Column(type="string", length=32, nullable=false)
     * @var string
     */
    private $iso3;

    /**
     * @return string
     */
    public function getProductId(): string
    {
        return $this->productId;
    }

    /**
     * @param string $productId
     */
    public function setProductId(string $productId): void
    {
        $this->productId = $productId;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getIso3(): string
    {
        return $this->iso3;
    }

    /**
     * @param string $iso3
     */
    public function setIso3(string $iso3): void
    {
        $this->iso3 = $iso3;
    }
}
