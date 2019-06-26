<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190623011252 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE eval_request (id INT AUTO_INCREMENT NOT NULL, status INT DEFAULT NULL, user_id INT NOT NULL, category INT DEFAULT NULL, observations VARCHAR(1000) DEFAULT NULL, date DATETIME NOT NULL, current TINYINT(1) NOT NULL, INDEX FK_eval_status (status), INDEX FK_eval_user (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE files_eval (eval_request_id INT NOT NULL, file_id INT NOT NULL, INDEX IDX_C2EABE3B48DB1F (eval_request_id), INDEX IDX_C2EABE3B93CB796C (file_id), PRIMARY KEY(eval_request_id, file_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE academic_request_info (id INT AUTO_INCREMENT NOT NULL, request_id INT DEFAULT NULL, summary_observ VARCHAR(1500) DEFAULT NULL, objetives VARCHAR(1500) DEFAULT NULL, questions VARCHAR(1500) DEFAULT NULL, hypothesis VARCHAR(1500) DEFAULT NULL, metodology_observ VARCHAR(1500) DEFAULT NULL, INDEX FK_acad_req (request_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ethic_eval_request (id INT AUTO_INCREMENT NOT NULL, request_id INT DEFAULT NULL, amount_participants VARCHAR(1000) DEFAULT NULL, in_ex_criteria VARCHAR(1500) DEFAULT NULL, recruitment_participants VARCHAR(1500) DEFAULT NULL, collection_information VARCHAR(1500) DEFAULT NULL, risk_declaration VARCHAR(1000) DEFAULT NULL, benefits_for_participant VARCHAR(500) DEFAULT NULL, benefits_for_population VARCHAR(500) DEFAULT NULL, previsions_privacy VARCHAR(500) DEFAULT NULL, future_use VARCHAR(500) DEFAULT NULL, informed_consent TINYINT(1) DEFAULT NULL, informed_assent TINYINT(1) DEFAULT NULL, INDEX FK_ethic_req (request_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE extra_information_request (id INT AUTO_INCREMENT NOT NULL, request_id INT DEFAULT NULL, tutor_name VARCHAR(100) DEFAULT NULL, tutor_id VARCHAR(45) DEFAULT NULL, tutor_email VARCHAR(100) DEFAULT NULL, grupal_project TINYINT(1) DEFAULT NULL, INDEX FK_extra_information_request (request_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, filename VARCHAR(200) NOT NULL, mime VARCHAR(50) NOT NULL, size VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE files_request (id INT AUTO_INCREMENT NOT NULL, file_id INT DEFAULT NULL, request_id INT DEFAULT NULL, question_code VARCHAR(50) DEFAULT NULL, INDEX FK_file_request_file (file_id), INDEX FK_file_request_request (request_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ldap_user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(200) NOT NULL, role VARCHAR(45) DEFAULT NULL, last_login_date DATETIME DEFAULT NULL, creation_date DATETIME DEFAULT NULL, deletion_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE log (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, description VARCHAR(200) DEFAULT NULL, date DATETIME DEFAULT NULL, INDEX FK_log_user (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pre_eval_request (id INT AUTO_INCREMENT NOT NULL, status INT DEFAULT NULL, user_id INT DEFAULT NULL, observations VARCHAR(500) DEFAULT NULL, date DATETIME NOT NULL, current TINYINT(1) NOT NULL, INDEX FK_pre_eval_status (status), INDEX FK_pre_eval_user (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_request (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(400) NOT NULL, code VARCHAR(10) DEFAULT NULL, state INT DEFAULT NULL, ext_institutions VARCHAR(200) DEFAULT NULL, ext_institutions_authorization TINYINT(1) DEFAULT NULL, place_of_study VARCHAR(200) DEFAULT NULL, involves_humans TINYINT(1) DEFAULT NULL, doc_human_information TINYINT(1) DEFAULT NULL, project_unit VARCHAR(45) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assignments_request (project_request_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_EF186BA05AD8C397 (project_request_id), INDEX IDX_EF186BA0A76ED395 (user_id), PRIMARY KEY(project_request_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status_request (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) DEFAULT NULL, type INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) DEFAULT NULL, email VARCHAR(45) DEFAULT NULL, password VARCHAR(45) DEFAULT NULL, external TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE eval_request ADD CONSTRAINT FK_733CE9B27B00651C FOREIGN KEY (status) REFERENCES status_request (id)');
        $this->addSql('ALTER TABLE eval_request ADD CONSTRAINT FK_733CE9B2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE files_eval ADD CONSTRAINT FK_C2EABE3B48DB1F FOREIGN KEY (eval_request_id) REFERENCES eval_request (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE files_eval ADD CONSTRAINT FK_C2EABE3B93CB796C FOREIGN KEY (file_id) REFERENCES file (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE academic_request_info ADD CONSTRAINT FK_FFE6287D427EB8A5 FOREIGN KEY (request_id) REFERENCES project_request (id)');
        $this->addSql('ALTER TABLE ethic_eval_request ADD CONSTRAINT FK_DB27A869427EB8A5 FOREIGN KEY (request_id) REFERENCES project_request (id)');
        $this->addSql('ALTER TABLE extra_information_request ADD CONSTRAINT FK_A31D3065427EB8A5 FOREIGN KEY (request_id) REFERENCES project_request (id)');
        $this->addSql('ALTER TABLE files_request ADD CONSTRAINT FK_9A4A90C893CB796C FOREIGN KEY (file_id) REFERENCES file (id)');
        $this->addSql('ALTER TABLE files_request ADD CONSTRAINT FK_9A4A90C8427EB8A5 FOREIGN KEY (request_id) REFERENCES project_request (id)');
        $this->addSql('ALTER TABLE log ADD CONSTRAINT FK_8F3F68C5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE pre_eval_request ADD CONSTRAINT FK_B36ABFAC7B00651C FOREIGN KEY (status) REFERENCES status_request (id)');
        $this->addSql('ALTER TABLE pre_eval_request ADD CONSTRAINT FK_B36ABFACA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE assignments_request ADD CONSTRAINT FK_EF186BA05AD8C397 FOREIGN KEY (project_request_id) REFERENCES project_request (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE assignments_request ADD CONSTRAINT FK_EF186BA0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE files_eval DROP FOREIGN KEY FK_C2EABE3B48DB1F');
        $this->addSql('ALTER TABLE files_eval DROP FOREIGN KEY FK_C2EABE3B93CB796C');
        $this->addSql('ALTER TABLE files_request DROP FOREIGN KEY FK_9A4A90C893CB796C');
        $this->addSql('ALTER TABLE academic_request_info DROP FOREIGN KEY FK_FFE6287D427EB8A5');
        $this->addSql('ALTER TABLE ethic_eval_request DROP FOREIGN KEY FK_DB27A869427EB8A5');
        $this->addSql('ALTER TABLE extra_information_request DROP FOREIGN KEY FK_A31D3065427EB8A5');
        $this->addSql('ALTER TABLE files_request DROP FOREIGN KEY FK_9A4A90C8427EB8A5');
        $this->addSql('ALTER TABLE assignments_request DROP FOREIGN KEY FK_EF186BA05AD8C397');
        $this->addSql('ALTER TABLE eval_request DROP FOREIGN KEY FK_733CE9B27B00651C');
        $this->addSql('ALTER TABLE pre_eval_request DROP FOREIGN KEY FK_B36ABFAC7B00651C');
        $this->addSql('ALTER TABLE eval_request DROP FOREIGN KEY FK_733CE9B2A76ED395');
        $this->addSql('ALTER TABLE log DROP FOREIGN KEY FK_8F3F68C5A76ED395');
        $this->addSql('ALTER TABLE pre_eval_request DROP FOREIGN KEY FK_B36ABFACA76ED395');
        $this->addSql('ALTER TABLE assignments_request DROP FOREIGN KEY FK_EF186BA0A76ED395');
        $this->addSql('DROP TABLE eval_request');
        $this->addSql('DROP TABLE files_eval');
        $this->addSql('DROP TABLE academic_request_info');
        $this->addSql('DROP TABLE ethic_eval_request');
        $this->addSql('DROP TABLE extra_information_request');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE files_request');
        $this->addSql('DROP TABLE ldap_user');
        $this->addSql('DROP TABLE log');
        $this->addSql('DROP TABLE pre_eval_request');
        $this->addSql('DROP TABLE project_request');
        $this->addSql('DROP TABLE assignments_request');
        $this->addSql('DROP TABLE status_request');
        $this->addSql('DROP TABLE user');
    }
}
