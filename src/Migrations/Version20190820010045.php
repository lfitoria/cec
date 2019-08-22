<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190820010045 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE project_request ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE project_request ADD CONSTRAINT FK_AD8983FAA76ED395 FOREIGN KEY (user_id) REFERENCES ldap_user (id)');
        $this->addSql('CREATE INDEX IDX_AD8983FAA76ED395 ON project_request (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE project_request DROP FOREIGN KEY FK_AD8983FAA76ED395');
        $this->addSql('DROP INDEX IDX_AD8983FAA76ED395 ON project_request');
        $this->addSql('ALTER TABLE project_request DROP user_id');
    }
}
