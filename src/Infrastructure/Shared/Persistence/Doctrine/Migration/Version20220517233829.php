<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
class Version20220517233829 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE `snapshots` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `uuid` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT \'(DC2Type:guid)\',
              `playhead` int(10) unsigned NOT NULL,
              `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
              `recorded_on` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
              `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `UNIQ_5387574AD17F50A634B91FA9` (`uuid`,`playhead`)
            ) ENGINE=InnoDB AUTO_INCREMENT=660 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        ');
    }

    public function down(Schema $schema): void
    {
    }
}
