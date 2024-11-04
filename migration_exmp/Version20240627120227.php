<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240627120227 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_TITLE_ASS_W_DATE_USER ON award (title, associated_with, date, user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_NAME_S_DATE_E_DATE_SCHOOL_SPECIALTY_USER ON education (start_date, school, end_date, specialty, user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_TITLE_ASS_W_DATE_USER ON award');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_NAME_S_DATE_E_DATE_SCHOOL_SPECIALTY_USER ON education');
    }
}
