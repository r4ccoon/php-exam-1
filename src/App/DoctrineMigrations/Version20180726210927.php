<?php declare(strict_types=1);

namespace Rpl\App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180726210927 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("DROP TABLE IF EXISTS `ExchangeRate`;");
        $this->addSql(
            "CREATE TABLE `ExchangeRate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `currency` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
        );

        $this->addSql("DROP TABLE IF EXISTS `Price`;");
        $this->addSql(
            "CREATE TABLE `Price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productId` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `value` double NOT NULL,
  `iso3` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
        );

        $this->addSql("DROP TABLE IF EXISTS `Product`;");
        $this->addSql(
            "CREATE TABLE `Product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sku` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1CF73D31F9038C4` (`sku`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql("DROP TABLE IF EXISTS `ExchangeRate`;");
        $this->addSql("DROP TABLE IF EXISTS `Price`;");
        $this->addSql("DROP TABLE IF EXISTS `Product`;");
    }
}
