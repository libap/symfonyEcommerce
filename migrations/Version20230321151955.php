<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230321151955 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user CHANGE login login VARCHAR(255) DEFAULT NULL, CHANGE password password VARCHAR(255) DEFAULT NULL, CHANGE adress adress VARCHAR(255) DEFAULT NULL, CHANGE postal_code postal_code VARCHAR(255) DEFAULT NULL, CHANGE city city VARCHAR(255) DEFAULT NULL, CHANGE first_name first_name VARCHAR(255) DEFAULT NULL, CHANGE last_name last_name VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` CHANGE login login VARCHAR(255) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL, CHANGE adress adress VARCHAR(255) NOT NULL, CHANGE postal_code postal_code VARCHAR(255) NOT NULL, CHANGE city city VARCHAR(255) NOT NULL, CHANGE first_name first_name VARCHAR(255) NOT NULL, CHANGE last_name last_name VARCHAR(255) NOT NULL');
    }
}
