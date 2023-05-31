<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230523100623 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE environment ADD type_ofneed VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE environment ADD levelof_satisfaction INT NOT NULL');
        $this->addSql('ALTER TABLE environment ADD priority VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE environment DROP type_ofneed');
        $this->addSql('ALTER TABLE environment DROP levelof_satisfaction');
        $this->addSql('ALTER TABLE environment DROP priority');
    }
}
