<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230605121944 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE egg_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE egg (id INT NOT NULL, environment_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, description TEXT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4837D942903E3A94 ON egg (environment_id)');
        $this->addSql('ALTER TABLE egg ADD CONSTRAINT FK_4837D942903E3A94 FOREIGN KEY (environment_id) REFERENCES environment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE egg_id_seq CASCADE');
        $this->addSql('ALTER TABLE egg DROP CONSTRAINT FK_4837D942903E3A94');
        $this->addSql('DROP TABLE egg');
    }
}
