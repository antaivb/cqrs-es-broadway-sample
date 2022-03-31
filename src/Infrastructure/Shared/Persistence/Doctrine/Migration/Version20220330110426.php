<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220330110426 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (id BINARY(36) NOT NULL COMMENT \'(DC2Type:booking_id)\', user_id BINARY(36) DEFAULT NULL COMMENT \'(DC2Type:user_id)\', session_id BINARY(36) DEFAULT NULL COMMENT \'(DC2Type:session_id)\', creation_date DATETIME NOT NULL COMMENT \'(DC2Type:creation_date)\', unsubscribed_at DATETIME NOT NULL COMMENT \'(DC2Type:unsubscribed_at)\', INDEX IDX_E00CEDDEA76ED395 (user_id), INDEX IDX_E00CEDDE613FECDF (session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id BINARY(36) NOT NULL COMMENT \'(DC2Type:session_id)\', `when` DATETIME NOT NULL, duration INT NOT NULL, status SMALLINT NOT NULL, creation_date DATETIME NOT NULL COMMENT \'(DC2Type:creation_date)\', updated_at DATETIME DEFAULT NULL, max_participants INT NOT NULL, num_bookings INT NOT NULL, url VARCHAR(255) NOT NULL, host_url VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE613FECDF');
        $this->addSql('CREATE TABLE events (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci` COMMENT \'(DC2Type:guid)\', playhead INT UNSIGNED NOT NULL, payload LONGTEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, metadata LONGTEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, recorded_on VARCHAR(32) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, type VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, UNIQUE INDEX UNIQ_5387574AD17F50A634B91FA9 (uuid, playhead), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE booking');
    }
}
