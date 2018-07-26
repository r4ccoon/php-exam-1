<?php

namespace Rpl\App\Serializer;

use DI\Annotation\Inject;
use Rpl\App\Entities\Price;
use Rpl\App\Entities\Product;
use Rpl\App\Repository\PriceRepository;
use Rpl\Framework\Serializer\SerializableInterface;
use Rpl\Framework\Serializer\SerializerInterface;

class ProductSerializer implements SerializerInterface
{
    /**
     * @Inject()
     * @var PriceRepository
     */
    private $priceRepository;

    public function serialize(SerializableInterface $object): string
    {
        if ($object instanceof Product) {
            $id = $object->getId();

            /**
             * @var Price $prices []
             */
            $prices = $this->priceRepository->findByProductId($id);
            $priceArray = [];

            if (is_array($prices)) {
                foreach ($prices as $price) {
                    $priceArray[] = [
                        "currency" => $price->getIso3(),
                        "value" => $price->getValue()
                    ];
                }
            }

            return json_encode(
                [
                    "id" => $object->getId(),
                    "sku" => $object->getSku(),
                    "name" => $object->getName(),
                    "price" => $priceArray
                ]
            );
        }

        // it does not get a proper product entity object
        return json_encode(["broken product entity"]);
    }
}