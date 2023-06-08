<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230605131954 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE environment ALTER type_ofneed DROP NOT NULL');
        $this->addSql('ALTER TABLE environment ALTER levelof_satisfaction DROP NOT NULL');
        $this->addSql('ALTER TABLE environment ALTER priority DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE environment ALTER type_ofneed SET NOT NULL');
        $this->addSql('ALTER TABLE environment ALTER levelof_satisfaction SET NOT NULL');
        $this->addSql('ALTER TABLE environment ALTER priority SET NOT NULL');
    }
}
