<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220408195341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administrateurs ADD COLUMN roles VARCHAR(60) AFTER admid DEFAULT ROLE_ADMIN');
        $this->addSql('ALTER TABLE clients ADD COLUMN roles VARCHAR(60) AFTER cliid DEFAULT ROLE_USER');
        $this->addSql('ALTER TABLE etablissements ADD COLUMN roles VARCHAR(60) AFTER etaid DEFAULT ROLE_GERANT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administrateurs ADD COLUMN roles VARCHAR(60) AFTER admid DEFAULT ROLE_ADMIN');
        $this->addSql('ALTER TABLE clients ADD COLUMN roles VARCHAR(60) AFTER cliid DEFAULT ROLE_USER');
        $this->addSql('ALTER TABLE etablissements ADD COLUMN roles VARCHAR(60) AFTER etaid DEFAULT ROLE_GERANT');
    }
}
