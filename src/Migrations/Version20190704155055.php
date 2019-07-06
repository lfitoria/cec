<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190704155055 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE criterion (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, code VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE population_ethic_eval_request (ethic_eval_request_id INT NOT NULL, criterion_id INT NOT NULL, INDEX IDX_C449A92AE293B6CE (ethic_eval_request_id), INDEX IDX_C449A92A97766307 (criterion_id), PRIMARY KEY(ethic_eval_request_id, criterion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE data_type_ethic_eval_request (ethic_eval_request_id INT NOT NULL, criterion_id INT NOT NULL, INDEX IDX_BCA4A720E293B6CE (ethic_eval_request_id), INDEX IDX_BCA4A72097766307 (criterion_id), PRIMARY KEY(ethic_eval_request_id, criterion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE col_info_files_ethic_eval (ethic_eval_request_id INT NOT NULL, file_id INT NOT NULL, INDEX IDX_54459AE9E293B6CE (ethic_eval_request_id), INDEX IDX_54459AE993CB796C (file_id), PRIMARY KEY(ethic_eval_request_id, file_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assent_files_ethic_eval (ethic_eval_request_id INT NOT NULL, file_id INT NOT NULL, INDEX IDX_5E45409CE293B6CE (ethic_eval_request_id), INDEX IDX_5E45409C93CB796C (file_id), PRIMARY KEY(ethic_eval_request_id, file_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consent_files_ethic_eval (ethic_eval_request_id INT NOT NULL, file_id INT NOT NULL, INDEX IDX_B97EA9C2E293B6CE (ethic_eval_request_id), INDEX IDX_B97EA9C293CB796C (file_id), PRIMARY KEY(ethic_eval_request_id, file_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE population_ethic_eval_request ADD CONSTRAINT FK_C449A92AE293B6CE FOREIGN KEY (ethic_eval_request_id) REFERENCES ethic_eval_request (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE population_ethic_eval_request ADD CONSTRAINT FK_C449A92A97766307 FOREIGN KEY (criterion_id) REFERENCES criterion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE data_type_ethic_eval_request ADD CONSTRAINT FK_BCA4A720E293B6CE FOREIGN KEY (ethic_eval_request_id) REFERENCES ethic_eval_request (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE data_type_ethic_eval_request ADD CONSTRAINT FK_BCA4A72097766307 FOREIGN KEY (criterion_id) REFERENCES criterion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE col_info_files_ethic_eval ADD CONSTRAINT FK_54459AE9E293B6CE FOREIGN KEY (ethic_eval_request_id) REFERENCES ethic_eval_request (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE col_info_files_ethic_eval ADD CONSTRAINT FK_54459AE993CB796C FOREIGN KEY (file_id) REFERENCES file (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE assent_files_ethic_eval ADD CONSTRAINT FK_5E45409CE293B6CE FOREIGN KEY (ethic_eval_request_id) REFERENCES ethic_eval_request (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE assent_files_ethic_eval ADD CONSTRAINT FK_5E45409C93CB796C FOREIGN KEY (file_id) REFERENCES file (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE consent_files_ethic_eval ADD CONSTRAINT FK_B97EA9C2E293B6CE FOREIGN KEY (ethic_eval_request_id) REFERENCES ethic_eval_request (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE consent_files_ethic_eval ADD CONSTRAINT FK_B97EA9C293CB796C FOREIGN KEY (file_id) REFERENCES file (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE assignments_request DROP FOREIGN KEY FK_EF186BA01EDE5C6F');
        $this->addSql('DROP INDEX IDX_EF186BA01EDE5C6F ON assignments_request');
        $this->addSql('ALTER TABLE assignments_request DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE assignments_request CHANGE projectrequest_id project_request_id INT NOT NULL');
        $this->addSql('ALTER TABLE assignments_request ADD CONSTRAINT FK_EF186BA05AD8C397 FOREIGN KEY (project_request_id) REFERENCES project_request (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_EF186BA05AD8C397 ON assignments_request (project_request_id)');
        $this->addSql('ALTER TABLE assignments_request ADD PRIMARY KEY (project_request_id, user_id)');
        $this->addSql('ALTER TABLE files_eval DROP FOREIGN KEY FK_C2EABE3B8B19CF91');
        $this->addSql('DROP INDEX IDX_C2EABE3B8B19CF91 ON files_eval');
        $this->addSql('ALTER TABLE files_eval DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE files_eval CHANGE evalrequest_id eval_request_id INT NOT NULL');
        $this->addSql('ALTER TABLE files_eval ADD CONSTRAINT FK_C2EABE3B48DB1F FOREIGN KEY (eval_request_id) REFERENCES eval_request (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_C2EABE3B48DB1F ON files_eval (eval_request_id)');
        $this->addSql('ALTER TABLE files_eval ADD PRIMARY KEY (eval_request_id, file_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE population_ethic_eval_request DROP FOREIGN KEY FK_C449A92A97766307');
        $this->addSql('ALTER TABLE data_type_ethic_eval_request DROP FOREIGN KEY FK_BCA4A72097766307');
        $this->addSql('DROP TABLE criterion');
        $this->addSql('DROP TABLE population_ethic_eval_request');
        $this->addSql('DROP TABLE data_type_ethic_eval_request');
        $this->addSql('DROP TABLE col_info_files_ethic_eval');
        $this->addSql('DROP TABLE assent_files_ethic_eval');
        $this->addSql('DROP TABLE consent_files_ethic_eval');
        $this->addSql('ALTER TABLE assignments_request DROP FOREIGN KEY FK_EF186BA05AD8C397');
        $this->addSql('DROP INDEX IDX_EF186BA05AD8C397 ON assignments_request');
        $this->addSql('ALTER TABLE assignments_request DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE assignments_request CHANGE project_request_id projectrequest_id INT NOT NULL');
        $this->addSql('ALTER TABLE assignments_request ADD CONSTRAINT FK_EF186BA01EDE5C6F FOREIGN KEY (projectrequest_id) REFERENCES project_request (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_EF186BA01EDE5C6F ON assignments_request (projectrequest_id)');
        $this->addSql('ALTER TABLE assignments_request ADD PRIMARY KEY (projectrequest_id, user_id)');
        $this->addSql('ALTER TABLE files_eval DROP FOREIGN KEY FK_C2EABE3B48DB1F');
        $this->addSql('DROP INDEX IDX_C2EABE3B48DB1F ON files_eval');
        $this->addSql('ALTER TABLE files_eval DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE files_eval CHANGE eval_request_id evalrequest_id INT NOT NULL');
        $this->addSql('ALTER TABLE files_eval ADD CONSTRAINT FK_C2EABE3B8B19CF91 FOREIGN KEY (evalrequest_id) REFERENCES eval_request (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_C2EABE3B8B19CF91 ON files_eval (evalrequest_id)');
        $this->addSql('ALTER TABLE files_eval ADD PRIMARY KEY (evalrequest_id, file_id)');
    }
}
