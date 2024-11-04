<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240723213652 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_TITLE_ASS_W_DATE_USER ON award');
        $this->addSql('ALTER TABLE award ADD title_en VARCHAR(255) NOT NULL, ADD title_fr VARCHAR(255) NOT NULL, ADD issuing_organization_en VARCHAR(255) NOT NULL, ADD issuing_organization_fr VARCHAR(255) NOT NULL, ADD description_fr LONGTEXT DEFAULT NULL, DROP title, DROP associated_with, DROP issuer, CHANGE description description_en LONGTEXT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_TITLE_ASS_W_DATE_USER ON award (date, user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_TITLE_ASS_W_DATE_USER ON award');
        $this->addSql('ALTER TABLE award ADD title VARCHAR(255) NOT NULL, ADD associated_with VARCHAR(255) NOT NULL, ADD issuer VARCHAR(255) DEFAULT NULL, ADD description LONGTEXT DEFAULT NULL, DROP title_en, DROP title_fr, DROP issuing_organization_en, DROP issuing_organization_fr, DROP description_en, DROP description_fr');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_TITLE_ASS_W_DATE_USER ON award (title, associated_with, date, user_id)');
    }
}
