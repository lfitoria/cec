<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200326175457 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ethic_eval_request (id INT AUTO_INCREMENT NOT NULL, request_id INT DEFAULT NULL, amount_participants TEXT DEFAULT NULL, in_ex_criteria TEXT DEFAULT NULL, recruitment_participants TEXT DEFAULT NULL, collection_information TEXT DEFAULT NULL, risk_declaration TEXT DEFAULT NULL, benefits_for_participant TEXT DEFAULT NULL, benefits_for_population TEXT DEFAULT NULL, previsions_privacy TEXT DEFAULT NULL, future_use TEXT DEFAULT NULL, informed_consent TINYINT(1) DEFAULT NULL, informed_assent TINYINT(1) DEFAULT NULL, aditional_files TINYINT(1) DEFAULT NULL, INDEX FK_ethic_req (request_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE population_ethic_eval_request (ethicevalrequest_id INT NOT NULL, criterion_id INT NOT NULL, INDEX IDX_C449A92A35E09FA2 (ethicevalrequest_id), INDEX IDX_C449A92A97766307 (criterion_id), PRIMARY KEY(ethicevalrequest_id, criterion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE data_type_ethic_eval_request (ethicevalrequest_id INT NOT NULL, criterion_id INT NOT NULL, INDEX IDX_BCA4A72035E09FA2 (ethicevalrequest_id), INDEX IDX_BCA4A72097766307 (criterion_id), PRIMARY KEY(ethicevalrequest_id, criterion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE files_ethic_eval (ethicevalrequest_id INT NOT NULL, file_id INT NOT NULL, INDEX IDX_68A55E6835E09FA2 (ethicevalrequest_id), INDEX IDX_68A55E6893CB796C (file_id), PRIMARY KEY(ethicevalrequest_id, file_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pre_eval_request (id INT AUTO_INCREMENT NOT NULL, status INT DEFAULT NULL, request_id INT DEFAULT NULL, user_id INT DEFAULT NULL, observations VARCHAR(500) DEFAULT NULL, date DATETIME NOT NULL, current TINYINT(1) NOT NULL, INDEX IDX_B36ABFAC427EB8A5 (request_id), INDEX FK_pre_eval_status (status), INDEX FK_pre_eval_user (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE criterion (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, code VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, filename VARCHAR(200) NOT NULL, original_name VARCHAR(200) NOT NULL, mime VARCHAR(150) NOT NULL, size VARCHAR(50) NOT NULL, question_code VARCHAR(200) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(45) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE work_log (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, request_id INT DEFAULT NULL, eval_request_id INT DEFAULT NULL, pre_eval_request_id INT DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, date DATETIME DEFAULT NULL, observations VARCHAR(200) DEFAULT NULL, INDEX IDX_F5513F59A76ED395 (user_id), INDEX IDX_F5513F59427EB8A5 (request_id), INDEX IDX_F5513F5948DB1F (eval_request_id), INDEX IDX_F5513F5978195BB6 (pre_eval_request_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE TeamWork (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, student_id INT DEFAULT NULL, student_email VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE extra_information_request (id INT AUTO_INCREMENT NOT NULL, request_id INT DEFAULT NULL, tutor_name VARCHAR(100) DEFAULT NULL, tutor_id VARCHAR(45) DEFAULT NULL, tutor_email VARCHAR(100) DEFAULT NULL, grupal_project TINYINT(1) DEFAULT NULL, INDEX FK_extra_information_request (request_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_request (id INT AUTO_INCREMENT NOT NULL, state_id INT DEFAULT NULL, user_id INT DEFAULT NULL, category INT DEFAULT NULL, title VARCHAR(400) NOT NULL, code VARCHAR(10) DEFAULT NULL, ext_institutions VARCHAR(200) DEFAULT NULL, ext_institutions_authorization TINYINT(1) DEFAULT NULL, place_of_study VARCHAR(200) DEFAULT NULL, involves_humans TINYINT(1) DEFAULT NULL, doc_human_information TINYINT(1) DEFAULT NULL, minute_commission_tfg TINYINT(1) DEFAULT NULL, minute_final_work TINYINT(1) DEFAULT NULL, minute_research_center TINYINT(1) DEFAULT NULL, project_unit VARCHAR(45) DEFAULT NULL, sip_project VARCHAR(45) DEFAULT NULL, grupalProject TINYINT(1) DEFAULT NULL, tutor_name VARCHAR(100) DEFAULT NULL, tutor_id VARCHAR(45) DEFAULT NULL, tutor_email VARCHAR(100) DEFAULT NULL, ascriptionUnit VARCHAR(400) DEFAULT NULL, ucrInstitutions VARCHAR(400) DEFAULT NULL, date DATETIME DEFAULT NULL, uacademica VARCHAR(300) DEFAULT NULL, INDEX IDX_AD8983FA5D83CC1 (state_id), INDEX IDX_AD8983FAA76ED395 (user_id), INDEX IDX_AD8983FA64C19C1 (category), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE files_info_request (projectrequest_id INT NOT NULL, file_id INT NOT NULL, INDEX IDX_956D9D81EDE5C6F (projectrequest_id), INDEX IDX_956D9D893CB796C (file_id), PRIMARY KEY(projectrequest_id, file_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team_works_project (projectrequest_id INT NOT NULL, teamwork_id INT NOT NULL, INDEX IDX_9FE9EFE91EDE5C6F (projectrequest_id), INDEX IDX_9FE9EFE9341CF381 (teamwork_id), PRIMARY KEY(projectrequest_id, teamwork_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assignments_request (projectrequest_id INT NOT NULL, ldapuser_id INT NOT NULL, INDEX IDX_EF186BA01EDE5C6F (projectrequest_id), INDEX IDX_EF186BA0340F1985 (ldapuser_id), PRIMARY KEY(projectrequest_id, ldapuser_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ldap_user (id INT AUTO_INCREMENT NOT NULL, role_id INT NOT NULL, email VARCHAR(200) NOT NULL, username VARCHAR(200) NOT NULL, name VARCHAR(45) DEFAULT NULL, password VARCHAR(300) DEFAULT NULL, external TINYINT(1) DEFAULT NULL, last_login_date DATETIME DEFAULT NULL, creation_date DATETIME DEFAULT NULL, deletion_date DATETIME DEFAULT NULL, carnet VARCHAR(200) DEFAULT NULL, cedula_usuario VARCHAR(200) DEFAULT NULL, INDEX IDX_3888D380D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE files_request (id INT AUTO_INCREMENT NOT NULL, file_id INT DEFAULT NULL, request_id INT DEFAULT NULL, question_code VARCHAR(50) DEFAULT NULL, INDEX FK_file_request_file (file_id), INDEX FK_file_request_request (request_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eval_request (id INT AUTO_INCREMENT NOT NULL, category INT DEFAULT NULL, status INT DEFAULT NULL, user_id INT DEFAULT NULL, request_id INT DEFAULT NULL, observations VARCHAR(1000) DEFAULT NULL, date DATETIME NOT NULL, current TINYINT(1) NOT NULL, INDEX IDX_733CE9B264C19C1 (category), INDEX IDX_733CE9B2427EB8A5 (request_id), INDEX FK_eval_status (status), INDEX FK_eval_user (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE files_eval (evalrequest_id INT NOT NULL, file_id INT NOT NULL, INDEX IDX_C2EABE3B8B19CF91 (evalrequest_id), INDEX IDX_C2EABE3B93CB796C (file_id), PRIMARY KEY(evalrequest_id, file_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_roles (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) DEFAULT NULL, label VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status_request (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) DEFAULT NULL, type INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE log (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, description VARCHAR(200) DEFAULT NULL, date DATETIME DEFAULT NULL, INDEX FK_log_user (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE academic_request_info (id INT AUTO_INCREMENT NOT NULL, request_id INT DEFAULT NULL, summary_observ VARCHAR(1500) DEFAULT NULL, objetives VARCHAR(1500) DEFAULT NULL, questions VARCHAR(1500) DEFAULT NULL, hypothesis VARCHAR(1500) DEFAULT NULL, metodology_observ VARCHAR(1500) DEFAULT NULL, INDEX FK_acad_req (request_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inv_type_ethic_eval_request (academicrequestinfo_id INT NOT NULL, criterion_id INT NOT NULL, INDEX IDX_C54DA209C629BF44 (academicrequestinfo_id), INDEX IDX_C54DA20997766307 (criterion_id), PRIMARY KEY(academicrequestinfo_id, criterion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ethic_eval_request ADD CONSTRAINT FK_DB27A869427EB8A5 FOREIGN KEY (request_id) REFERENCES project_request (id)');
        $this->addSql('ALTER TABLE population_ethic_eval_request ADD CONSTRAINT FK_C449A92A35E09FA2 FOREIGN KEY (ethicevalrequest_id) REFERENCES ethic_eval_request (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE population_ethic_eval_request ADD CONSTRAINT FK_C449A92A97766307 FOREIGN KEY (criterion_id) REFERENCES criterion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE data_type_ethic_eval_request ADD CONSTRAINT FK_BCA4A72035E09FA2 FOREIGN KEY (ethicevalrequest_id) REFERENCES ethic_eval_request (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE data_type_ethic_eval_request ADD CONSTRAINT FK_BCA4A72097766307 FOREIGN KEY (criterion_id) REFERENCES criterion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE files_ethic_eval ADD CONSTRAINT FK_68A55E6835E09FA2 FOREIGN KEY (ethicevalrequest_id) REFERENCES ethic_eval_request (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE files_ethic_eval ADD CONSTRAINT FK_68A55E6893CB796C FOREIGN KEY (file_id) REFERENCES file (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pre_eval_request ADD CONSTRAINT FK_B36ABFAC7B00651C FOREIGN KEY (status) REFERENCES criterion (id)');
        $this->addSql('ALTER TABLE pre_eval_request ADD CONSTRAINT FK_B36ABFAC427EB8A5 FOREIGN KEY (request_id) REFERENCES project_request (id)');
        $this->addSql('ALTER TABLE pre_eval_request ADD CONSTRAINT FK_B36ABFACA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE work_log ADD CONSTRAINT FK_F5513F59A76ED395 FOREIGN KEY (user_id) REFERENCES ldap_user (id)');
        $this->addSql('ALTER TABLE work_log ADD CONSTRAINT FK_F5513F59427EB8A5 FOREIGN KEY (request_id) REFERENCES project_request (id)');
        $this->addSql('ALTER TABLE work_log ADD CONSTRAINT FK_F5513F5948DB1F FOREIGN KEY (eval_request_id) REFERENCES eval_request (id)');
        $this->addSql('ALTER TABLE work_log ADD CONSTRAINT FK_F5513F5978195BB6 FOREIGN KEY (pre_eval_request_id) REFERENCES pre_eval_request (id)');
        $this->addSql('ALTER TABLE extra_information_request ADD CONSTRAINT FK_A31D3065427EB8A5 FOREIGN KEY (request_id) REFERENCES project_request (id)');
        $this->addSql('ALTER TABLE project_request ADD CONSTRAINT FK_AD8983FA5D83CC1 FOREIGN KEY (state_id) REFERENCES criterion (id)');
        $this->addSql('ALTER TABLE project_request ADD CONSTRAINT FK_AD8983FAA76ED395 FOREIGN KEY (user_id) REFERENCES ldap_user (id)');
        $this->addSql('ALTER TABLE project_request ADD CONSTRAINT FK_AD8983FA64C19C1 FOREIGN KEY (category) REFERENCES criterion (id)');
        $this->addSql('ALTER TABLE files_info_request ADD CONSTRAINT FK_956D9D81EDE5C6F FOREIGN KEY (projectrequest_id) REFERENCES project_request (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE files_info_request ADD CONSTRAINT FK_956D9D893CB796C FOREIGN KEY (file_id) REFERENCES file (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE team_works_project ADD CONSTRAINT FK_9FE9EFE91EDE5C6F FOREIGN KEY (projectrequest_id) REFERENCES project_request (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE team_works_project ADD CONSTRAINT FK_9FE9EFE9341CF381 FOREIGN KEY (teamwork_id) REFERENCES TeamWork (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE assignments_request ADD CONSTRAINT FK_EF186BA01EDE5C6F FOREIGN KEY (projectrequest_id) REFERENCES project_request (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE assignments_request ADD CONSTRAINT FK_EF186BA0340F1985 FOREIGN KEY (ldapuser_id) REFERENCES ldap_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ldap_user ADD CONSTRAINT FK_3888D380D60322AC FOREIGN KEY (role_id) REFERENCES users_roles (id)');
        $this->addSql('ALTER TABLE files_request ADD CONSTRAINT FK_9A4A90C893CB796C FOREIGN KEY (file_id) REFERENCES file (id)');
        $this->addSql('ALTER TABLE files_request ADD CONSTRAINT FK_9A4A90C8427EB8A5 FOREIGN KEY (request_id) REFERENCES project_request (id)');
        $this->addSql('ALTER TABLE eval_request ADD CONSTRAINT FK_733CE9B264C19C1 FOREIGN KEY (category) REFERENCES criterion (id)');
        $this->addSql('ALTER TABLE eval_request ADD CONSTRAINT FK_733CE9B27B00651C FOREIGN KEY (status) REFERENCES criterion (id)');
        $this->addSql('ALTER TABLE eval_request ADD CONSTRAINT FK_733CE9B2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE eval_request ADD CONSTRAINT FK_733CE9B2427EB8A5 FOREIGN KEY (request_id) REFERENCES project_request (id)');
        $this->addSql('ALTER TABLE files_eval ADD CONSTRAINT FK_C2EABE3B8B19CF91 FOREIGN KEY (evalrequest_id) REFERENCES eval_request (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE files_eval ADD CONSTRAINT FK_C2EABE3B93CB796C FOREIGN KEY (file_id) REFERENCES file (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE log ADD CONSTRAINT FK_8F3F68C5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE academic_request_info ADD CONSTRAINT FK_FFE6287D427EB8A5 FOREIGN KEY (request_id) REFERENCES project_request (id)');
        $this->addSql('ALTER TABLE inv_type_ethic_eval_request ADD CONSTRAINT FK_C54DA209C629BF44 FOREIGN KEY (academicrequestinfo_id) REFERENCES academic_request_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inv_type_ethic_eval_request ADD CONSTRAINT FK_C54DA20997766307 FOREIGN KEY (criterion_id) REFERENCES criterion (id) ON DELETE CASCADE');

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
    (26, 'Investigación social que no producen información', 'investigationType'),
    (27, 'En edición', 'requestStatus'),
    (28, 'Solicitud completada', 'requestStatus'),
    (29, 'En revisión', 'requestStatus'),
    (30, 'Aprobado', 'requestStatus'),
    (31, 'Revisión preliminar', 'preEvalStatus'),
    (32, 'Devuelto con observaciones ', 'preEvalStatus'),
    (33, 'Exenta', 'preEvalStatus'),
    (34, 'No requiere revisión', 'preEvalStatus'),
    (35, 'Devuelta(no compete)', 'preEvalStatus'),
    (36, 'Solicitud aprobada', 'evalStatus'),
    (37, 'Aprobada condicionada', 'evalStatus'),
    (38, 'Devuelto con observaciones', 'evalStatus'),
    (39, 'Exenta', 'evalStatus'),
    (40, 'Rechazada', 'evalStatus'),
    (41, 'No requiere revisión', 'evalStatus'),
    (42, 'Devuelta(no compete)', 'evalStatus'),
    (43, 'Biomédica observacional', 'categoryEvalStatus'),
    (44, 'Biomédica Intervencional', 'categoryEvalStatus'),
    (45, 'Sociocultural', 'categoryEvalStatus'),
    (46, 'Investigación sobre instituciones o procesos generalizables sobre un individuo o grupo.', 'investigationType'),
    (47, 'Entrevistas cualitativas con sujetos humanos, entrevistas abiertas, que representan un riesgo mínimo para una población meta no vulnerable. ', 'investigationType'),
    (48, 'Informes descriptivos de caso individual que no implican investigación sistemática.', 'investigationType'),
    (49, 'Reporte de casos', 'investigationType'),
    (50, 'Observacional descriptivo de registros médicos', 'investigationType'),
    (51, 'Tesis de grado', 'investigationType'),
    (52, 'Tesis de posgrado', 'investigationType')
    ");

    $this->addSql("INSERT INTO `users_roles` (`id`, `description`,`label`) VALUES
    (1, 'ROLE_ADMIN', 'Administrador'),
    (2, 'ROLE_STUDENT', 'Estudiante'),
    (3, 'ROLE_RESEARCHER', 'Investigador'),
    (4, 'ROLE_EVALUATOR', 'Evaluador')");
    //$2y$13$XUhnf1ih9CjEgJQ/eTjtTuKL1HTB7nbpSbrFjnjf11DfzidiUMD0C
    $this->addSql("INSERT INTO `ldap_user` (`id`, `role_id`, `email`, `username`, `name`, `password`, `external`, `last_login_date`, `creation_date`, `deletion_date`, `carnet`, `cedula_usuario`) VALUES
    (1, 1, 'admin@cec.com', 'adminTester', 'Admin tester', NULL, NULL, '2019-08-15 06:13:45', NULL, NULL, 'A12345', '111111111'),
    (5, 2, 'student@cec.com', 'studentTester', 'Student tester', NULL, NULL, '2019-08-17 06:56:44', NULL, NULL, 'A12345', '111111111'),
    (6, 3, 'researcher@cec.com', 'researcherTester', 'Researcher tester', NULL, NULL, '2019-08-17 06:40:33', NULL, NULL, 'A12345', '111111111'),
	(7, 4, 'evaluator@cec.com', 'evalutorTester', 'Evaluator tester', NULL, NULL, '2019-08-15 06:36:58', NULL, NULL, 'A12345', '111111111'),
	(8, 4, 'lfitoria@eldomo.net', 'lfitoria', 'Luis Fitoria', 'NULL', 1, '2019-08-15 06:36:58', NULL, NULL, '2', '1'),
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

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE population_ethic_eval_request DROP FOREIGN KEY FK_C449A92A35E09FA2');
        $this->addSql('ALTER TABLE data_type_ethic_eval_request DROP FOREIGN KEY FK_BCA4A72035E09FA2');
        $this->addSql('ALTER TABLE files_ethic_eval DROP FOREIGN KEY FK_68A55E6835E09FA2');
        $this->addSql('ALTER TABLE work_log DROP FOREIGN KEY FK_F5513F5978195BB6');
        $this->addSql('ALTER TABLE population_ethic_eval_request DROP FOREIGN KEY FK_C449A92A97766307');
        $this->addSql('ALTER TABLE data_type_ethic_eval_request DROP FOREIGN KEY FK_BCA4A72097766307');
        $this->addSql('ALTER TABLE pre_eval_request DROP FOREIGN KEY FK_B36ABFAC7B00651C');
        $this->addSql('ALTER TABLE project_request DROP FOREIGN KEY FK_AD8983FA5D83CC1');
        $this->addSql('ALTER TABLE project_request DROP FOREIGN KEY FK_AD8983FA64C19C1');
        $this->addSql('ALTER TABLE eval_request DROP FOREIGN KEY FK_733CE9B264C19C1');
        $this->addSql('ALTER TABLE eval_request DROP FOREIGN KEY FK_733CE9B27B00651C');
        $this->addSql('ALTER TABLE inv_type_ethic_eval_request DROP FOREIGN KEY FK_C54DA20997766307');
        $this->addSql('ALTER TABLE files_ethic_eval DROP FOREIGN KEY FK_68A55E6893CB796C');
        $this->addSql('ALTER TABLE files_info_request DROP FOREIGN KEY FK_956D9D893CB796C');
        $this->addSql('ALTER TABLE files_request DROP FOREIGN KEY FK_9A4A90C893CB796C');
        $this->addSql('ALTER TABLE files_eval DROP FOREIGN KEY FK_C2EABE3B93CB796C');
        $this->addSql('ALTER TABLE pre_eval_request DROP FOREIGN KEY FK_B36ABFACA76ED395');
        $this->addSql('ALTER TABLE eval_request DROP FOREIGN KEY FK_733CE9B2A76ED395');
        $this->addSql('ALTER TABLE log DROP FOREIGN KEY FK_8F3F68C5A76ED395');
        $this->addSql('ALTER TABLE team_works_project DROP FOREIGN KEY FK_9FE9EFE9341CF381');
        $this->addSql('ALTER TABLE ethic_eval_request DROP FOREIGN KEY FK_DB27A869427EB8A5');
        $this->addSql('ALTER TABLE pre_eval_request DROP FOREIGN KEY FK_B36ABFAC427EB8A5');
        $this->addSql('ALTER TABLE work_log DROP FOREIGN KEY FK_F5513F59427EB8A5');
        $this->addSql('ALTER TABLE extra_information_request DROP FOREIGN KEY FK_A31D3065427EB8A5');
        $this->addSql('ALTER TABLE files_info_request DROP FOREIGN KEY FK_956D9D81EDE5C6F');
        $this->addSql('ALTER TABLE team_works_project DROP FOREIGN KEY FK_9FE9EFE91EDE5C6F');
        $this->addSql('ALTER TABLE assignments_request DROP FOREIGN KEY FK_EF186BA01EDE5C6F');
        $this->addSql('ALTER TABLE files_request DROP FOREIGN KEY FK_9A4A90C8427EB8A5');
        $this->addSql('ALTER TABLE eval_request DROP FOREIGN KEY FK_733CE9B2427EB8A5');
        $this->addSql('ALTER TABLE academic_request_info DROP FOREIGN KEY FK_FFE6287D427EB8A5');
        $this->addSql('ALTER TABLE work_log DROP FOREIGN KEY FK_F5513F59A76ED395');
        $this->addSql('ALTER TABLE project_request DROP FOREIGN KEY FK_AD8983FAA76ED395');
        $this->addSql('ALTER TABLE assignments_request DROP FOREIGN KEY FK_EF186BA0340F1985');
        $this->addSql('ALTER TABLE work_log DROP FOREIGN KEY FK_F5513F5948DB1F');
        $this->addSql('ALTER TABLE files_eval DROP FOREIGN KEY FK_C2EABE3B8B19CF91');
        $this->addSql('ALTER TABLE ldap_user DROP FOREIGN KEY FK_3888D380D60322AC');
        $this->addSql('ALTER TABLE inv_type_ethic_eval_request DROP FOREIGN KEY FK_C54DA209C629BF44');
        $this->addSql('DROP TABLE ethic_eval_request');
        $this->addSql('DROP TABLE population_ethic_eval_request');
        $this->addSql('DROP TABLE data_type_ethic_eval_request');
        $this->addSql('DROP TABLE files_ethic_eval');
        $this->addSql('DROP TABLE pre_eval_request');
        $this->addSql('DROP TABLE criterion');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE work_log');
        $this->addSql('DROP TABLE TeamWork');
        $this->addSql('DROP TABLE extra_information_request');
        $this->addSql('DROP TABLE project_request');
        $this->addSql('DROP TABLE files_info_request');
        $this->addSql('DROP TABLE team_works_project');
        $this->addSql('DROP TABLE assignments_request');
        $this->addSql('DROP TABLE ldap_user');
        $this->addSql('DROP TABLE files_request');
        $this->addSql('DROP TABLE eval_request');
        $this->addSql('DROP TABLE files_eval');
        $this->addSql('DROP TABLE users_roles');
        $this->addSql('DROP TABLE status_request');
        $this->addSql('DROP TABLE log');
        $this->addSql('DROP TABLE academic_request_info');
        $this->addSql('DROP TABLE inv_type_ethic_eval_request');
    }
}
