<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220415210217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administrateurs CHANGE password password CHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE clients CHANGE password password CHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE etablissements CHANGE password password CHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reservations RENAME INDEX reservations_ibfk_3_idx TO IDX_4DA239C458EC53');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administrateurs CHANGE password password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE clients CHANGE password password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE etablissements CHANGE password password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reservations RENAME INDEX idx_4da239c458ec53 TO reservations_ibfk_3_idx');
    }
}
