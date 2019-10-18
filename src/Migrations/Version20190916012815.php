<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190916012815 extends AbstractMigration {

  public function getDescription(): string {
    return '';
  }

  public function up(Schema $schema): void {
    // this up() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql("INSERT INTO `criterion` (`id`, `description`, `code`) VALUES
      (31, 'Revisión aprobada', 'preEvalStatus'),
      (32, 'Pendiente de revisión', 'preEvalStatus'),
      (33, 'Exenta', 'preEvalStatus'),
      (34, 'No requiere revisión', 'preEvalStatus'),
      (35, 'Devuelta', 'preEvalStatus'),
      (36, 'Aprobada', 'evalStatus'),
      (37, 'Aprobada condicionada', 'evalStatus'),
      (38, 'Pendiente de revisión', 'preEvalStatus'),
      (39, 'Exenta', 'evalStatus'),
      (40, 'Rechazada', 'evalStatus'),
      (41, 'No requiere revisión', 'evalStatus'),
      (42, 'Devuelta', 'evalStatus'),
      (43, 'Biomédica observacional', 'categoryEvalStatus'),
      (44, 'Biomédica Intervencional', 'categoryEvalStatus'),
      (45, 'Sociocultural', 'categoryEvalStatus')
      
      ");
  }

  public function down(Schema $schema): void {
    // this down() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
  }

}
