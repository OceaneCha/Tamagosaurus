<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230523084153 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tamagosaurus ADD type_id INT NOT NULL');
        $this->addSql('ALTER TABLE tamagosaurus ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE tamagosaurus ADD CONSTRAINT FK_BC26DAA2C54C8C93 FOREIGN KEY (type_id) REFERENCES species (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_BC26DAA2C54C8C93 ON tamagosaurus (type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE tamagosaurus DROP CONSTRAINT FK_BC26DAA2C54C8C93');
        $this->addSql('DROP INDEX IDX_BC26DAA2C54C8C93');
        $this->addSql('ALTER TABLE tamagosaurus DROP type_id');
        $this->addSql('ALTER TABLE tamagosaurus DROP name');
    }
}
