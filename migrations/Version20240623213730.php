<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240623213730 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE education (id INT AUTO_INCREMENT NOT NULL, school VARCHAR(255) NOT NULL, degree VARCHAR(255) DEFAULT NULL, specialty VARCHAR(500) DEFAULT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, grade VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE education_skill (education_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_E2B1FED02CA1BD71 (education_id), INDEX IDX_E2B1FED05585C142 (skill_id), PRIMARY KEY(education_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE education_skill ADD CONSTRAINT FK_E2B1FED02CA1BD71 FOREIGN KEY (education_id) REFERENCES education (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE education_skill ADD CONSTRAINT FK_E2B1FED05585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE education_skill DROP FOREIGN KEY FK_E2B1FED02CA1BD71');
        $this->addSql('ALTER TABLE education_skill DROP FOREIGN KEY FK_E2B1FED05585C142');
        $this->addSql('DROP TABLE education');
        $this->addSql('DROP TABLE education_skill');
    }
}
