<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190706040517 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE inv_type_ethic_eval_request (academicrequestinfo_id INT NOT NULL, criterion_id INT NOT NULL, INDEX IDX_C54DA209C629BF44 (academicrequestinfo_id), INDEX IDX_C54DA20997766307 (criterion_id), PRIMARY KEY(academicrequestinfo_id, criterion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inst_auth_files_project (project_request_id INT NOT NULL, file_id INT NOT NULL, INDEX IDX_46E980D51EDE5C6F (project_request_id), INDEX IDX_46E980D593CB796C (file_id), PRIMARY KEY(project_request_id, file_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE human_info_files_project (project_request_id INT NOT NULL, file_id INT NOT NULL, INDEX IDX_F29FB07F1EDE5C6F (project_request_id), INDEX IDX_F29FB07F93CB796C (file_id), PRIMARY KEY(project_request_id, file_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inv_type_ethic_eval_request ADD CONSTRAINT FK_C54DA209C629BF44 FOREIGN KEY (academicrequestinfo_id) REFERENCES academic_request_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inv_type_ethic_eval_request ADD CONSTRAINT FK_C54DA20997766307 FOREIGN KEY (criterion_id) REFERENCES criterion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inst_auth_files_project ADD CONSTRAINT FK_46E980D51EDE5C6F FOREIGN KEY (project_request_id) REFERENCES project_request (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inst_auth_files_project ADD CONSTRAINT FK_46E980D593CB796C FOREIGN KEY (file_id) REFERENCES file (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE human_info_files_project ADD CONSTRAINT FK_F29FB07F1EDE5C6F FOREIGN KEY (project_request_id) REFERENCES project_request (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE human_info_files_project ADD CONSTRAINT FK_F29FB07F93CB796C FOREIGN KEY (file_id) REFERENCES file (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE inv_type_ethic_eval_request');
        $this->addSql('DROP TABLE inst_auth_files_project');
        $this->addSql('DROP TABLE human_info_files_project');
    }
}
