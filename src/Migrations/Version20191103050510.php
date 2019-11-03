<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191103050510 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ldap_user CHANGE password password VARCHAR(45) DEFAULT NULL');
        $this->addSql('ALTER TABLE project_request ADD category INT DEFAULT NULL');
        $this->addSql('ALTER TABLE project_request ADD CONSTRAINT FK_AD8983FA64C19C1 FOREIGN KEY (category) REFERENCES criterion (id)');
        $this->addSql('CREATE INDEX IDX_AD8983FA64C19C1 ON project_request (category)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ldap_user CHANGE password password VARCHAR(300) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE project_request DROP FOREIGN KEY FK_AD8983FA64C19C1');
        $this->addSql('DROP INDEX IDX_AD8983FA64C19C1 ON project_request');
        $this->addSql('ALTER TABLE project_request DROP category');
    }
}
