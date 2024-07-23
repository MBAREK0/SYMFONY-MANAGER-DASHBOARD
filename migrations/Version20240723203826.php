<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240723203826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_NAME_S_DATE_E_DATE_SCHOOL_SPECIALTY_USER ON education');
        $this->addSql('ALTER TABLE education ADD degree_fr VARCHAR(255) DEFAULT NULL, ADD degree_en VARCHAR(255) DEFAULT NULL, ADD specialty_en VARCHAR(500) DEFAULT NULL, ADD description_en LONGTEXT DEFAULT NULL, DROP degree, DROP grade, CHANGE specialty specialty_fr VARCHAR(500) DEFAULT NULL, CHANGE description description_fr LONGTEXT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_NAME_S_DATE_E_DATE_SCHOOL_SPECIALTY_USER ON education (start_date, school, end_date, user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_NAME_S_DATE_E_DATE_SCHOOL_SPECIALTY_USER ON education');
        $this->addSql('ALTER TABLE education ADD degree VARCHAR(255) DEFAULT NULL, ADD specialty VARCHAR(500) DEFAULT NULL, ADD grade VARCHAR(255) DEFAULT NULL, ADD description LONGTEXT DEFAULT NULL, DROP degree_fr, DROP degree_en, DROP specialty_fr, DROP specialty_en, DROP description_fr, DROP description_en');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_NAME_S_DATE_E_DATE_SCHOOL_SPECIALTY_USER ON education (start_date, school, end_date, specialty, user_id)');
    }
}
