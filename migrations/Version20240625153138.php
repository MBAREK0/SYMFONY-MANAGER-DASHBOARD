<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240625153138 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE award_skill DROP FOREIGN KEY FK_511BA4413D5282CF');
        $this->addSql('ALTER TABLE award_skill DROP FOREIGN KEY FK_511BA4415585C142');
        $this->addSql('DROP TABLE award_skill');
        $this->addSql('ALTER TABLE award ADD title VARCHAR(255) NOT NULL, ADD associated_with VARCHAR(255) NOT NULL, ADD issuer VARCHAR(255) DEFAULT NULL, DROP name, DROP specialty, CHANGE date date DATE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE award_skill (award_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_511BA4413D5282CF (award_id), INDEX IDX_511BA4415585C142 (skill_id), PRIMARY KEY(award_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE award_skill ADD CONSTRAINT FK_511BA4413D5282CF FOREIGN KEY (award_id) REFERENCES award (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE award_skill ADD CONSTRAINT FK_511BA4415585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE award ADD specialty VARCHAR(255) DEFAULT NULL, DROP title, DROP associated_with, CHANGE date date DATE DEFAULT NULL, CHANGE issuer name VARCHAR(255) DEFAULT NULL');
    }
}
