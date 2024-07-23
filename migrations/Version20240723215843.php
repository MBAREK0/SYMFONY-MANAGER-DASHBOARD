<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240723215843 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_NAME_ORG_DATE_USER ON license_and_certification');
        $this->addSql('ALTER TABLE license_and_certification ADD name_fr VARCHAR(255) DEFAULT NULL, ADD description_fr LONGTEXT DEFAULT NULL, CHANGE name name_en VARCHAR(255) DEFAULT NULL, CHANGE description description_en LONGTEXT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_NAME_ORG_DATE_USER ON license_and_certification (organization, date, user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_NAME_ORG_DATE_USER ON license_and_certification');
        $this->addSql('ALTER TABLE license_and_certification ADD name VARCHAR(255) DEFAULT NULL, ADD description LONGTEXT DEFAULT NULL, DROP name_en, DROP name_fr, DROP description_en, DROP description_fr');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_NAME_ORG_DATE_USER ON license_and_certification (name, organization, date, user_id)');
    }
}
