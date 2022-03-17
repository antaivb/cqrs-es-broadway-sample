<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220317151242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id BINARY(36) NOT NULL COMMENT \'(DC2Type:user_id)\', name VARCHAR(2000) NOT NULL COMMENT \'(DC2Type:name)\', creation_date DATETIME NOT NULL COMMENT \'(DC2Type:creation_date)\', email VARCHAR(70) NOT NULL COMMENT \'(DC2Type:email)\', password VARCHAR(255) NOT NULL, password_recovery_salt VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
    }
}
