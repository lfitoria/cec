<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191017221411 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ldap_user CHANGE password password VARCHAR(300) DEFAULT NULL');
        $this->addSql('ALTER TABLE eval_request ADD request_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE eval_request ADD CONSTRAINT FK_733CE9B2427EB8A5 FOREIGN KEY (request_id) REFERENCES project_request (id)');
        $this->addSql('CREATE INDEX IDX_733CE9B2427EB8A5 ON eval_request (request_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE eval_request DROP FOREIGN KEY FK_733CE9B2427EB8A5');
        $this->addSql('DROP INDEX IDX_733CE9B2427EB8A5 ON eval_request');
        $this->addSql('ALTER TABLE eval_request DROP request_id, CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE ldap_user CHANGE password password VARCHAR(300) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
