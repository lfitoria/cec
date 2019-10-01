<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190929030207 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pre_eval_request DROP FOREIGN KEY FK_B36ABFAC7B00651C');
        $this->addSql('ALTER TABLE pre_eval_request ADD CONSTRAINT FK_B36ABFAC7B00651C FOREIGN KEY (status) REFERENCES criterion (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pre_eval_request DROP FOREIGN KEY FK_B36ABFAC7B00651C');
        $this->addSql('ALTER TABLE pre_eval_request ADD CONSTRAINT FK_B36ABFAC7B00651C FOREIGN KEY (status) REFERENCES status_request (id)');
    }
}
