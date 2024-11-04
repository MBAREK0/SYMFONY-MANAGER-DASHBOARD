<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240627114735 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_NAME_ORG_DATE_USER ON license_and_certification (name, organization, date, user_id)');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_NAME_PATH ON project');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_NAME_PATH_USER ON project (name, user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_NAME_ORG_DATE_USER ON license_and_certification');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_NAME_PATH_USER ON project');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_NAME_PATH ON project (name)');
    }
}
