<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240723211727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experience ADD role_fr VARCHAR(255) NOT NULL, ADD responsibilities_fr LONGTEXT NOT NULL, ADD achievements_en LONGTEXT DEFAULT NULL, ADD achievements_fr LONGTEXT DEFAULT NULL, ADD description_en LONGTEXT DEFAULT NULL, ADD description_fr LONGTEXT DEFAULT NULL, DROP achievements, DROP description, CHANGE role role_en VARCHAR(255) NOT NULL, CHANGE responsibilities responsibilities_en LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experience ADD role VARCHAR(255) NOT NULL, ADD responsibilities LONGTEXT NOT NULL, ADD achievements LONGTEXT DEFAULT NULL, ADD description LONGTEXT DEFAULT NULL, DROP role_en, DROP role_fr, DROP responsibilities_en, DROP responsibilities_fr, DROP achievements_en, DROP achievements_fr, DROP description_en, DROP description_fr');
    }
}
