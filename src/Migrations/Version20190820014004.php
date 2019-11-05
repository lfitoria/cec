<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190820014004 extends AbstractMigration {

  public function getDescription(): string {
    return '';
  }

  public function up(Schema $schema): void {
    // this up() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql('ALTER TABLE project_request CHANGE state state_id INT DEFAULT NULL');
    $this->addSql('ALTER TABLE project_request ADD CONSTRAINT FK_AD8983FA5D83CC1 FOREIGN KEY (state_id) REFERENCES criterion (id)');
    $this->addSql('CREATE INDEX IDX_AD8983FA5D83CC1 ON project_request (state_id)');

    $this->addSql("INSERT INTO `criterion` (`id`, `description`, `code`) VALUES
    (27, 'En edición', 'requestStatus'),
    (28, 'Solicitud completada', 'requestStatus'),
    (29, 'En revisión', 'requestStatus'),
    (30, 'Aprobado', 'requestStatus')");
  }

  public function down(Schema $schema): void {
    // this down() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql('ALTER TABLE project_request DROP FOREIGN KEY FK_AD8983FA5D83CC1');
    $this->addSql('DROP INDEX IDX_AD8983FA5D83CC1 ON project_request');
    $this->addSql('ALTER TABLE project_request CHANGE state_id state INT DEFAULT NULL');
  }

}
