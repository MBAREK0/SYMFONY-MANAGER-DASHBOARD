<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241030132214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, INDEX IDX_D8698A76A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experience (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, organization VARCHAR(255) NOT NULL, role_en VARCHAR(255) NOT NULL, role_fr VARCHAR(255) NOT NULL, responsibilities_en LONGTEXT NOT NULL, responsibilities_fr LONGTEXT NOT NULL, achievements_en LONGTEXT DEFAULT NULL, achievements_fr LONGTEXT DEFAULT NULL, description_en LONGTEXT DEFAULT NULL, description_fr LONGTEXT DEFAULT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, image_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_590C103A76ED395 (user_id), UNIQUE INDEX UNIQ_IDENTIFIER_NAME_S_DATE_E_DATE_ORG_USER (start_date, end_date, organization, user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experience_skill (experience_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_3D6F986146E90E27 (experience_id), INDEX IDX_3D6F98615585C142 (skill_id), PRIMARY KEY(experience_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name_en VARCHAR(255) NOT NULL, name_fr VARCHAR(255) NOT NULL, proficiency_en VARCHAR(255) NOT NULL, proficiency_fr VARCHAR(255) NOT NULL, INDEX IDX_D4DB71B5A76ED395 (user_id), UNIQUE INDEX UNIQ_IDENTIFIER_NAME_USER (name_en, user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_images (id INT AUTO_INCREMENT NOT NULL, project_id INT DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_F7BB5520166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT FK_590C103A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE experience_skill ADD CONSTRAINT FK_3D6F986146E90E27 FOREIGN KEY (experience_id) REFERENCES experience (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE experience_skill ADD CONSTRAINT FK_3D6F98615585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE language ADD CONSTRAINT FK_D4DB71B5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE project_images ADD CONSTRAINT FK_F7BB5520166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE award ADD title_en VARCHAR(255) NOT NULL, ADD title_fr VARCHAR(255) NOT NULL, ADD issuing_organization_en VARCHAR(255) NOT NULL, ADD issuing_organization_fr VARCHAR(255) NOT NULL, ADD description_fr LONGTEXT DEFAULT NULL, DROP title, DROP associated_with, DROP issuer, CHANGE description description_en LONGTEXT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_TITLE_ASS_W_DATE_USER ON award (date, user_id)');
        $this->addSql('ALTER TABLE education ADD degree_fr VARCHAR(255) DEFAULT NULL, ADD degree_en VARCHAR(255) DEFAULT NULL, ADD specialty_en VARCHAR(500) DEFAULT NULL, ADD description_en LONGTEXT DEFAULT NULL, DROP degree, DROP grade, CHANGE specialty specialty_fr VARCHAR(500) DEFAULT NULL, CHANGE description description_fr LONGTEXT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_NAME_S_DATE_E_DATE_SCHOOL_SPECIALTY_USER ON education (start_date, school, end_date, user_id)');
        $this->addSql('ALTER TABLE license_and_certification ADD name_fr VARCHAR(255) DEFAULT NULL, ADD description_fr LONGTEXT DEFAULT NULL, CHANGE name name_en VARCHAR(255) DEFAULT NULL, CHANGE description description_en LONGTEXT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_NAME_ORG_DATE_USER ON license_and_certification (organization, date, user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_NAME_PATH_USER ON media (name, path, user_id)');
        $this->addSql('ALTER TABLE media RENAME INDEX uniq_identifier_name_path TO UNIQ_6A2CA10CB548B0F');
        $this->addSql('ALTER TABLE personal_information ADD about_en LONGTEXT DEFAULT NULL, ADD about_fr LONGTEXT DEFAULT NULL, ADD position_en VARCHAR(255) DEFAULT NULL, ADD position_fr VARCHAR(255) DEFAULT NULL, ADD current_role_en LONGTEXT DEFAULT NULL, ADD current_role_fr LONGTEXT DEFAULT NULL, ADD presentation_en LONGTEXT DEFAULT NULL, ADD presentation_fr LONGTEXT DEFAULT NULL, DROP about, DROP position');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_NAME_PATH ON project');
        $this->addSql('ALTER TABLE project ADD description_fr LONGTEXT DEFAULT NULL, CHANGE description description_en LONGTEXT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_NAME_PATH_USER ON project (name, user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_NAME_USER ON skill (name, user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76A76ED395');
        $this->addSql('ALTER TABLE experience DROP FOREIGN KEY FK_590C103A76ED395');
        $this->addSql('ALTER TABLE experience_skill DROP FOREIGN KEY FK_3D6F986146E90E27');
        $this->addSql('ALTER TABLE experience_skill DROP FOREIGN KEY FK_3D6F98615585C142');
        $this->addSql('ALTER TABLE language DROP FOREIGN KEY FK_D4DB71B5A76ED395');
        $this->addSql('ALTER TABLE project_images DROP FOREIGN KEY FK_F7BB5520166D1F9C');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE experience');
        $this->addSql('DROP TABLE experience_skill');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE project_images');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_NAME_PATH_USER ON project');
        $this->addSql('ALTER TABLE project ADD description LONGTEXT DEFAULT NULL, DROP description_en, DROP description_fr');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_NAME_PATH ON project (name)');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_NAME_PATH_USER ON media');
        $this->addSql('ALTER TABLE media RENAME INDEX uniq_6a2ca10cb548b0f TO UNIQ_IDENTIFIER_NAME_PATH');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_TITLE_ASS_W_DATE_USER ON award');
        $this->addSql('ALTER TABLE award ADD title VARCHAR(255) NOT NULL, ADD associated_with VARCHAR(255) NOT NULL, ADD issuer VARCHAR(255) DEFAULT NULL, ADD description LONGTEXT DEFAULT NULL, DROP title_en, DROP title_fr, DROP issuing_organization_en, DROP issuing_organization_fr, DROP description_en, DROP description_fr');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_NAME_ORG_DATE_USER ON license_and_certification');
        $this->addSql('ALTER TABLE license_and_certification ADD name VARCHAR(255) DEFAULT NULL, ADD description LONGTEXT DEFAULT NULL, DROP name_en, DROP name_fr, DROP description_en, DROP description_fr');
        $this->addSql('ALTER TABLE personal_information ADD about VARCHAR(255) DEFAULT NULL, ADD position VARCHAR(255) DEFAULT NULL, DROP about_en, DROP about_fr, DROP position_en, DROP position_fr, DROP current_role_en, DROP current_role_fr, DROP presentation_en, DROP presentation_fr');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_NAME_S_DATE_E_DATE_SCHOOL_SPECIALTY_USER ON education');
        $this->addSql('ALTER TABLE education ADD degree VARCHAR(255) DEFAULT NULL, ADD specialty VARCHAR(500) DEFAULT NULL, ADD grade VARCHAR(255) DEFAULT NULL, ADD description LONGTEXT DEFAULT NULL, DROP degree_fr, DROP degree_en, DROP specialty_fr, DROP specialty_en, DROP description_fr, DROP description_en');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_NAME_USER ON skill');
    }
}
