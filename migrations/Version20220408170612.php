<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220408170612 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administrateurs DROP role');
        $this->addSql('ALTER TABLE clients DROP role');
        $this->addSql('ALTER TABLE etablissements DROP role');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administrateurs ADD role VARCHAR(60) DEFAULT NULL');
        $this->addSql('ALTER TABLE clients ADD role VARCHAR(60) DEFAULT NULL');
        $this->addSql('ALTER TABLE etablissements ADD role VARCHAR(60) DEFAULT NULL');
    }
}
