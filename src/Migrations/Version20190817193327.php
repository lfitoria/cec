<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190817193327 extends AbstractMigration {

  public function getDescription(): string {
    return '';
  }

  public function up(Schema $schema): void {
    // this up() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql("INSERT INTO `criterion` (`id`, `description`, `code`) VALUES
	(1, 'Personas menores de edad o personas sin capacidad volitiva, cognoscitiva, o con deterioro cognitivo moderado o severo.', 'population'),
	(2, 'Personas altamente dependientes de atención en salud.', 'population'),
	(3, 'Pacientes en estado crítico en unidades cuidados intensivos o intermedios', 'population'),
	(4, 'Pacientes en situaciones de emergencia en salud', 'population'),
	(5, 'Participantes de comunidades autóctonas emigrantes y en colectivos particularmente vulnerables', 'population'),
	(6, 'Grupos comunitarios con características particulares', 'population'),
	(7, 'Grupos subordinados', 'population'),
	(8, 'Participantes mujeres embarazadas o en período de lactancia. ', 'population'),
	(9, 'Participantes privados de libertad', 'population'),
	(10, 'Estudiantes de las actividades docentes del investigador.', 'population'),
	(11, 'Adultos mayores', 'population'),
	(12, 'Población no vulnerable', 'population'),
	(13, 'Personales', 'dataType'),
	(14, 'Conﬁdenciales', 'dataType'),
	(15, 'Sensibles ', 'dataType'),
	(16, 'De procesos sociales', 'dataType'),
	(17, 'De expertos', 'dataType'),
	(18, 'Laborales', 'dataType'),
	(19, 'Institucionales', 'dataType'),
	(20, 'Biológicos', 'dataType'),
	(21, 'Otros', 'dataType'),
	(22, 'Actividades de formación en la investigación, cursos, seminarios de graduación, talleres, etc.', 'investigationType'),
	(23, 'Evaluación de programas, servicios o necesidades para el aseguramiento de la calidad o actividades de mejora de calidad.', 'investigationType'),
	(24, 'Investigación en repositorios, bancos de tejidos o ADN, bases de datos o materiales almacenados previamente y debidamente anonimizados.', 'investigationType'),
	(25, 'Investigación con información privada codiﬁcada o muestras biológicas no obtenidas para el presente proyecto y donde los investigadores no pueden determinar la identidad de la persona a la que pertenece la muestra.', 'investigationType'),
	(26, 'Investigación social que no producen información', 'investigationType')");

    $this->addSql("INSERT INTO `users_roles` (`id`, `description`,`label`) VALUES
    (1, 'ROLE_ADMIN', 'Administrador'),
    (2, 'ROLE_STUDENT', 'Estudiante'),
    (3, 'ROLE_RESEARCHER', 'Investigador'),
    (4, 'ROLE_EVALUATOR', 'Evaluador')");
    
    $this->addSql("INSERT INTO `ldap_user` (`id`, `role_id`, `email`, `username`, `name`, `password`, `external`, `last_login_date`, `creation_date`, `deletion_date`, `carnet`, `cedula_usuario`) VALUES
    (1, 1, 'admin@cec.com', 'adminTester', 'Admin tester', NULL, NULL, '2019-08-15 06:13:45', NULL, NULL, 'A12345', '111111111'),
    (5, 2, 'student@cec.com', 'studentTester', 'Student tester', NULL, NULL, '2019-08-17 06:56:44', NULL, NULL, 'A12345', '111111111'),
    (6, 3, 'researcher@cec.com', 'researcherTester', 'Researcher tester', NULL, NULL, '2019-08-17 06:40:33', NULL, NULL, 'A12345', '111111111'),
	(7, 4, 'evaluator@cec.com', 'evalutorTester', 'Evaluator tester', NULL, NULL, '2019-08-15 06:36:58', NULL, NULL, 'A12345', '111111111'),
	(8, 4, 'lfitoria@eldomo.net', 'lfitoria', 'Luis Fitoria', NULL, 1, '2019-08-15 06:36:58', NULL, NULL, '2', '1'),
	(9,4, 'alfonso.chaconmata@ucr.ac.cr', 'alfonso.chaconmata', 'alfonso.chaconmata', NULL, NULL, '2019-08-17 06:40:33', NULL, NULL, NULL, NULL),
	(10,4, 'manuel.triana@ucr.ac.cr', 'manuel.triana', 'manuel.triana', NULL, NULL, '2019-08-17 06:40:33', NULL, NULL, NULL, NULL),
	(11,4, 'jimmy.washburn@ucr.ac.cr', 'jimmy.washburn', 'jimmy.washburn', NULL, NULL, '2019-08-17 06:40:33', NULL, NULL, NULL, NULL),
	(12,4, 'sandra.silva@ucr.ac.cr', 'sandra.silva', 'sandra.silva', NULL, NULL, '2019-08-17 06:40:33', NULL, NULL, NULL, NULL),
	(13,4, 'rodrigo.morarodriguez@ucr.ac.cr', 'rodrigo.morarodriguez', 'rodrigo.morarodriguez', NULL, NULL, '2019-08-17 06:40:33', NULL, NULL, NULL, NULL),
	(14,4, 'maria.quesada@ucr.ac.cr', 'maria.quesada', 'maria.quesada', NULL, NULL, '2019-08-17 06:40:33', NULL, NULL, NULL, NULL),
	(15,4, 'karol.ramirez@ucr.ac.cr', 'karol.ramirez', 'karol.ramirez', NULL, NULL, '2019-08-17 06:40:33', NULL, NULL, NULL, NULL),
	(16,4, 'derby.munoz@ucr.ac.cr', 'derby.munoz', 'derby.munoz', NULL, NULL, '2019-08-17 06:40:33', NULL, NULL, NULL, NULL),
	(17,4, 'ingrid.gomez@ucr.ac.cr', 'ingrid.gomez', 'ingrid.gomez', NULL, NULL, '2019-08-17 06:40:33', NULL, NULL, NULL, NULL),
	(18,4, 'freddy.arias_m@ucr.ac.cr', 'freddy.arias_m', 'freddy.arias_m', NULL, NULL, '2019-08-17 06:40:33', NULL, NULL, NULL, NULL),
	(19,4, 'oporrascr@gmail.com', 'oporrascr', 'oporrascr', NULL, NULL, '2019-08-17 06:40:33', NULL, NULL, NULL, NULL),
	(20,4, 'anafournier@gmail.com', 'anafournier', 'anafournier@gmail.com', NULL, NULL, '2019-08-17 06:40:33', NULL, NULL, NULL, NULL),
	(21,1, 'cec@ucr.ac.cr', 'cec@ucr.ac.cr', 'cec@ucr.ac.cr', NULL, NULL, '2019-08-17 06:40:33', NULL, NULL, NULL, NULL),
	(22,1, 'daihanna.hernandez@ucr.ac.cr', 'daihanna.hernandez', 'daihanna.hernandez', NULL, NULL, '2019-08-17 06:40:33', NULL, NULL, NULL, NULL)
	");
  }

  public function down(Schema $schema): void {
    // this down() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql('ALTER TABLE file DROP filendame');
  }

}
