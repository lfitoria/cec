<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190831033617 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE assignments_request DROP FOREIGN KEY FK_EF186BA0A76ED395');
        $this->addSql('DROP INDEX IDX_EF186BA0A76ED395 ON assignments_request');
        $this->addSql('ALTER TABLE assignments_request DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE assignments_request CHANGE user_id ldapuser_id INT NOT NULL');
        $this->addSql('ALTER TABLE assignments_request ADD CONSTRAINT FK_EF186BA0340F1985 FOREIGN KEY (ldapuser_id) REFERENCES ldap_user (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_EF186BA0340F1985 ON assignments_request (ldapuser_id)');
        $this->addSql('ALTER TABLE assignments_request ADD PRIMARY KEY (projectrequest_id, ldapuser_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE assignments_request DROP FOREIGN KEY FK_EF186BA0340F1985');
        $this->addSql('DROP INDEX IDX_EF186BA0340F1985 ON assignments_request');
        $this->addSql('ALTER TABLE assignments_request DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE assignments_request CHANGE ldapuser_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE assignments_request ADD CONSTRAINT FK_EF186BA0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_EF186BA0A76ED395 ON assignments_request (user_id)');
        $this->addSql('ALTER TABLE assignments_request ADD PRIMARY KEY (projectrequest_id, user_id)');
    }
}
