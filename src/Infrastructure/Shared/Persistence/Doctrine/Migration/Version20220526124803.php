<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220526124803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (id BINARY(36) NOT NULL COMMENT \'(DC2Type:booking_id)\', user_id BINARY(36) DEFAULT NULL COMMENT \'(DC2Type:user_id)\', session_id BINARY(36) DEFAULT NULL COMMENT \'(DC2Type:session_id)\', creation_date DATETIME NOT NULL COMMENT \'(DC2Type:creation_date)\', unsubscribed_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:unsubscribed_at)\', amount DOUBLE PRECISION NOT NULL, iso_code VARCHAR(255) NOT NULL, INDEX IDX_E00CEDDEA76ED395 (user_id), INDEX IDX_E00CEDDE613FECDF (session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id BINARY(36) NOT NULL COMMENT \'(DC2Type:session_id)\', duration INT NOT NULL COMMENT \'(DC2Type:duration)\', status INT NOT NULL COMMENT \'(DC2Type:status)\', creation_date DATETIME NOT NULL COMMENT \'(DC2Type:creation_date)\', `when` DATETIME NOT NULL COMMENT \'(DC2Type:when)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:updated_at)\', max_participants INT NOT NULL COMMENT \'(DC2Type:maxParticipants)\', num_bookings INT NOT NULL COMMENT \'(DC2Type:numBookings)\', meeting_url VARCHAR(255) NOT NULL, meeting_host_url VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id BINARY(36) NOT NULL COMMENT \'(DC2Type:user_id)\', name VARCHAR(2000) NOT NULL COMMENT \'(DC2Type:name)\', creation_date DATETIME NOT NULL COMMENT \'(DC2Type:creation_date)\', email VARCHAR(70) NOT NULL COMMENT \'(DC2Type:email)\', password VARCHAR(255) NOT NULL, password_recovery_salt VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE613FECDF');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEA76ED395');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE user');
    }
}
