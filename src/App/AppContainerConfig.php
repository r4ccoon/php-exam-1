<?php
// container config, please add your new service/dependency

return [
    'Rpl\App\Repository\ExchangeRateRepository' => DI\factory(
        function (\DI\Container $c) {
            $em = $c->get('orm');

            return $em->getRepository('Rpl\App\Entities\ExchangeRate');
        }
    ),
    'Rpl\App\Repository\PriceRepository' => DI\factory(
        function (\DI\Container $c) {
            $em = $c->get('orm');

            return $em->getRepository('Rpl\App\Entities\Price');
        }
    )
];
