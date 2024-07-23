<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240723185930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personal_information ADD about_fr VARCHAR(1000) DEFAULT NULL, ADD position_en VARCHAR(255) DEFAULT NULL, ADD position_fr VARCHAR(255) DEFAULT NULL, ADD current_role_en VARCHAR(255) DEFAULT NULL, ADD current_role_fr VARCHAR(255) DEFAULT NULL, DROP position, DROP current_role, CHANGE about about_en VARCHAR(1000) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personal_information ADD about VARCHAR(1000) DEFAULT NULL, ADD position VARCHAR(255) DEFAULT NULL, ADD current_role VARCHAR(255) DEFAULT NULL, DROP about_en, DROP about_fr, DROP position_en, DROP position_fr, DROP current_role_en, DROP current_role_fr');
    }
}
