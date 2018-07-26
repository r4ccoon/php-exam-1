<?php

namespace Rpl\App\Service;

use DI\Annotation\Inject;
use Rpl\App\Entities\Price;
use Rpl\App\Entities\Product;
use Rpl\App\Repository\ExchangeRateRepository;
use Rpl\App\Repository\PriceRepository;
use Rpl\App\Repository\ProductRepository;

class ProductCreateService
{
    /**
     * @Inject()
     * @var ExchangeRateRepository
     */
    protected $exchangeRateRepo;

    /**
     * @Inject()
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @Inject()
     * @var PriceRepository
     */
    private $priceRepository;

    /**
     * @param Product $newProduct
     * @param int $value
     * @param string $iso3
     * @return Product
     * @throws \Exception
     */
    public function create(Product $newProduct, $value = 0, $iso3 = 'EUR'): Product
    {
        try {
            $product = $this->productRepository->insert($newProduct);
            $price = $this->createPrice($product->getId(), $value, $iso3);

            $converted = $this->convertToEuro($price->getValue(), $price->getIso3());
            $this->createPrice($product->getId(), $converted, 'EUR');

            return $product;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param $productId
     * @param $value
     * @param $iso3
     * @return Price
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createPrice($productId, $value, $iso3)
    {
        $price = new Price();
        $price->setProductId($productId);
        $price->setIso3($iso3);
        $price->setValue($value);

        $price = $this->priceRepository->insert($price);

        return $price;
    }

    /**
     * @param $value
     * @param $iso3
     * @return null|float
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function convertToEuro($value, $iso3): ?float
    {
        // if it's in euro already, give it back
        if (strtolower($iso3) == "eur") {
            return $value;
        }

        $timestampToday = date(
            "Y-m-d H:i:s",
            mktime(0, 0, 0)
        );

        $exchangeRate = $this->exchangeRateRepo->findByDay($timestampToday, $iso3);

        if ($exchangeRate) {
            $converted = $value * $exchangeRate->getValue();

            return $converted;
        }

        return null;
    }

}