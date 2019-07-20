<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190704033153 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE data_type_ethic_eval_request (ethicevalrequest_id INT NOT NULL, criterion_id INT NOT NULL, INDEX IDX_BCA4A72035E09FA2 (ethicevalrequest_id), INDEX IDX_BCA4A72097766307 (criterion_id), PRIMARY KEY(ethicevalrequest_id, criterion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE data_type_ethic_eval_request ADD CONSTRAINT FK_BCA4A72035E09FA2 FOREIGN KEY (ethicevalrequest_id) REFERENCES ethic_eval_request (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE data_type_ethic_eval_request ADD CONSTRAINT FK_BCA4A72097766307 FOREIGN KEY (criterion_id) REFERENCES criterion (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE data_type_ethic_eval_request');
    }
}
