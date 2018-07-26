<?php

namespace Rpl\App\Repository;

use Doctrine\ORM\EntityRepository;
use Rpl\App\Entities\ExchangeRate;

class ExchangeRateRepository extends EntityRepository
{
    /**
     * @param ExchangeRate $rate
     * @return ExchangeRate
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function insert(ExchangeRate $rate): ExchangeRate
    {
        $this->_em->persist($rate);
        $this->_em->flush();

        return $rate;
    }

    /**
     * @param $timestampToday
     * @param $iso3
     * @return null|ExchangeRate
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function findByDay($timestampToday, $iso3): ?ExchangeRate
    {
        $rate = $this->findOneBy(["currency" => $iso3, "date" => $timestampToday]);

        // we dont have the data yet in db, so we do then fetch to 3rd party api
        if (!$rate) {
            $fromFixer = $this->getFromFixer($timestampToday, $iso3);
            if (!$fromFixer) {
                throw new \Exception("failed to get data from fixer");
            }

            return $fromFixer;
        }

        return $rate;
    }

    /**
     * @param $timeStampDate
     * @param $iso3
     * @return int|ExchangeRate
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function getFromFixer($timeStampDate, $iso3)
    {
        $url =
            sprintf(
                "https://exchangeratesapi.io/api/latest?format=1&base=%s&symbols=EUR",
                $iso3

            );

        $rate = json_decode(file_get_contents($url), true);

        if ($rate) {
            $exRate = new ExchangeRate();
            $exRate->setCurrency($iso3);
            $exRate->setDate($timeStampDate);
            $exRate->setValue($rate["rates"]["EUR"]);

            $this->insert($exRate);

            return $exRate;
        }

        return 0;
    }
}