<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240628103131 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_NAME_PATH_USER ON media (name, path, user_id)');
        $this->addSql('ALTER TABLE media RENAME INDEX uniq_identifier_name_path TO UNIQ_6A2CA10CB548B0F');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_NAME_PATH_USER ON media');
        $this->addSql('ALTER TABLE media RENAME INDEX uniq_6a2ca10cb548b0f TO UNIQ_IDENTIFIER_NAME_PATH');
    }
}
