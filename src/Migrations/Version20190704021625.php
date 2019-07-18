<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190704021625 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Criterion (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, code INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE files_eval DROP FOREIGN KEY FK_C2EABE3B48DB1F');
        $this->addSql('DROP INDEX IDX_C2EABE3B48DB1F ON files_eval');
        $this->addSql('ALTER TABLE files_eval DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE files_eval CHANGE eval_request_id evalrequest_id INT NOT NULL');
        $this->addSql('ALTER TABLE files_eval ADD CONSTRAINT FK_C2EABE3B8B19CF91 FOREIGN KEY (evalrequest_id) REFERENCES eval_request (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_C2EABE3B8B19CF91 ON files_eval (evalrequest_id)');
        $this->addSql('ALTER TABLE files_eval ADD PRIMARY KEY (evalrequest_id, file_id)');
        $this->addSql('ALTER TABLE assignments_request DROP FOREIGN KEY FK_EF186BA05AD8C397');
        $this->addSql('DROP INDEX IDX_EF186BA05AD8C397 ON assignments_request');
        $this->addSql('ALTER TABLE assignments_request DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE assignments_request CHANGE project_request_id project_request_id INT NOT NULL');
        $this->addSql('ALTER TABLE assignments_request ADD CONSTRAINT FK_EF186BA01EDE5C6F FOREIGN KEY (project_request_id) REFERENCES project_request (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_EF186BA01EDE5C6F ON assignments_request (project_request_id)');
        $this->addSql('ALTER TABLE assignments_request ADD PRIMARY KEY (project_request_id, user_id)');
        $this->addSql('ALTER TABLE work_log ADD date DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE Criterion');
        $this->addSql('ALTER TABLE assignments_request DROP FOREIGN KEY FK_EF186BA01EDE5C6F');
        $this->addSql('DROP INDEX IDX_EF186BA01EDE5C6F ON assignments_request');
        $this->addSql('ALTER TABLE assignments_request DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE assignments_request CHANGE project_request_id project_request_id INT NOT NULL');
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
        $this->addSql('ALTER TABLE work_log DROP date');
    }
}
