<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240624115745 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE award (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, specialty VARCHAR(255) DEFAULT NULL, date DATE DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE award_skill (award_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_511BA4413D5282CF (award_id), INDEX IDX_511BA4415585C142 (skill_id), PRIMARY KEY(award_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE award_skill ADD CONSTRAINT FK_511BA4413D5282CF FOREIGN KEY (award_id) REFERENCES award (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE award_skill ADD CONSTRAINT FK_511BA4415585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE award_skill DROP FOREIGN KEY FK_511BA4413D5282CF');
        $this->addSql('ALTER TABLE award_skill DROP FOREIGN KEY FK_511BA4415585C142');
        $this->addSql('DROP TABLE award');
        $this->addSql('DROP TABLE award_skill');
    }
}
