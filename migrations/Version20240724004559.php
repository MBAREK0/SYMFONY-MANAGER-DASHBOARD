<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240724004559 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personal_information CHANGE about_en about_en LONGTEXT DEFAULT NULL, CHANGE about_fr about_fr LONGTEXT DEFAULT NULL, CHANGE current_role_en current_role_en LONGTEXT DEFAULT NULL, CHANGE current_role_fr current_role_fr LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personal_information CHANGE about_en about_en VARCHAR(1000) DEFAULT NULL, CHANGE about_fr about_fr VARCHAR(1000) DEFAULT NULL, CHANGE current_role_en current_role_en VARCHAR(255) DEFAULT NULL, CHANGE current_role_fr current_role_fr VARCHAR(255) DEFAULT NULL');
    }
}
