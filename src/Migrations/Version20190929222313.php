<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190929222313 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pre_eval_request ADD request_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pre_eval_request ADD CONSTRAINT FK_B36ABFAC427EB8A5 FOREIGN KEY (request_id) REFERENCES project_request (id)');
        $this->addSql('CREATE INDEX IDX_B36ABFAC427EB8A5 ON pre_eval_request (request_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pre_eval_request DROP FOREIGN KEY FK_B36ABFAC427EB8A5');
        $this->addSql('DROP INDEX IDX_B36ABFAC427EB8A5 ON pre_eval_request');
        $this->addSql('ALTER TABLE pre_eval_request DROP request_id');
    }
}
