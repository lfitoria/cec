<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190626002113 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE work_log (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, request_id INT NOT NULL, eval_request_id INT NOT NULL, pre_eval_request_id INT NOT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_F5513F59A76ED395 (user_id), INDEX IDX_F5513F59427EB8A5 (request_id), INDEX IDX_F5513F5948DB1F (eval_request_id), INDEX IDX_F5513F5978195BB6 (pre_eval_request_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_roles (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE work_log ADD CONSTRAINT FK_F5513F59A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE work_log ADD CONSTRAINT FK_F5513F59427EB8A5 FOREIGN KEY (request_id) REFERENCES project_request (id)');
        $this->addSql('ALTER TABLE work_log ADD CONSTRAINT FK_F5513F5948DB1F FOREIGN KEY (eval_request_id) REFERENCES eval_request (id)');
        $this->addSql('ALTER TABLE work_log ADD CONSTRAINT FK_F5513F5978195BB6 FOREIGN KEY (pre_eval_request_id) REFERENCES pre_eval_request (id)');
        $this->addSql('ALTER TABLE user DROP name, DROP password, DROP external');
        $this->addSql('ALTER TABLE ldap_user ADD role_id INT NOT NULL, ADD password VARCHAR(45) DEFAULT NULL, ADD external TINYINT(1) DEFAULT NULL, CHANGE role name VARCHAR(45) DEFAULT NULL');
        $this->addSql('ALTER TABLE ldap_user ADD CONSTRAINT FK_3888D380D60322AC FOREIGN KEY (role_id) REFERENCES users_roles (id)');
        $this->addSql('CREATE INDEX IDX_3888D380D60322AC ON ldap_user (role_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ldap_user DROP FOREIGN KEY FK_3888D380D60322AC');
        $this->addSql('DROP TABLE work_log');
        $this->addSql('DROP TABLE users_roles');
        $this->addSql('DROP INDEX IDX_3888D380D60322AC ON ldap_user');
        $this->addSql('ALTER TABLE ldap_user ADD role VARCHAR(45) DEFAULT NULL COLLATE utf8mb4_unicode_ci, DROP role_id, DROP name, DROP password, DROP external');
        $this->addSql('ALTER TABLE user ADD name VARCHAR(45) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD password VARCHAR(45) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD external TINYINT(1) DEFAULT NULL');
    }
}
