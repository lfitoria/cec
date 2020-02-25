<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200225224019 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        

        $this->addSql("INSERT INTO `criterion` (`id`, `description`, `code`) VALUES
      (46, 'Investigación sobre instituciones o procesos generalizables sobre un individuo o grupo.', 'investigationType'),
      (47, 'Entrevistas cualitativas con sujetos humanos, entrevistas abiertas, que representan un riesgo mínimo para una población meta no vulnerable. ', 'investigationType'),
      (48, 'Informes descriptivos de caso individual que no implican investigación sistemática.', 'investigationType'),
      (49, 'Reporte de casos', 'investigationType'),
      (50, 'Observacional descriptivo de registros médicos', 'investigationType'),
      (51, 'Tesis de grado', 'investigationType'),
      (52, 'Tesis de posgrado', 'investigationType')
      ");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        
    }
}
