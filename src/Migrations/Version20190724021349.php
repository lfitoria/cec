<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190724021349 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE population_ethic_eval_request (ethicevalrequest_id INT NOT NULL, criterion_id INT NOT NULL, INDEX IDX_C449A92A35E09FA2 (ethicevalrequest_id), INDEX IDX_C449A92A97766307 (criterion_id), PRIMARY KEY(ethicevalrequest_id, criterion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE population_ethic_eval_request ADD CONSTRAINT FK_C449A92A35E09FA2 FOREIGN KEY (ethicevalrequest_id) REFERENCES ethic_eval_request (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE population_ethic_eval_request ADD CONSTRAINT FK_C449A92A97766307 FOREIGN KEY (criterion_id) REFERENCES criterion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inst_auth_files_project DROP FOREIGN KEY FK_46E980D51EDE5C6F');
        $this->addSql('DROP INDEX IDX_46E980D51EDE5C6F ON inst_auth_files_project');
        $this->addSql('ALTER TABLE inst_auth_files_project DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE inst_auth_files_project CHANGE project_request_id projectrequest_id INT NOT NULL');
        $this->addSql('ALTER TABLE inst_auth_files_project ADD CONSTRAINT FK_46E980D51EDE5C6F FOREIGN KEY (projectrequest_id) REFERENCES project_request (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_46E980D51EDE5C6F ON inst_auth_files_project (projectrequest_id)');
        $this->addSql('ALTER TABLE inst_auth_files_project ADD PRIMARY KEY (projectrequest_id, file_id)');
        $this->addSql('ALTER TABLE human_info_files_project DROP FOREIGN KEY FK_F29FB07F1EDE5C6F');
        $this->addSql('DROP INDEX IDX_F29FB07F1EDE5C6F ON human_info_files_project');
        $this->addSql('ALTER TABLE human_info_files_project DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE human_info_files_project CHANGE project_request_id projectrequest_id INT NOT NULL');
        $this->addSql('ALTER TABLE human_info_files_project ADD CONSTRAINT FK_F29FB07F1EDE5C6F FOREIGN KEY (projectrequest_id) REFERENCES project_request (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_F29FB07F1EDE5C6F ON human_info_files_project (projectrequest_id)');
        $this->addSql('ALTER TABLE human_info_files_project ADD PRIMARY KEY (projectrequest_id, file_id)');
        $this->addSql('ALTER TABLE assignments_request DROP FOREIGN KEY FK_EF186BA01EDE5C6F');
        $this->addSql('DROP INDEX IDX_EF186BA01EDE5C6F ON assignments_request');
        $this->addSql('ALTER TABLE assignments_request DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE assignments_request CHANGE project_request_id projectrequest_id INT NOT NULL');
        $this->addSql('ALTER TABLE assignments_request ADD CONSTRAINT FK_EF186BA01EDE5C6F FOREIGN KEY (projectrequest_id) REFERENCES project_request (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_EF186BA01EDE5C6F ON assignments_request (projectrequest_id)');
        $this->addSql('ALTER TABLE assignments_request ADD PRIMARY KEY (projectrequest_id, user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE population_ethic_eval_request');
        $this->addSql('ALTER TABLE assignments_request DROP FOREIGN KEY FK_EF186BA01EDE5C6F');
        $this->addSql('DROP INDEX IDX_EF186BA01EDE5C6F ON assignments_request');
        $this->addSql('ALTER TABLE assignments_request DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE assignments_request CHANGE projectrequest_id project_request_id INT NOT NULL');
        $this->addSql('ALTER TABLE assignments_request ADD CONSTRAINT FK_EF186BA01EDE5C6F FOREIGN KEY (project_request_id) REFERENCES project_request (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_EF186BA01EDE5C6F ON assignments_request (project_request_id)');
        $this->addSql('ALTER TABLE assignments_request ADD PRIMARY KEY (project_request_id, user_id)');
        $this->addSql('ALTER TABLE human_info_files_project DROP FOREIGN KEY FK_F29FB07F1EDE5C6F');
        $this->addSql('DROP INDEX IDX_F29FB07F1EDE5C6F ON human_info_files_project');
        $this->addSql('ALTER TABLE human_info_files_project DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE human_info_files_project CHANGE projectrequest_id project_request_id INT NOT NULL');
        $this->addSql('ALTER TABLE human_info_files_project ADD CONSTRAINT FK_F29FB07F1EDE5C6F FOREIGN KEY (project_request_id) REFERENCES project_request (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_F29FB07F1EDE5C6F ON human_info_files_project (project_request_id)');
        $this->addSql('ALTER TABLE human_info_files_project ADD PRIMARY KEY (project_request_id, file_id)');
        $this->addSql('ALTER TABLE inst_auth_files_project DROP FOREIGN KEY FK_46E980D51EDE5C6F');
        $this->addSql('DROP INDEX IDX_46E980D51EDE5C6F ON inst_auth_files_project');
        $this->addSql('ALTER TABLE inst_auth_files_project DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE inst_auth_files_project CHANGE projectrequest_id project_request_id INT NOT NULL');
        $this->addSql('ALTER TABLE inst_auth_files_project ADD CONSTRAINT FK_46E980D51EDE5C6F FOREIGN KEY (project_request_id) REFERENCES project_request (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_46E980D51EDE5C6F ON inst_auth_files_project (project_request_id)');
        $this->addSql('ALTER TABLE inst_auth_files_project ADD PRIMARY KEY (project_request_id, file_id)');
    }
}
