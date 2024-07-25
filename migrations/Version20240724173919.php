<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240724173919 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_NAME_USER ON language');
        $this->addSql('ALTER TABLE language ADD name_en VARCHAR(255) NOT NULL, ADD name_fr VARCHAR(255) NOT NULL, ADD proficiency_en VARCHAR(255) NOT NULL, ADD proficiency_fr VARCHAR(255) NOT NULL, DROP name, DROP proficiency');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_NAME_USER ON language (name_en, user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_NAME_USER ON language');
        $this->addSql('ALTER TABLE language ADD name VARCHAR(255) NOT NULL, ADD proficiency VARCHAR(255) NOT NULL, DROP name_en, DROP name_fr, DROP proficiency_en, DROP proficiency_fr');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_NAME_USER ON language (name, user_id)');
    }
}
