<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230605130923 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE environment DROP CONSTRAINT fk_4626de22b2a1d860');
        $this->addSql('DROP INDEX idx_4626de22b2a1d860');
        $this->addSql('ALTER TABLE environment DROP species_id');
        $this->addSql('ALTER TABLE species ADD environment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE species ADD CONSTRAINT FK_A50FF712903E3A94 FOREIGN KEY (environment_id) REFERENCES environment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_A50FF712903E3A94 ON species (environment_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE species DROP CONSTRAINT FK_A50FF712903E3A94');
        $this->addSql('DROP INDEX IDX_A50FF712903E3A94');
        $this->addSql('ALTER TABLE species DROP environment_id');
        $this->addSql('ALTER TABLE environment ADD species_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE environment ADD CONSTRAINT fk_4626de22b2a1d860 FOREIGN KEY (species_id) REFERENCES species (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_4626de22b2a1d860 ON environment (species_id)');
    }
}
