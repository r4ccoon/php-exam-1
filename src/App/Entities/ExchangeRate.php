<?php

namespace Rpl\App\Entities;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Rpl\Framework\Entity\EntityInterface;
use Rpl\Framework\serializer\SerializableInterface;

/**
 *
 * @Entity(repositoryClass="Rpl\App\Repository\ExchangeRateRepository")
 */
class ExchangeRate implements EntityInterface, SerializableInterface
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
    private $date;

    /**
     * @Column(type="string", nullable=false)
     * @var string
     */
    private $currency;

    /**
     * @Column(type="float", nullable=false)
     * @var float
     */
    private $value;

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @param float $value
     */
    public function setValue(float $value): void
    {
        $this->value = $value;
    }
}
