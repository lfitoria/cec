<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190704022905 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        // $this->addSql('ALTER TABLE population_ethic_eval_request ADD CONSTRAINT FK_C449A92A35E09FA2 FOREIGN KEY (ethicevalrequest_id) REFERENCES ethic_eval_request (id) ON DELETE CASCADE');
        // $this->addSql('ALTER TABLE population_ethic_eval_request ADD CONSTRAINT FK_C449A92A97766307 FOREIGN KEY (criterion_id) REFERENCES Criterion (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        // $this->addSql('ALTER TABLE population_ethic_eval_request DROP FOREIGN KEY FK_C449A92A35E09FA2');
        // $this->addSql('ALTER TABLE population_ethic_eval_request DROP FOREIGN KEY FK_C449A92A97766307');
    }
}
