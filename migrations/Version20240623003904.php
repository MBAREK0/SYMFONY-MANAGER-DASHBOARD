<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240623003904 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_6A2CA10C5E237E06 ON media');
        $this->addSql('DROP INDEX UNIQ_6A2CA10CB548B0F ON media');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_NAME_PATH ON media');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_NAME_PATH ON media (path)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_NAME_PATH ON project (name)');
        $this->addSql('DROP INDEX UNIQ_5E3DE4775E237E06 ON skill');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_NAME_PATH ON media');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6A2CA10C5E237E06 ON media (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6A2CA10CB548B0F ON media (path)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_NAME_PATH ON media (name, path)');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_NAME_PATH ON project');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5E3DE4775E237E06 ON skill (name)');
    }
}
