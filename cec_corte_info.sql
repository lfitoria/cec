-- MySQL dump 10.13  Distrib 5.7.30, for Linux (x86_64)
--
-- Host: localhost    Database: cec
-- ------------------------------------------------------
-- Server version	5.7.30-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `TeamWork`
--

DROP TABLE IF EXISTS `TeamWork`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TeamWork` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `student_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TeamWork`
--

LOCK TABLES `TeamWork` WRITE;
/*!40000 ALTER TABLE `TeamWork` DISABLE KEYS */;
/*!40000 ALTER TABLE `TeamWork` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `academic_request_info`
--

DROP TABLE IF EXISTS `academic_request_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `academic_request_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) DEFAULT NULL,
  `summary_observ` text COLLATE utf8mb4_unicode_ci,
  `objetives` text COLLATE utf8mb4_unicode_ci,
  `questions` text COLLATE utf8mb4_unicode_ci,
  `hypothesis` text COLLATE utf8mb4_unicode_ci,
  `metodology_observ` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `FK_acad_req` (`request_id`),
  CONSTRAINT `FK_FFE6287D427EB8A5` FOREIGN KEY (`request_id`) REFERENCES `project_request` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `academic_request_info`
--

LOCK TABLES `academic_request_info` WRITE;
/*!40000 ALTER TABLE `academic_request_info` DISABLE KEYS */;
INSERT INTO `academic_request_info` VALUES (1,1,NULL,NULL,NULL,NULL,NULL),(2,2,NULL,NULL,NULL,NULL,NULL),(3,3,NULL,NULL,'PRUEBA','La prueba de transformación celular maligna tiene un potencial significativo como prueba de triaje de cáncer de cérvix en Costa Rica y su utilización como herramienta para el descubrimiento de nuevas inferencias en enfermedad cervical.PRUEBA','Se transferirá aproximadamente 300 muestras de citologías líquidas cervicales del proyecto ESTAMPA de la CCSS-IARC, pertenecientes a mujeres entre los 30-65 años, que autorizaron la transferencia de muestras para otras investigaciones en el consentimiento informado en dicho proyecto y que tuvieron un resultado positivo en la prueba de Cobas HPV. Se transferirá también la base de datos parcial anónima, resultados de PAP, resultados de Cobas HPV (ADN) y resultados de histología, fecha de recolección de la muestra y fecha de nacimiento de la paciente. En ningún momento los investigadores de este estudio tendrán acceso al nombre, cédula y otros datos demográficos que permitan la identificación de la paciente. El manejo de los datos se realizará con un ciego simple, para ello un colaborador del proyecto, que no tendrá acceso a las muestras, manejará la base de datos y realizará la selección de las muestras, esto para evitar sesgar los resultados obtenidos para la prueba de transformación celular maligna. Con estas muestras se realizará un análisis de transformación celular maligna utilizando el kit HPV OncoTect 3DX, y se comparará los resultados de esta prueba con los de las pruebas realizadas en el proyecto ESTAMPA. Así mismo se diseñará un algoritmo de reconocimiento automatizado de citologías cervicales que podría convertirse en una prueba muy económica y con una sensibilidad superior a Papanicolaou. Además se realizarán análisis moleculares para la identificación de marcadoresPRUEBA'),(4,4,NULL,NULL,NULL,NULL,NULL),(5,5,NULL,NULL,NULL,NULL,NULL),(6,6,NULL,NULL,'prueba 2','prueba 3',NULL),(7,7,NULL,NULL,'El problema de esta investigación se vincula con la pregunta: ¿Qué dinámicas espaciales se asocian con la influencia del discurso religioso del partido Restauración Nacional en la conducta electoral de la primera ronda presidencial del 2018 en Paquera?','El discurso del partido Restauración Nacional influyó en la votación de la primer ronda electoral.','I. \r\n●	Análisis del Discurso Religioso\r\n\r\nPara cumplir con el primer objetivo específico el cual es estudiar el discurso religioso del partido Restauración Nacional en conjunto de elementos deícticos espaciales para la primera ronda presidencial, se propone hacer un análisis discursivo del partido Restauración Nacional por medio de redes sociales como Facebook e Instagram, se utilizarán solo estas redes sociales ya que, tras un breve análisis y delimitación temporal de la investigadora, resultan las más pertinentes.Las cuentas de redes sociales que se analizarán serán a las del Partido Restauración Nacional, Fabricio Alvarado y Rony Chávez. \r\n\r\nII. \r\n\r\n●	Territorialidad de las Iglesias y Cartografía Espiritual\r\n\r\nLa segunda parte de la metodología responde al objetivo de determinar la influencia e importancia de la ubicación espacial de las iglesias evangélicas Neopentecostales en el imaginario político nacional y su alcance con respecto a la “cartografía espiritual” como estrategia territorial. Para ello se estudiará contrastadamente la territorialidad de las iglesias Neopentecostales con la cartografía espiritual propuesta por la religión cristiana protestante.\r\nIII.  \r\n● Impacto e influencia espacial del Discurso Religioso en el Electorado \r\n \r\nEn la tercer y última parte de la investigación se va a analizar espacialmente el impacto del discurso de líderes religiosos evangélicos en los votantes como agente movilizador del voto en Paquera, como último objetivo específico. Se determinará si el líder religioso influyó en la movilización del voto y en dónde tuvo más influencia. Por lo cual se realizará trabajo de campo con el fin de hacer entrevistas y grupos focales.'),(8,9,NULL,NULL,'escribir la percepción de los profesionales antes mencionados acerca de la violencia de pareja en estudiantes universitarios y los factores asociados a la misma. Tal y como se desprende los informes parciales del proyecto (2018 y 2019). Del análisis de las entrevistas realizadas a las personas participantes se han identificado cuatro temas, los que preliminarmente se han etiquetado como: 1. Procesos facilitadores de la violencia, 2. “Lugares seguros”, 3. Elementos protectores, y 4. “Señales que disparan una alerta”. Los cuales presentan la percepción de los participantes sobre la compleja interacción que ocurre entre el contexto en que se da la violencia de pareja (VP) en estudiantes universitarios, los factores que favorecen que esta se presente, los factores que por el contrario previenen su aparición, y finalmente las señales o manifestaciones que exhiben los y las estudiantes en situaciones de VP. Con base en esos resultados se solicita una ampliación de vigencia en la cual se propone implementar una fase cuantitativa con estudiantes universitarios en la Sede de Occidente de la UCR (objetivo 4, respondiendo al tema de “señales que disparan una alerta”), y una fase cualitativa con líderes estudiantiles del sistema estatal universitario (objetivo 5, como respuesta a los temas: procesos facilitadores de la violencia, “lugares seguros” y elementos protectores). En el primer caso se busca determinar en una muestra de estudiantes su habilidad para reconocer manifestaciones de v','escribir la percepción de los profesionales antes mencionados acerca de la violencia de pareja en estudiantes universitarios y los factores asociados a la misma. Tal y como se desprende los informes parciales del proyecto (2018 y 2019). Del análisis de las entrevistas realizadas a las personas participantes se han identificado cuatro temas, los que preliminarmente se han etiquetado como: 1. Procesos facilitadores de la violencia, 2. “Lugares seguros”, 3. Elementos protectores, y 4. “Señales que disparan una alerta”. Los cuales presentan la percepción de los participantes sobre la compleja interacción que ocurre entre el contexto en que se da la violencia de pareja (VP) en estudiantes universitarios, los factores que favorecen que esta se presente, los factores que por el contrario previenen su aparición, y finalmente las señales o manifestaciones que exhiben los y las estudiantes en situaciones de VP. Con base en esos resultados se solicita una ampliación de vigencia en la cual se propone implementar una fase cuantitativa con estudiantes universitarios en la Sede de Occidente de la UCR (objetivo 4, respondiendo al tema de “señales que disparan una alerta”), y una fase cualitativa con líderes estudiantiles del sistema estatal universitario (objetivo 5, como respuesta a los temas: procesos facilitadores de la violencia, “lugares seguros” y elementos protectores). En el primer caso se busca determinar en una muestra de estudiantes su habilidad para reconocer manifestaciones de v','escribir la percepción de los profesionales antes mencionados acerca de la violencia de pareja en estudiantes universitarios y los factores asociados a la misma. Tal y como se desprende los informes parciales del proyecto (2018 y 2019). Del análisis de las entrevistas realizadas a las personas participantes se han identificado cuatro temas, los que preliminarmente se han etiquetado como: 1. Procesos facilitadores de la violencia, 2. “Lugares seguros”, 3. Elementos protectores, y 4. “Señales que disparan una alerta”. Los cuales presentan la percepción de los participantes sobre la compleja interacción que ocurre entre el contexto en que se da la violencia de pareja (VP) en estudiantes universitarios, los factores que favorecen que esta se presente, los factores que por el contrario previenen su aparición, y finalmente las señales o manifestaciones que exhiben los y las estudiantes en situaciones de VP. Con base en esos resultados se solicita una ampliación de vigencia en la cual se propone implementar una fase cuantitativa con estudiantes universitarios en la Sede de Occidente de la UCR (objetivo 4, respondiendo al tema de “señales que disparan una alerta”), y una fase cualitativa con líderes estudiantiles del sistema estatal universitario (objetivo 5, como respuesta a los temas: procesos facilitadores de la violencia, “lugares seguros” y elementos protectores). En el primer caso se busca determinar en una muestra de estudiantes su habilidad para reconocer manifestaciones de violencia en el noviazgo. Mientras que en la segunda fase se realizará una serie de grupos focales con estudiantes universitarios con el objetivo de analizar su percepción acerca de los elementos y condiciones asociados a la ocurrencia de la VP (i.e, contexto, manifestaciones y factores de riesgo y protección). De tal manera que de los temas que emergieron de la fase previa del estudio (i.e., objetivos 1, 2 & 3) serán usados para informar las preguntas que guiaran la discusión grupal. Los resulta'),(9,8,NULL,NULL,NULL,NULL,'Objetivo específico 4\r\n\r\nDescriptiva cuantitativa. Los participantes deberán vez una encuesta, con preguntas sociodemográficas y con una escala para valorar la habilidad de reconocer señales de alerta de violencia en el noviazgo (Clarificación: no se va a preguntar sobre experiencias personales de violencia, sino la percepción sobre si algunas conductas o actos corresponden a manifestaciones de violencia en el noviazgo). \r\n\r\nPoblación: estudiantes universitarios de la Sede de Occidente de la UCR. \r\n\r\nVariable: \r\nHabilidad para identificar las manifestaciones de la violencia en el noviazgo: medida con con la Escala de Señales de Alerta en una Relación [en ingles Relationship Red Flags Scale] (2).\r\n\r\nTécnica para la recolección de datos: encuesta \r\n\r\nAnálisis estadístico: SPSS 24.0, en donde se realizarán análisis descriptivos, incluyendo medidas de tendencia central, distribución de frecuencias y de dispersión, se elaborarán además tablas y gráficos para identificar tendencias en los datos (3,4,5). Los datos perdidos serán identificados y tratados según las recomendaciones actuales (6). \r\n\r\nObjetivo específico 5\r\nCualitativo descriptivo, en donde se realizará una serie de grupos focales con estudiantes universitarios. De tal manera que de los temas que emergieron de la fase previa del estudio (objetivo 1, 2 y 3) serán usados para informar las preguntas que guiarán la discusión grupal. \r\n\r\nLugares: las cinco universidades estatales, incluyendo sus sedes y recintos \r\n\r\nParticipantes: estudiantes universitarios que forman parte de alguna de las organizaciones representativas del sistema gubernamental estudiantil \r\n \r\nAnálisis:\r\nEl audio de las entrevistas será transcrito utilizando la técnica de transcripción literal. Además las mismas serán anonimizadas una vez que sean transcritas. Las transcripciones serán ingresadas en el programa Qualitative Content Analysis QCAmap, y analizadas mediante procedimientos de análisis contenido'),(10,10,NULL,NULL,NULL,NULL,NULL),(11,11,NULL,NULL,NULL,NULL,NULL),(12,12,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `academic_request_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assignments_request`
--

DROP TABLE IF EXISTS `assignments_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assignments_request` (
  `projectrequest_id` int(11) NOT NULL,
  `ldapuser_id` int(11) NOT NULL,
  PRIMARY KEY (`projectrequest_id`,`ldapuser_id`),
  KEY `IDX_EF186BA01EDE5C6F` (`projectrequest_id`),
  KEY `IDX_EF186BA0340F1985` (`ldapuser_id`),
  CONSTRAINT `FK_EF186BA01EDE5C6F` FOREIGN KEY (`projectrequest_id`) REFERENCES `project_request` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_EF186BA0340F1985` FOREIGN KEY (`ldapuser_id`) REFERENCES `ldap_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assignments_request`
--

LOCK TABLES `assignments_request` WRITE;
/*!40000 ALTER TABLE `assignments_request` DISABLE KEYS */;
INSERT INTO `assignments_request` VALUES (1,32),(2,9),(2,10),(3,9),(3,12),(3,15),(5,8),(7,10),(7,27),(12,32);
/*!40000 ALTER TABLE `assignments_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `criterion`
--

DROP TABLE IF EXISTS `criterion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `criterion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `criterion`
--

LOCK TABLES `criterion` WRITE;
/*!40000 ALTER TABLE `criterion` DISABLE KEYS */;
INSERT INTO `criterion` VALUES (1,'Personas menores de edad o personas sin capacidad volitiva, cognoscitiva, o con deterioro cognitivo moderado o severo.','population'),(2,'Personas altamente dependientes de atención en salud.','population'),(3,'Pacientes en estado crítico en unidades cuidados intensivos o intermedios','population'),(4,'Pacientes en situaciones de emergencia en salud','population'),(5,'Participantes de comunidades autóctonas emigrantes y en colectivos particularmente vulnerables','population'),(6,'Grupos comunitarios con características particulares','population'),(7,'Grupos subordinados','population'),(8,'Participantes mujeres embarazadas o en período de lactancia. ','population'),(9,'Participantes privados de libertad','population'),(10,'Estudiantes de las actividades docentes del investigador.','population'),(11,'Adultos mayores','population'),(12,'Población no vulnerable','population'),(13,'Personales','dataType'),(14,'Conﬁdenciales','dataType'),(15,'Sensibles ','dataType'),(16,'De procesos sociales','dataType'),(17,'De expertos','dataType'),(18,'Laborales','dataType'),(19,'Institucionales','dataType'),(20,'Biológicos','dataType'),(21,'Otros','dataType'),(22,'Actividades de formación en la investigación, cursos, seminarios de graduación, talleres, etc.','investigationType'),(23,'Evaluación de programas, servicios o necesidades para el aseguramiento de la calidad o actividades de mejora de calidad.','investigationType'),(24,'Investigación en repositorios, bancos de tejidos o ADN, bases de datos o materiales almacenados previamente y debidamente anonimizados.','investigationType'),(25,'Investigación con información privada codiﬁcada o muestras biológicas no obtenidas para el presente proyecto y donde los investigadores no pueden determinar la identidad de la persona a la que pertenece la muestra.','investigationType'),(26,'Investigación social que no producen información','investigationType'),(27,'En edición','requestStatus'),(28,'Solicitud completada','requestStatus'),(29,'En revisión','requestStatus'),(30,'Aprobado','requestStatus'),(31,'Revisión preliminar completa','preEvalStatus'),(32,'Devuelto con observaciones ','preEvalStatus'),(33,'Exenta','preEvalStatus'),(34,'No requiere revisión','preEvalStatus'),(35,'Devuelta (no compete)','preEvalStatus'),(36,'Solicitud aprobada','evalStatus'),(37,'Aprobada condicionada','evalStatus'),(38,'Devuelto con observaciones','evalStatus'),(39,'Exenta','evalStatus'),(40,'Rechazada','evalStatus'),(41,'No requiere revisión','evalStatus'),(42,'Devuelta (no compete)','evalStatus'),(43,'Biomédica observacional','categoryEvalStatus'),(44,'Biomédica Intervencional','categoryEvalStatus'),(45,'Sociocultural','categoryEvalStatus'),(46,'Investigación sobre instituciones o procesos generalizables sobre un individuo o grupo.','investigationType'),(47,'Entrevistas cualitativas con sujetos humanos, entrevistas abiertas, que representan un riesgo mínimo para una población meta no vulnerable. ','investigationType'),(48,'Informes descriptivos de caso individual que no implican investigación sistemática.','investigationType'),(49,'Reporte de casos','investigationType'),(50,'Observacional descriptivo de registros médicos','investigationType'),(51,'Tesis de grado','investigationType'),(52,'Tesis de posgrado','investigationType');
/*!40000 ALTER TABLE `criterion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_type_ethic_eval_request`
--

DROP TABLE IF EXISTS `data_type_ethic_eval_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_type_ethic_eval_request` (
  `ethicevalrequest_id` int(11) NOT NULL,
  `criterion_id` int(11) NOT NULL,
  PRIMARY KEY (`ethicevalrequest_id`,`criterion_id`),
  KEY `IDX_BCA4A72035E09FA2` (`ethicevalrequest_id`),
  KEY `IDX_BCA4A72097766307` (`criterion_id`),
  CONSTRAINT `FK_BCA4A72035E09FA2` FOREIGN KEY (`ethicevalrequest_id`) REFERENCES `ethic_eval_request` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_BCA4A72097766307` FOREIGN KEY (`criterion_id`) REFERENCES `criterion` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_type_ethic_eval_request`
--

LOCK TABLES `data_type_ethic_eval_request` WRITE;
/*!40000 ALTER TABLE `data_type_ethic_eval_request` DISABLE KEYS */;
INSERT INTO `data_type_ethic_eval_request` VALUES (3,20),(7,13),(7,16);
/*!40000 ALTER TABLE `data_type_ethic_eval_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ethic_eval_request`
--

DROP TABLE IF EXISTS `ethic_eval_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ethic_eval_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) DEFAULT NULL,
  `amount_participants` text COLLATE utf8mb4_unicode_ci,
  `in_ex_criteria` text COLLATE utf8mb4_unicode_ci,
  `recruitment_participants` text COLLATE utf8mb4_unicode_ci,
  `collection_information` text COLLATE utf8mb4_unicode_ci,
  `risk_declaration` text COLLATE utf8mb4_unicode_ci,
  `benefits_for_participant` text COLLATE utf8mb4_unicode_ci,
  `benefits_for_population` text COLLATE utf8mb4_unicode_ci,
  `previsions_privacy` text COLLATE utf8mb4_unicode_ci,
  `future_use` text COLLATE utf8mb4_unicode_ci,
  `informed_consent` tinyint(1) DEFAULT NULL,
  `informed_assent` tinyint(1) DEFAULT NULL,
  `aditional_files` tinyint(1) DEFAULT NULL,
  `devolution_result_show` text COLLATE utf8mb4_unicode_ci,
  `ex_criteria` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `FK_ethic_req` (`request_id`),
  CONSTRAINT `FK_DB27A869427EB8A5` FOREIGN KEY (`request_id`) REFERENCES `project_request` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ethic_eval_request`
--

LOCK TABLES `ethic_eval_request` WRITE;
/*!40000 ALTER TABLE `ethic_eval_request` DISABLE KEYS */;
INSERT INTO `ethic_eval_request` VALUES (1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,1,NULL,NULL),(2,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,1,NULL,NULL),(3,3,'El proyecto ESTAMPA se encuentra cercano a su conclusión (pendientes 3000 pacientes por analizar) por lo que basados en los resultados obtenidos previamente se estima que se encontran cerca de 300 pacientes infectadas por un virus de papiloma humano de alto grado, o sea con una prueba de Cobas HPV positiva. La logística del proyecto ESTAMPA, solo nos permite seleccionar a las pacientes según el resultado de infección y no según resultados de citología e histología, debido a que al momento de procesar las muestras de nuestro proyecto no se cuenta aún con los resultados de estos análisis. Considerando lo anterior aunado al hecho de que no se conoce el comportamiento de la transformación cervical celular maligna en la población costarricense y su relación con las otras pruebas de tamizaje y triaje utilizadas en el estudio ESTAMPA, el  diseño del estudio y el tamaño de muestra se basaron en los objetivos planteados, el presupuesto disponible para el proyecto. Por otra parte la prueba HPV OncoTect que está limitada a triaje secundario, por lo cual se realizará esta prueba en el 100% de las muestras que tengan un tamizaje primario positivo en la prueba Cobas. Para ello: \r\n- Estampa transferirá aproximadamente 300 (o el 100%) de las citologías de pacientes que presentaron un resultado positivo en la prueba PAP y/o en la prueba de Cobas HPV (ADN). Estas pacientes contarán posteriormente con resultados de histología. A estas muestras se les realizará en la UCR un análisis de transformación celular maligna con la prueba HPV OncoTect y estos resultados se compararán con los resultados de citología, ADN e histología del proyecto Estampa. Adicionalmente se utilizará un citómetro que permite fotografiar cada célula con lo cual se pretende generar un algoritmo que permita reconocer células transformadas y no transformadas basándose en la morfología de dichas células en campo claro y con el marcador DAPI.\r\nEstas muestras se utilizarán también para analizar la variedad de genes relacionados al proceso de carcinogénesis de VHP, comparando genes expresados en lesiones de bajo y alto grado. \r\n\r\nEstas muestras también serán utilizadas para la construcción del algoritmo mencionando anteriormente y para la secuenciación de células individuales.PRUEBA','Muestras de citologías líquidas cervicales de pacientes del estudio ESTAMPA con resultados positivos  en la prueba de HPV Cobas que hayan consentido la transferencia de muestras a otras investigaciones.PRUEBA','No se reclutarán participantes, pues las muestras (citologías líquidas cervicales) e información para el estudio se transfieren por parte del proyecto ESTAMPA de forma codificada. Los investigadores de la UCR no tendrán acceso en ningún momento a datos personales o de identificación de las pacientes. Se adjunta el formulario de Consentimiento Informado del estudio ESTAMPA para evidenciar la opción de la utilización de las muestras e información para otros estudios.PRUEBA','1. Se realizará la prueba de laboratorio HPV OncoTect® E6, E7 mARN, 3DxTM según las especificaciones del fabricante, para el diagnóstico clínico de transformación maligna. Esta prueba cuenta con el sello CE-IVD.  Esta prueba se realizará a pacientes que presentaron un resultado positivo en la prueba COBAS HPV También se utilizará los datos fecha de nacimiento, fecha de recolección de la muestra, resultado de COBAS HPV, resultados de citología y resultado de histología de dichas pacientes, provenientes de la base de datos del proyecto ESTAMPA.\r\n2. Marcadores morfológicos: se generará un clasificador automatizado de células transformadas y no transformadas utilizando machine learning a partir de imágenes en campo claro en combinación de un marcador de ciclo celular (DAPI). Para la generación del clasificador que le muestre al sistema las células transformadas y las no transformadas se marcarán las células con el kit HPV OncoTect. Una vez marcadas las células se analizan en un citómetro de imágenes (Amnis® FlowSight®). Esto permitirá obtener por cada célula de las muestras, una imagen multiespectral en campo claro y en fluorescencia.\r\n3. Análisis por secuenciación de células individuales: Las células transformadas serán separadas utilizado el Cell Sorter BD FACS Jazz. A cada una de estas muestras se les realizará un panel de BD Rhapsody Onco diseñado para VPH. El panel realiza un PCR multiplex para detectar una variedad de genes relacionados al proceso de carcinogénesis de VHP. Los distintos primers incluidos en el kit son utilizados en varias rondas de amplificación para genes específicos en un PCR anidado para la construcción de una librería. Esos productos son posteriormente secuenciados con Illumina®NextSeq.\r\nToda la información generada será asignada en una base de datos al código de la muestra brindado inicialmente por el proyecto ESTAMPA, en ningún momento se contará con datos que identifiquen a la paciente.PRUEBA','La investigación no conlleva ningún riesgo para el participante donador de las muestras del estudio ESTAMPA. Los investigadores de este estudio no tendrán acceso a la identidad de los participantes del estudio ESTAMPA. Los resultados de la prueba OncoTect serán entregados al coordinador del estudio ESTAMPA.PRUEBA','Aunque este proyecto no implica un beneficio directo para las pacientes del estudio ESTAMPA, permitirá estudiar el comportamiento del fenómeno de transformación celular maligna en una población costarricense con posibles sublinajes de VPH circulantes, para determinar la idoneidad del análisis de dicha transformación como esquema de triaje de cáncer de cérvix en el país. Esto permite pasar de un diagnóstico que brinda una calificación de riesgo a un diagnóstico claro para la paciente y para el médico lo cual es especialmente importante para la toma de decisiones clínicas en cierto tipo de lesiones en las que existe dudas de si se debe tratar o no a la paciente.\r\n\r\nPor otra parte se desarrollará un sistema de clasificación automático (a partir de Machine Learning) para el análisis de citologías cervicales. Esto permitiría tener una prueba de triaje muy económica que podría ser utilizada en los protocolos de abordaje actual, con lo cual se mejoraría el diagnóstico y se podría evitar el subdiagnóstico de pacientes (generado por resultados falsos negativos en pruebas como la citología, que tiene una sensibilidad de aproximadamente 50 %).PRUEBA','Este estudio no provee beneficios para las participantes de forma individual. No modifica el abordaje propuesto para las pacientes en el proyecto ESTAMPA pues la recomendación en casos de obtenerse un resultado positivo en el HPV OncoTect es la realización de colposcopía e histología lo cual ya es parte del protocolo de ESTAMPA. Es un estudio biomédico observacional anidado al estudio ESTAMPA que aportará una prueba más a la batería de pruebas de ese estudio multicéntrico.PRUEBA','Del estudio ESTAMPA se transferirá la base de datos parcial anónima (codificada), los resultados del Papanicolaou, resultados de Cobas HPV (ADN) y resultados de histología, fecha de recolección de la muestra y fecha de nacimiento de la paciente, en ningún momento ninguno de los investigadores de este estudio tendrán acceso al nombre, cédula y otros datos demográficos que permitan la identificación de la paciente. \r\nPor otra parte se manejará un ciego interno en el presente estudio, para ello un colaborador del proyecto, que no tendrá acceso a las muestras, manejará la base de datos anónima suministrada por el Proyecto ESTAMPA. Los investigadores que procesan las muestras no tendrán acceso a la información de los resultados de citología e histología  que le realizaron a la paciente en el proyecto ESTAMPA, para no sesgar los resultados. \r\nUna vez digitados los resultados de la prueba de HPV OncoTect, serán transferidos con su respectivo código al proyecto ESTAMPA.PRUEBA','Las muestras son limitadas, lo que se transfiere de ESTAMPA a este proyecto son dos alícuotas de aproximadamente 1,5 mL, por esta razón se utilizarán solamente para los estudios especificados en este protocolo. Se majerán bases de datos anonimizadas con los datos transferidos del proyecto ESTAMPA y los datos generados en este proyecto, a estas bases de datos solo tendrán acceso los investigadores del proyecto. La información generada se utilizará para la redacción de manuscritos en revistas internacionales indexadas y realizar presentaciones científicas.PRUEBA',0,0,1,'Al participante individual:\r\n\r\nYa que no se conoce la identidad de cada participante no se puede hacer una devolución directa de los resultados, como se especificó anteriormente. Los resultados de la prueba de HPV OncoTect de las muestras que eran positivas para HPV Cobas se devuelven al proyecto ESTAMPA con los códigos que ellos asignaron previamente a las muestras. Ya que ellos contarán con la llave para decodificar la identidad de los pacientes, podrán sumar esta información a la batería de pruebas realizadas e integrar toda la información para el manejo adecuado de estas pacientes. El informe de laboratorio contará con un apartado informativo respecto a la interpretación de estos resultados, sin embargo, dichos resultados no modifican el abordaje de las pacientes propuesto en el proyecto ESTAMPA, como se explicó anteriormente, ya que la indicación clínica para pacientes con resultado positivo es la realización de la colposcopía, lo cual ya es parte del protocolo del Proyecto ESTAMPA para estas pacientes.  \r\n\r\nA la población:\r\n\r\nSe organizará una charla-conferencia ante el Foro Permanente de Cáncer en Mujeres de Costa Rica para exponer los resultados de esta investigación. Este Foro constituye la organización nacional más grande integrando múltiples ONGs en el tema. Además, se organizarán otras charlas y reportajes en medios de comunicación masiva y en Congresos de Ginecología.PRUEBA','• Muestra con un conteo menor a 1000 células nucleadas por citometría de flujo a la hora de realizar la prueba de transformación maligna HPV Oncotect.\r\n    • Muestras con más de 5 meses almacenamiento, muestras que hayan sido previamente congeladas o que estén sanguinolentas (rojas, café)PRUEBA\r\n    • Muestras de pacientes que no hayan marcado la opción de poner sus muestras a disposición para otros estudios al firmar el consentimiento informado del estudio ESTAMPA.'),(4,4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,1,NULL,NULL),(5,7,'En esta sección metodológica, para determinar la cantidad de entrevistas se integrará de nuevo el modelo de “saturación de información” del Manual de Glaser y Strauss, The Discovery of Grounded Theory (1967). En el momento en que las entrevistas de material cualitativo dejen de aportar datos nuevos se procederá a finalizar la recolección de datos. En este modelo el número de entrevistados no está definido a priori, sino que este se determina bajo el criterio de “saturación discursiva” cuando las entrevistas dejen de aportar nuevo material para la investigación','Inclusión:\r\n\r\nVotantes para la primera ronda presidencial del 2018.\r\n\r\n\r\nPersonas Mayores de Edad.\r\n\r\n\r\nPersonas que hayan votado por Restauración Nacional.','Lugar: Paquera, Costa Rica.\r\n\r\nFecha: 20 de setiembre al 31 octubre del 2020.\r\n\r\n\r\nQuien:\r\n\r\nSe aplicarán a personas que participen activamente en grupos organizados de las comunidades, como: deportivos, religiosos, políticos, entre otros. Para aplicar el grupo focal se trabajará con dos grupos: el primer grupo corresponde a militantes del partido Restauración Nacional y el segundo a personas que participen activamente en la comunidad denominados “actores claves”. Este segundo grupo de máximo 5 personas, por el manejo del mismo, se dividirá en dos: población joven (18-30 años) y población adulta (35-64 años cumplidos), esta división se hace para conocer desde sus propios intereses, preocupaciones y problemáticas los elementos que les motivaron a ir a votar, en este caso por Fabricio Alvarado.',NULL,'Participar en esta entrevista no significa ningún riesgo, físico, psicológico, ni legal. No obstante, por ser entrevistas a profundidad puede que la persona llegue a sentirse incomodidad al narrar temas de índole político, pero se subsana con la libertad que tiene para decidir no hablar sobre lo que le genere esa incomodidad. \r\nPor otra parte, si se llegará a detener la entrevista, se le señalaría a la participante que puede retomarla cuando se sienta mejor, para evitar algún tipo de presión que impida su comodidad a la hora de narrar sus vivencias.','Espacio de discusión, reflexión e información donde la comunidad comparte, en total libertad y respeto, su visión política del momento.\r\n\r\nComo también lo que la población de Paquera espera de quienes gobiernen el país, en beneficio de la comunidad.','Espacio de discusión e información donde comparte, en total libertad y respeto, su visión política del momento.','Information de anonimato: \r\n\r\n\r\nBuenos días/tardes. Mi nombre es _____________________ y estoy realizando un estudio sobre afinidad política al partido Restauración Nacional en primera ronda, como parte de mi Trabajo Final de Graduación. La intención es conocer su opinión, para comprender este proceso en el distrito de Paquera. Siéntase libre de compartir y expresar sus ideas en este espacio el cual es seguro. No hay respuestas correctas o incorrectas y la información que usted brinde será utilizada sólo para esta investigación bajo el anonimato. \r\n\r\n\r\nAlmacenamiento de datos:\r\n\r\nLos datos serán recolectados y almacenados únicamente por la investigadora.','Los resultados de las entrevistas se publicarán para el momento de defender la tesis. Esto se realizará bajo anonimato por el método de saturación discursiva',1,0,1,'Qué: \r\n\r\nGrupo focal: Responde a un espacio de devolución de resultados\r\n\r\n\r\n\r\nComo:\r\n\r\nLa devolución de resultados se hará por medio de un grupo focal, donde la investigadora compartirá los resultados de las entrevistas.\r\n\r\nQuien participará:\r\n\r\nQuienes hayan participado de la entrevista y quieran participar del grupo focal.\r\n\r\n\r\nCuando:\r\n\r\nAl finalizar la investigación y tener el resultado de la misma.','Exclusión:\r\n\r\nQue no responda a los anteriores.'),(6,9,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,NULL),(7,8,'Objetivo 4\r\nMuestra: se propone realizar el reclutamiento de participantes en la Sede de Occidente de la Universidad (incluyendo el Recinto de Tacarés). Para lo cual se estima que se debe trabajar con una muestra de 160 personas, la cual se estimó utilizando un análisis a priori en el programa G.power 3.1.9.2, donde se consideró un tamaño del efecto de 0.5, un alpha de 0.05 y un poder de 0.95 (1). Se calculó inicialmente un tamaño muestral de 107 sujetos, luego se sobrestimó una cantidad adicional de 32 participantes (i.e., sobreestimación del 30%) para el manejo de la muerte muestral y de datos perdidos, esto según las recomendaciones de la literatura en el tema (2). Adicionalmente, se incluyeron 21 personas (20% del cálculo inicial) para realizar un pilotaje del instrumento (3).\r\n\r\nObjetivo 5\r\nMuestra: se utilizará una muestra de 40 a 50 estudiantes, quienes serán invitados a participar en los grupos focales (cada estudiante solo deberá participar en un grupo focal). Esta decisión se tomó con base en las recomendaciones de Polit & Tanano (2014) y Creswell (2013) para estudios de esta naturaleza utilizando entrevistas en grupo focal. Específicamente, considerando que la población propuesta es heterogénea (estudiantes de diversas universidades y diferentes carreras), se espera que la estabilización en la forma en que emergen los patrones en los datos se logré después del grupo focal 6, lo que se espera confirmar al alcanzar una saturación analítica (Polit & Tanano, 2014; Sandelowski, 2000), por lo que el reclutamiento finalizara una vez que la repetición en los patrones de la información sea constante.','Objetivo 4\r\nSe propone utilizar un muestreo a conveniencia (4), para lo cual se reclutarán a todos las personas que al momento del estudio 1. tengan entre 18 y 26 años de edad, 2. hayan matriculado al menos un curso en la Sede de Occidente de la UCR (incluyendo el Recinto de Tacarés). \r\n\r\nObjetivo 5\r\nEstudiantes universitarios del sistema estatal de educación superior que cumplan los siguientes criterios de inclusión: 1. Mayor de 18 años, 2. Matriculado en una carrera del sistema estatal universitario, 3. Miembro activo de una asociación de estudiantes de carrera, asociación de estudiantes de sede o recinto, consejo estudiantil de área, o federación estudiantil (i.e., grupos formalmente reconocidos dentro del sistema de organización estudiantil).','Objetivo 4\r\nSe propone reclutar a los participantes utilizando las siguientes estrategias 1. afiches informativos, que serán pegados en lugares frecuentados por estudiantes y que se encuentren dentro de los lugares públicos de la Sede de Occidente, 2. posteo en Facebook de la información del estudio, para lo cual se va a utilizar la pagina llamada “Relaciones Saludables en la UCR” (utilizada en el proyecto 421-B4-342, aprobada por el CECUCR en sesión 270-2014), 3. Interacciones cara a cara en los diferentes espacios públicos de la Sede de Occidente (e.g., biblioteca, comedor, pasillos, etc). Todos los materiales para el reclutamiento van a incluir la información del estudio y los medios para contactar directamente y de forma confidencial al equipo investigador  \r\n\r\nObjetivo 5\r\nSe propone utilizar un muestro teórico basado en los resultados de la primera fase del estudio (Grove et al., 2015; Polit & Tanana, 2014), ya que se busca la relevancia de lo conocen los sujetos en lugar de su representatividad (Flick, 2014). Diferentes estrategias serán utilizadas para reclutar a los participantes, incluyendo panfletos, interacciones cara a cara durante actividades institucionales, utilización de los sistemas de divulgación institucional (e.g., correo electrónico) a las asociaciones o grupos estudiantiles con el fin de invitarlos a participar en el estudio. Todos los materiales de reclutamiento incluirán la información del estudio y del equipo investigador. Una vez que el contacto investigador-participante haya sido establecido, se definirá el día y la hora para los grupos focales.','Objetivo 4\r\nTécnica de recolección de datos: se propone utilizar una encuesta autoadministrada (en papel o en digital), conformada por dos apartados 1. un formulario de información sociodemográfica y 2. la escala de Señales de Alerta en una Relación, que se encuentra conformada por 25 ítems, redactados en forma de afirmación con opciones de respuesta en formato Likert de cuatro opciones que van de 1 (para nada es una señal de violencia en el noviazgo) a 4 (claramente es una señal de violencia en el noviazgo). Estudios con población universitaria han reportado niveles de confiabilidad de 0.93 (6).\r\n\r\nObjetivo 5\r\nSe utilizará entrevistas en grupo focal para indagar acerca de las percepciones que tiene el participante acerca la VP en estudiantes universitarios. Se propone realizar al menos un grupo focal por cada sede universitaria. Una guía de preguntas será utilizada para conducir la discusión (Creswell, 2013) [Las preguntas generadoras principales se detallan en la sección del análisis incluido en el apartado de metodología]. Las interacciones durante la entrevista serán grabadas en audio. Notas de campo serán tomadas durante el grupo focal. Además, los participantes serán invitados a completar una forma sociodemográfica con el propósito de caracterizar a los participantes, por ejemplo preguntas acerca de la edad, el sexo, carrera, nivel en el plan de estudios, entre otras.','Objetivo 4 y 5\r\nRelación riesgo/beneficio: \r\nEste estudio es considerado de riesgo mínimo ya que a los participantes no se les solicitará revelar ninguna información acerca de conductas o acciones específicas, sino acerca de conocimientos, actitudes y percepciones. Existe la remota posibilidad de que los participantes puedan experimentar angustia o estrés debido al tema de fondo del estudio. Sin embargo, considerando que existe relativamente poco riesgo para los participantes y el conocimiento que puede ser generado podría ser de utilidad en la práctica clínica, investigación y toma de decisiones, los beneficios superan los riesgos del estudio. En caso de que algún participante lo requiera, se continuará utilizando el protocolo aprobado en la primera fase del estudio para el manejo de estrés emocional, en el cual se ofrecen una hoja con varios servicios disponibles para el manejo de situaciones de pareja o problemas emocionales, además, se dispone de dos profesionales en salud mental (i.e., un enfermero en salud mental y una psicóloga), los cuales están disponibles vía telefónica durante la recolección de datos en caso de que el equipo investigador tenga alguna consulta sobre el manejo de un evento adverso. Además, al igual que en la fase previa del estudio se coordinará con el sistema organizado de respuesta de cada universidad, por ejemplo en el caso de la UCR se utiliza el denominado Protocolo de Atención a Personas de la Comunidad Universitaria con Urgencias Psicológicas (se adjunta imagen ilustrativa).','Beneficios originalmente aprobados:\r\nDevolución de los resultados. \r\nNuevo conocimiento acerca del fenómeno de la violencia de pareja en estudiantes universitarios en Costa Rica.\r\nEste nuevo conocimiento podría ser utilizado en la investigación, docencia, y la atención con el propósito de tratar y prevenir la violencia de pareja.\r\nParticipantes como funcionarios del sistema universitario estatal también se beneficiarán al reflexionar sobre sus opiniones acerca de la violencia de pareja en estudiantes universitarios, lo que podría impactar su práctica profesional.','Beneficios originalmente aprobados:\r\nEste nuevo conocimiento podría contribuir a mejorar la práctica específica de los profesionales del sistema universitario estatal de las oficinas de orientación y salud, al ofrecer una visión de las opiniones y actitudes de este grupo hacía la violencia de pareja en estudiantes universitarios. Lo que podría impactar positivamente los servicios de atención y acompañamiento de los y las estudiantes universitarios con experiencias de violencia de pareja. Devolución de los resultados.','Estándares y procedimientos institucionales para el manejo y seguridad de los datos serán utilizados para asegurar la protección de los participantes y de la información recolectada, estas incluyen (a) los participantes serán invitados a hacer preguntas sobre el estudio en cualquier momento del mismo (e.g., todos los materiales a los que tendrán acceso los participantes incluirán la información de contacto del equipo investigador), (b) los participantes serán informados acerca del manejo y los cuidados de la información, por ejemplo el FCI incluirá información acerca del manejo de la información en formato de audio y digital, (c) la recolección de la información será conducida dentro de la institución en un lugar privado, confortable, y seguro, (d) solo personal autorizado podrá información del estudio, (e) los documentos y cualquier material que contenga información y datos de los participantes serán guardados bajo llave en la escuela de enfermería de la UCR,','Los datos serán almacenados de forma anónima en el servidor de la Escuela de Enfermería, en un folder que posee acceso restringido a personas ajenas al estudio.',1,0,1,'Objetivo 4 y 5\r\nPrimeramente se organizará al menos una actividad de devolución para la población del estudio y otras partes involucradas (e.g., conversatorio o mesa redonda), durante la cual se presentarán los resultados obtenidos. Sin embargo, se buscará replicar esta iniciativa en diferentes localidades en las diversas sedes de las universidades. Igualmente, se propone presentar al menos una ponencia en un evento académico en la cual se muestren los resultados del estudio. Además, se propone la redacción de al menos un artículo científico como un medio complementario para presentar la investigación. Toda diseminación de resultados se realizará exponiendo los hallazgos grupales y no mencionando casos en particular, y siempre respetando la confidencialidad de las personas participantes.','Objetivo 4\r\nSe excluirá a todas aquellas personas que 1. autoreporten tener alguna limitación visual, cognitiva o motora que les impida completar la encuesta, 2. autoreporten estar matriculado en alguna otra sede de la UCR, y 3. autoreporten estar matriculado en otra universidad (pública o privada). \r\n\r\nObjetivo 5\r\nSe excluirán todos aquellos estudiantes que 1. Tengan menos de seis meses de haber ingresado al sistema de organización estudiantil.'),(8,10,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,NULL),(9,11,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,NULL),(10,12,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,NULL);
/*!40000 ALTER TABLE `ethic_eval_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eval_request`
--

DROP TABLE IF EXISTS `eval_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eval_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `request_id` int(11) DEFAULT NULL,
  `observations` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` datetime NOT NULL,
  `current` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_733CE9B264C19C1` (`category`),
  KEY `IDX_733CE9B2427EB8A5` (`request_id`),
  KEY `FK_eval_status` (`status`),
  KEY `FK_eval_user` (`user_id`),
  CONSTRAINT `FK_733CE9B2427EB8A5` FOREIGN KEY (`request_id`) REFERENCES `project_request` (`id`),
  CONSTRAINT `FK_733CE9B264C19C1` FOREIGN KEY (`category`) REFERENCES `criterion` (`id`),
  CONSTRAINT `FK_733CE9B27B00651C` FOREIGN KEY (`status`) REFERENCES `criterion` (`id`),
  CONSTRAINT `FK_733CE9B2A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eval_request`
--

LOCK TABLES `eval_request` WRITE;
/*!40000 ALTER TABLE `eval_request` DISABLE KEYS */;
INSERT INTO `eval_request` VALUES (1,43,38,NULL,3,'Rodrigo, por favor nos envía un correo para saber los detalles de este paso. Esto es una prueba del sistema.\r\n\r\nLo estoy devolviendo con observaciones.','2020-04-30 16:37:02',1),(2,45,38,NULL,5,'devol','2020-05-02 11:06:53',1);
/*!40000 ALTER TABLE `eval_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `extra_information_request`
--

DROP TABLE IF EXISTS `extra_information_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `extra_information_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) DEFAULT NULL,
  `tutor_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tutor_id` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tutor_email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grupal_project` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_extra_information_request` (`request_id`),
  CONSTRAINT `FK_A31D3065427EB8A5` FOREIGN KEY (`request_id`) REFERENCES `project_request` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `extra_information_request`
--

LOCK TABLES `extra_information_request` WRITE;
/*!40000 ALTER TABLE `extra_information_request` DISABLE KEYS */;
/*!40000 ALTER TABLE `extra_information_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `file`
--

DROP TABLE IF EXISTS `file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_code` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filedescription` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file`
--

LOCK TABLES `file` WRITE;
/*!40000 ALTER TABLE `file` DISABLE KEYS */;
INSERT INTO `file` VALUES (1,'d0db0719d05af311b950bf76f25f0e50.pdf','Documento.pdf','application/pdf','5611','minuteCommissionTFGFiles',NULL),(2,'16b8844d5584a773154294ab233c20df.docx','Documento.docx','application/vnd.openxmlformats-officedocument.wordprocessingml.document','22633','mtaFiles',NULL),(3,'f6e1aee8ac51c4dcbea208c2f465c5a9.docx','Documento.docx','application/vnd.openxmlformats-officedocument.wordprocessingml.document','22633','minuteCommissionTFGFiles',NULL),(4,'ac15ac2657bad5785ac1de752fbdaed9.pdf','ActaSesió 227-2019.pdf','application/pdf','373910','minuteCommissionTFGFiles',NULL),(5,'ffdd10a21acb54c1912063d2fc6a73a4.pdf','PDC-133-2019 admisión Melissa Solano.pdf','application/pdf','233127','minuteCommissionTFGFiles',NULL),(6,'b38bd080d31a74bc4ee42a5b32642002.pdf','LQT-88-2020-SolcitudRevisionCEC_HPVproject.pdf','application/pdf','157008','applicationLetterFiles',NULL),(7,'c9322071bf74ca304eaa4981a57efa09.pdf','Acreditaciones.pdf','application/pdf','4944191','categoryBiomedicaFiles',NULL),(8,'91daef6480dc89c6840e5d6c9d8237e1.pdf','UEP-240-19.pdf','application/pdf','507312','aditionalFiles',NULL),(9,'3ed95d507f26ece43b2f4af02e65865d.pdf','MTA-2018-IMP-PRI-0431 fully signed.pdf','application/pdf','5707476','mtaFiles',NULL),(10,'0a9f823709af9ea266efaddcd1b150a3.pdf','AnexoMTA_UCR.pdf','application/pdf','1763018','mtaFiles',NULL),(11,'f1cd785958bbe777a9e443ccf9c3dd0a.docx','Documento.docx','application/vnd.openxmlformats-officedocument.wordprocessingml.document','22633','minuteFinalWorkFiles',NULL),(12,'bec927a431bc4eb21a1fe3f5543a5cf0.pdf','myFirstSnappyPDF.pdf','application/pdf','3324','minuteFinalWorkFiles',NULL),(13,'37ff9f1834364f63e3be60359693afd2.pdf','Documento.pdf','application/pdf','5611','minuteFinalWorkFiles',NULL),(14,'44eb34571b8e9749abf85a164903d7cf.pdf','myFirstSnappyPDF.pdf','application/pdf','3324','minuteFinalWorkFiles',NULL),(15,'c49ddca6f89ae98b618c1557c25e2b9b.pdf','Documento.pdf','application/pdf','5611','minuteFinalWorkFiles','camach'),(16,'20408a1af98ea45e4d4d91f3197595e1.docx','Documento.docx','application/vnd.openxmlformats-officedocument.wordprocessingml.document','22633','aditionalFiles',NULL),(17,'a3224f106f4280e9c59b1a555700e17a.pdf','myFirstSnappyPDF.pdf','application/pdf','3324','aditionalFiles','smy'),(22,'ee04235c7419466b96dcbbd5bb06237b.pdf','myFirstSnappyPDF.pdf','application/pdf','3324','aditionalFiles','ffff'),(23,'7eb003c7cb1300bd9b562670397d1fa9.pdf','myFirstSnappyPDF.pdf','application/pdf','3324','mtaFiles',NULL),(24,'0bf50feb42f0513733600f9b66b576f8.pdf','Documento.pdf','application/pdf','5611','minuteCommissionTFGFiles',NULL),(25,'cba156ac2b4893b45e352a0f03ab1d68.pdf','ActaSesió 227-2019.pdf','application/pdf','373910','minuteCommissionTFGFiles',NULL),(26,'11f15be150ba8bf2a6ab3a702578858c.pdf','Acreditaciones.pdf','application/pdf','4944191','categoryBiomedicaFiles',NULL),(27,'11ac3f23ab68ea11484dd3467af0fba6.pdf','Bitacora de la Escuela.pdf','application/pdf','1168076','minuteFinalWorkFiles',NULL),(28,'c85f7c6814a1be0627121c2dba7b1717.pdf','Bitacora de la Escuela.pdf','application/pdf','1168076','minutesResearchCenterFiles',NULL),(29,'6f972869499224c6a4754e1e72918f9f.docx','Formulario para el consentimiento informado basado en la ley N° 9234-4.docx','application/vnd.openxmlformats-officedocument.wordprocessingml.document','104662','informedConsentFiles',NULL),(30,'832ab911dd802926508cb7f391daf8ea.pdf','ANTEPROYECTO .pdf','application/pdf','889143','collectionInformationFiles',NULL),(31,'148c0909cd0149242bf911bd03f54039.pdf','Firmas de la investigadora.pdf','application/pdf','369374','aditionalFiles',''),(32,'77c991bacb7cb60c86fe6edc3858b76d.pdf','ANTEPROYECTO .pdf','application/pdf','889143','mtaFiles',NULL),(33,'e17dca59b7257846de33470c7d50f040.pdf','Acta del Consejo Científico CICES-5-2020.pdf','application/pdf','233581','minuteCommissionTFGFiles',NULL),(34,'86ed153a962ccd437c05430f18985ffe.pdf','CICES-93-2020.pdf','application/pdf','243180','applicationLetterFiles',NULL),(35,'b25d15b17b0b295b94b0d1defa5a8ac5.png','66504db3-7b5d-485e-b2cf-96b70e8db9f7.png','image/png','365199','minuteCommissionTFGFiles',NULL),(36,'bf1fb0b183ea7bb9625ac07181d3e9c8.docx','FCI Obj 4 Digital.docx','application/vnd.openxmlformats-officedocument.wordprocessingml.document','132709','informedConsentFiles',NULL),(37,'09bcbd8ad58891cd8ab4265e3639acf0.docx','FCI Obj 4 Papel.docx','application/vnd.openxmlformats-officedocument.wordprocessingml.document','132470','informedConsentFiles',NULL),(38,'0ba5768fa6574527d2f50c8e5932ee00.docx','FCI Obj 5 GF.docx','application/vnd.openxmlformats-officedocument.wordprocessingml.document','132541','informedConsentFiles',NULL),(39,'43f0aa4ac7e9eb0a0df068579ae413ea.docx','INSTRUMENTOS A UTILIZAR.docx','application/vnd.openxmlformats-officedocument.wordprocessingml.document','629266','collectionInformationFiles',NULL),(40,'6fe974a69c397cf1b8c3cc8112bad1b3.pdf','Revisión Objetivo 4 y 5 840-B8-328 DMR Percepción v.3.pdf','application/pdf','1727714','aditionalFiles',''),(41,'d5136cd6e8c3ad17a1311395a33a0d33.pdf','Enmienda DMR Objetivo 4 & 5 840-B8-328 Percepciones.pdf','application/pdf','670892','aditionalFiles',''),(42,'e67cb6ad74fad8d2a784b4f4a8cde4df.docx','Documento.docx','application/vnd.openxmlformats-officedocument.wordprocessingml.document','22633','minuteCommissionTFGFiles',NULL),(43,'7d993c8bc28bf18f3aa495e699f31bf0.docx','Documento.docx','application/vnd.openxmlformats-officedocument.wordprocessingml.document','22633','applicationLetterFiles',NULL),(44,'484a598e1e681c74eb96cc1b1afd1324.pdf','Documento.pdf','application/pdf','5611','minuteCommissionTFGFiles',NULL),(45,'c41afcb7fbf9ba2b2055b81da8437048.docx','Documento.docx','application/vnd.openxmlformats-officedocument.wordprocessingml.document','22633','applicationLetterFiles',NULL),(46,'32c5199eb1e221e990dc503afda7b128.pdf','Documento.pdf','application/pdf','5611','minuteCommissionTFGFiles',NULL),(47,'3121425390ccb1202b08357e86a71875.pdf','Documento.pdf','application/pdf','5611','applicationLetterFiles',NULL);
/*!40000 ALTER TABLE `file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `files_ethic_eval`
--

DROP TABLE IF EXISTS `files_ethic_eval`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files_ethic_eval` (
  `ethicevalrequest_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  PRIMARY KEY (`ethicevalrequest_id`,`file_id`),
  KEY `IDX_68A55E6835E09FA2` (`ethicevalrequest_id`),
  KEY `IDX_68A55E6893CB796C` (`file_id`),
  CONSTRAINT `FK_68A55E6835E09FA2` FOREIGN KEY (`ethicevalrequest_id`) REFERENCES `ethic_eval_request` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_68A55E6893CB796C` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files_ethic_eval`
--

LOCK TABLES `files_ethic_eval` WRITE;
/*!40000 ALTER TABLE `files_ethic_eval` DISABLE KEYS */;
INSERT INTO `files_ethic_eval` VALUES (1,2),(1,22),(1,23),(3,8),(3,9),(3,10),(4,16),(4,17),(5,29),(5,30),(5,31),(5,32),(7,36),(7,37),(7,38),(7,39),(7,40),(7,41);
/*!40000 ALTER TABLE `files_ethic_eval` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `files_eval`
--

DROP TABLE IF EXISTS `files_eval`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files_eval` (
  `evalrequest_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  PRIMARY KEY (`evalrequest_id`,`file_id`),
  KEY `IDX_C2EABE3B8B19CF91` (`evalrequest_id`),
  KEY `IDX_C2EABE3B93CB796C` (`file_id`),
  CONSTRAINT `FK_C2EABE3B8B19CF91` FOREIGN KEY (`evalrequest_id`) REFERENCES `eval_request` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_C2EABE3B93CB796C` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files_eval`
--

LOCK TABLES `files_eval` WRITE;
/*!40000 ALTER TABLE `files_eval` DISABLE KEYS */;
/*!40000 ALTER TABLE `files_eval` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `files_info_request`
--

DROP TABLE IF EXISTS `files_info_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files_info_request` (
  `projectrequest_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  PRIMARY KEY (`projectrequest_id`,`file_id`),
  KEY `IDX_956D9D81EDE5C6F` (`projectrequest_id`),
  KEY `IDX_956D9D893CB796C` (`file_id`),
  CONSTRAINT `FK_956D9D81EDE5C6F` FOREIGN KEY (`projectrequest_id`) REFERENCES `project_request` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_956D9D893CB796C` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files_info_request`
--

LOCK TABLES `files_info_request` WRITE;
/*!40000 ALTER TABLE `files_info_request` DISABLE KEYS */;
INSERT INTO `files_info_request` VALUES (1,1),(2,3),(3,4),(3,5),(3,6),(3,7),(4,11),(4,12),(4,13),(4,14),(4,15),(5,24),(6,25),(6,26),(7,27),(7,28),(8,33),(8,34),(9,35),(10,42),(10,43),(11,44),(11,45),(12,46),(12,47);
/*!40000 ALTER TABLE `files_info_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `files_request`
--

DROP TABLE IF EXISTS `files_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) DEFAULT NULL,
  `request_id` int(11) DEFAULT NULL,
  `question_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_file_request_file` (`file_id`),
  KEY `FK_file_request_request` (`request_id`),
  CONSTRAINT `FK_9A4A90C8427EB8A5` FOREIGN KEY (`request_id`) REFERENCES `project_request` (`id`),
  CONSTRAINT `FK_9A4A90C893CB796C` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files_request`
--

LOCK TABLES `files_request` WRITE;
/*!40000 ALTER TABLE `files_request` DISABLE KEYS */;
/*!40000 ALTER TABLE `files_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inv_type_ethic_eval_request`
--

DROP TABLE IF EXISTS `inv_type_ethic_eval_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inv_type_ethic_eval_request` (
  `academicrequestinfo_id` int(11) NOT NULL,
  `criterion_id` int(11) NOT NULL,
  PRIMARY KEY (`academicrequestinfo_id`,`criterion_id`),
  KEY `IDX_C54DA209C629BF44` (`academicrequestinfo_id`),
  KEY `IDX_C54DA20997766307` (`criterion_id`),
  CONSTRAINT `FK_C54DA20997766307` FOREIGN KEY (`criterion_id`) REFERENCES `criterion` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_C54DA209C629BF44` FOREIGN KEY (`academicrequestinfo_id`) REFERENCES `academic_request_info` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inv_type_ethic_eval_request`
--

LOCK TABLES `inv_type_ethic_eval_request` WRITE;
/*!40000 ALTER TABLE `inv_type_ethic_eval_request` DISABLE KEYS */;
INSERT INTO `inv_type_ethic_eval_request` VALUES (3,24),(3,25),(3,51),(7,51),(8,24),(9,46),(9,47);
/*!40000 ALTER TABLE `inv_type_ethic_eval_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ldap_user`
--

DROP TABLE IF EXISTS `ldap_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ldap_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `external` tinyint(1) DEFAULT NULL,
  `last_login_date` datetime DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  `deletion_date` datetime DEFAULT NULL,
  `carnet` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cedula_usuario` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3888D380D60322AC` (`role_id`),
  CONSTRAINT `FK_3888D380D60322AC` FOREIGN KEY (`role_id`) REFERENCES `users_roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ldap_user`
--

LOCK TABLES `ldap_user` WRITE;
/*!40000 ALTER TABLE `ldap_user` DISABLE KEYS */;
INSERT INTO `ldap_user` VALUES (1,1,'admin@cec.com','adminTester','Admin tester',NULL,NULL,'2019-08-15 06:13:45',NULL,NULL,'A12345','111111111'),(5,2,'student@cec.com','studentTester','Student tester',NULL,NULL,'2019-08-17 06:56:44',NULL,NULL,'A12345','111111111'),(6,3,'researcher@cec.com','researcherTester','Researcher tester',NULL,NULL,'2019-08-17 06:40:33',NULL,NULL,'A12345','111111111'),(7,4,'evaluadorcec@eldomo.net','evaluador-ed','Evaluator tester','$2y$13$fy3vTvE5P6kyz9Xh5.qJsecVPsCNoVP8j8lBTz6sDMXBKqJnKG4ku',1,'2019-08-15 06:36:58',NULL,NULL,'A12345','111111111'),(8,4,'lfitoria@eldomo.net','lfitoria','Luis Fitoria','$2y$13$XUhnf1ih9CjEgJQ/eTjtTuKL1HTB7nbpSbrFjnjf11DfzidiUMD0C',1,'2020-06-10 15:24:04',NULL,NULL,'2','1'),(9,4,'alfonso.chaconmata@ucr.ac.cr','alfonso.chaconmata','Alfonso Chacón Mata','$2y$13$O41OTHmDUymaGElaaufnYupzW1wsW2bw6MnxUALg1.6cdhN0eE2/6',0,'2020-06-09 21:57:24',NULL,NULL,'875090','0107270652'),(10,4,'manuel.triana@ucr.ac.cr','manuel.triana','Manuel Triana','$2y$13$kK2EBaiAR4OMmwkXt5AqieBpsLIKIkIYKDfXANXw06kFZgpO75Zde',0,'2020-05-29 20:33:14',NULL,NULL,'\'\'','0800630412'),(11,4,'jimmy.washburn@ucr.ac.cr','jimmy.washburn','Jimmy Washburn','$2y$13$opqTWUzDwXiBnLU4l4Bk6eCBswyJLu8.Pr56mAQuMDQGknB0AWeCa',0,'2019-08-17 06:40:33',NULL,NULL,NULL,NULL),(12,4,'sandra.silva@ucr.ac.cr','sandra.silva','Sandra Silva','$2y$13$H77CkiX1X7jLviBw5r4kfOwGnVbdvIAa4t3rpBXs3CjeVI5g0zLOG',0,'2019-08-17 06:40:33',NULL,NULL,NULL,NULL),(13,4,'rodrigo.morarodriguez@ucr.ac.cr','rodrigo.morarodriguez','Rodrigo Mora Rodríguez','$2y$13$s1n4nbIWxrBHiZDB8hvgWu6Hc39fp5LyjIUC80gsmQkuXDC0IASGi',0,'2020-05-05 10:44:00',NULL,NULL,'972283','0110350030'),(14,4,'maria.quesada@ucr.ac.cr','maria.quesada','María Quesada','$2y$13$3Isk5xkK4F2bZCfh.wJATOkorkmoBGC.1C0MpZz4y//BDbu.OTkGq',0,'2019-08-17 06:40:33',NULL,NULL,NULL,NULL),(15,1,'karol.ramirez@ucr.ac.cr','karol.ramirez','Karol Ramírez','$2y$13$9f5cGYkQW6ZDffmwYPK2q.A7xqRacDV3Ao7dbIRPG7VPOWYJmZ.L6',0,'2020-05-29 14:31:52',NULL,NULL,'972751','0109870022'),(16,4,'derby.munoz@ucr.ac.cr','derby.munoz','Derby Muñoz','$2y$13$VktQNzzYOX451BIHInp6W.td1lKzNNrzSEicz20ptOUzi7q9iZw72',0,'2020-05-27 17:15:03',NULL,NULL,'982560','0303620532'),(17,4,'ingrid.gomez@ucr.ac.cr','ingrid.gomez','Ingrid Gomez','$2y$13$pizdSZN8YUFgw.kIvF7P6OXwY.kzqWzvUkfPbYbEdNnA2bvuc28BK',0,'2019-08-17 06:40:33',NULL,NULL,NULL,NULL),(18,4,'freddy.arias_m@ucr.ac.cr','freddy.arias_m','Freddy Arias','$2y$13$der4lpkYpPc5ZGDEfu5OQ.tV9xb0RlO26aAEdYkp80yitrjqETVhm',0,'2019-08-17 06:40:33',NULL,NULL,NULL,NULL),(19,4,'oporrascr@gmail.com','oporrascr','Óscar Porras','$2y$13$TdBYPWa51fJTkE7QI07GNeHOpgImTbH5ab4zEeTfOeyTwBI/N/q62',1,'2019-08-17 06:40:33',NULL,NULL,NULL,NULL),(20,4,'anafournier@gmail.com','anafournier','Ana Fournier','$2y$13$ykqOvyiNj2xJ0z8/4dYlz.Eao.9bmbWp3YCQ0Llw6tn.1A4bbAaxS',1,'2019-08-17 06:40:33',NULL,NULL,NULL,NULL),(21,1,'cec@ucr.ac.cr','cec','Comité Ético Científico','$2y$13$EDpXy.VQlaLrHz8G5JkzBeUUIGnNuVfGIsW9pgUto7dO/I6KS0RgS',0,'2019-08-17 06:40:33',NULL,NULL,NULL,NULL),(22,1,'daihanna.hernandez@ucr.ac.cr','daihanna.hernandez','Daihanna Hernández','$2y$13$sJYdjry8LQoFU4peN25PSeUCHiVdR1oL8r0Sg3BdZbD6lcy4vMBHK',0,'2020-06-09 16:04:34',NULL,NULL,'','0116590063'),(23,3,'ANDREA.MOLINAOVARES@ucr.ac.cr','ANDREA.MOLINAOVARES','ANDREA MOLINA OVARES',NULL,0,'2020-06-09 14:46:40','2020-04-16 14:50:07',NULL,'A53503','0113060256'),(24,3,'LUIS.CONTRERAS@ucr.ac.cr','LUIS.CONTRERAS','LUIS JAVIER CONTRERAS ROJAS',NULL,0,'2020-05-15 16:32:27','2020-04-24 22:55:30',NULL,'950861','0502970151'),(25,1,'admin@forms.com','admin@forms.com','admin@forms.com','$2y$13$v7uHmMFIGbfBoQu3GPamb.uPfiWnGyjIYTkiEaCq/Y985zAYLDv/O',NULL,'2020-06-10 15:23:29','2020-04-27 16:25:58',NULL,NULL,'123'),(26,3,'SANDRA.SILVA@ucr.ac.cr','SANDRA.SILVA','SANDRA SILVA DE LA FUENTE',NULL,0,'2020-05-08 11:32:14','2020-05-08 11:32:14',NULL,'742504','0104610613'),(27,4,'jorge.sanabria@ucr.ac.cr','jorge.sanabria','Jorge Sanabria','$2y$13$ybVnUSHLIJQdrsy1d4xIEOSk7hB4/7Zw0/InSau2cDnGE6m2xPRYC',NULL,'2020-05-27 13:34:46','2020-05-27 13:34:46',NULL,NULL,NULL),(28,2,'MARIA.CARPIOULLOA@ucr.ac.cr','MARIA.CARPIOULLOA','MARIA JOSE CARPIO ULLOA',NULL,0,'2020-05-27 18:55:11','2020-05-27 18:55:11',NULL,'B31444','0304810872'),(29,3,'KAROL.RAMIREZ@ucr.ac.cr','KAROL.RAMIREZ','KAROL RAMIREZ CHAN',NULL,0,'2020-05-28 12:29:15','2020-05-28 12:29:15',NULL,'972751','0109870022'),(30,3,'DERBY.MUNOZ@ucr.ac.cr','DERBY.MUNOZ','DERBY MUNOZ ROJAS',NULL,0,'2020-06-04 23:10:09','2020-06-01 20:52:06',NULL,'982560','0303620532'),(31,2,'stud@forms.com','stud@forms.com','stud@forms.com','$2y$13$IBHQQ7UZF3QbhCXrvbp.E.nGW5O8JOr.tIouWcreWHNacJMXbt1le',NULL,'2020-06-09 15:02:44','2020-06-09 15:01:09',NULL,NULL,NULL),(32,4,'ire.camacho@gmail.com','ire.camacho','Irene Evaluadora','$2y$13$.SLpPkHBn9NDhJRORfOi3O2e.3UoEEn.28LSnmVqYcuaOkANvncQa',NULL,'2020-06-09 16:04:02','2020-06-09 16:01:01',NULL,NULL,'2-0565-066'),(33,3,'ALFONSO.CHACONMATA@ucr.ac.cr','ALFONSO.CHACONMATA','ALFONSO CHACON MATA',NULL,0,'2020-06-09 21:56:12','2020-06-09 21:56:12',NULL,'875090','0107270652');
/*!40000 ALTER TABLE `ldap_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `description` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_log_user` (`user_id`),
  CONSTRAINT `FK_8F3F68C5A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration_versions`
--

LOCK TABLES `migration_versions` WRITE;
/*!40000 ALTER TABLE `migration_versions` DISABLE KEYS */;
INSERT INTO `migration_versions` VALUES ('20200326175457','2020-04-15 06:20:17'),('20200403020712','2020-04-15 06:20:17'),('20200415061317','2020-04-15 06:20:17'),('20200420214848','2020-04-20 21:52:09'),('20200602203148','2020-06-04 22:53:37'),('20200604155307','2020-06-04 22:53:37'),('20200604214804','2020-06-04 22:53:38'),('20200605173646','2020-06-05 17:37:30');
/*!40000 ALTER TABLE `migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `population_ethic_eval_request`
--

DROP TABLE IF EXISTS `population_ethic_eval_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `population_ethic_eval_request` (
  `ethicevalrequest_id` int(11) NOT NULL,
  `criterion_id` int(11) NOT NULL,
  PRIMARY KEY (`ethicevalrequest_id`,`criterion_id`),
  KEY `IDX_C449A92A35E09FA2` (`ethicevalrequest_id`),
  KEY `IDX_C449A92A97766307` (`criterion_id`),
  CONSTRAINT `FK_C449A92A35E09FA2` FOREIGN KEY (`ethicevalrequest_id`) REFERENCES `ethic_eval_request` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_C449A92A97766307` FOREIGN KEY (`criterion_id`) REFERENCES `criterion` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `population_ethic_eval_request`
--

LOCK TABLES `population_ethic_eval_request` WRITE;
/*!40000 ALTER TABLE `population_ethic_eval_request` DISABLE KEYS */;
INSERT INTO `population_ethic_eval_request` VALUES (3,12),(7,12);
/*!40000 ALTER TABLE `population_ethic_eval_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pre_eval_request`
--

DROP TABLE IF EXISTS `pre_eval_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pre_eval_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(11) DEFAULT NULL,
  `request_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `observations` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` datetime NOT NULL,
  `current` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B36ABFAC427EB8A5` (`request_id`),
  KEY `FK_pre_eval_status` (`status`),
  KEY `FK_pre_eval_user` (`user_id`),
  CONSTRAINT `FK_B36ABFAC427EB8A5` FOREIGN KEY (`request_id`) REFERENCES `project_request` (`id`),
  CONSTRAINT `FK_B36ABFAC7B00651C` FOREIGN KEY (`status`) REFERENCES `criterion` (`id`),
  CONSTRAINT `FK_B36ABFACA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pre_eval_request`
--

LOCK TABLES `pre_eval_request` WRITE;
/*!40000 ALTER TABLE `pre_eval_request` DISABLE KEYS */;
INSERT INTO `pre_eval_request` VALUES (1,31,3,NULL,NULL,'2020-04-27 12:42:34',1),(2,32,1,NULL,'text','2020-04-28 10:07:49',1),(3,32,1,NULL,'text2','2020-04-28 10:25:56',1),(4,32,7,NULL,'1- Falta el acta de aprobación por parte de Trabajos Finales de graduación y en la misma que nos indiquen el nombre del tutor/asesores (si los tiene) y que es la última versión de la propuesta\r\n\r\n2-Si se hace uso del Consentimiento Informado, cada sección del documento, se debe llenar de acuerdo a lo que se va a realizar en el proyecto de investigación\r\n\r\n3- Falta la guía de lo que se preguntará o se discutirá en el grupo focal','2020-05-29 15:14:51',1),(5,31,12,NULL,NULL,'2020-06-09 16:04:27',1);
/*!40000 ALTER TABLE `pre_eval_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_request`
--

DROP TABLE IF EXISTS `project_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `title` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ext_institutions` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ext_institutions_authorization` tinyint(1) DEFAULT NULL,
  `place_of_study` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `involves_humans` tinyint(1) DEFAULT NULL,
  `doc_human_information` tinyint(1) DEFAULT NULL,
  `minute_commission_tfg` tinyint(1) DEFAULT NULL,
  `minute_final_work` tinyint(1) DEFAULT NULL,
  `minute_research_center` tinyint(1) DEFAULT NULL,
  `project_unit` text COLLATE utf8mb4_unicode_ci,
  `sip_project` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grupalProject` tinyint(1) DEFAULT NULL,
  `tutor_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tutor_id` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tutor_email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ascriptionUnit` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ucrInstitutions` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `uacademica` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emailComisionNotification` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AD8983FA5D83CC1` (`state_id`),
  KEY `IDX_AD8983FAA76ED395` (`user_id`),
  KEY `IDX_AD8983FA64C19C1` (`category`),
  CONSTRAINT `FK_AD8983FA5D83CC1` FOREIGN KEY (`state_id`) REFERENCES `criterion` (`id`),
  CONSTRAINT `FK_AD8983FA64C19C1` FOREIGN KEY (`category`) REFERENCES `criterion` (`id`),
  CONSTRAINT `FK_AD8983FAA76ED395` FOREIGN KEY (`user_id`) REFERENCES `ldap_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_request`
--

LOCK TABLES `project_request` WRITE;
/*!40000 ALTER TABLE `project_request` DISABLE KEYS */;
INSERT INTO `project_request` VALUES (1,32,8,45,'Crisis política y polarización social en la Costa Rica del bicentenario: hacia una lectura social y psicoanalítica del Edipo rey.','1',NULL,0,NULL,0,0,NULL,NULL,NULL,'INSTITUTO INVESTIGACIONES SOCIALES','1622-2020',NULL,NULL,NULL,NULL,NULL,NULL,'2020-04-15 01:27:13','020217',NULL),(2,28,23,45,'Crisis política y polarización social en la Costa Rica del bicentenario: hacia una lectura social y psicoanalítica del Edipo rey.','2',NULL,0,NULL,0,0,NULL,NULL,NULL,'INSTITUTO INVESTIGACIONES SOCIALES','1622-2020',NULL,NULL,NULL,NULL,NULL,NULL,'2020-04-16 14:52:08','020217',NULL),(3,31,13,43,'Novedosas estrategias para el abordaje clínico y la investigación de la carcinogénesis cervical','3','CCSSPRUEBA',0,'San Pedro de Montes de Oca, Centro de Investigación en Enfermedades Tropicales (CIET)PRUEBA',1,1,NULL,NULL,NULL,'CENTRO DE INVEST. EN ENFERMEDADES TROPICALES','0791-2020',NULL,NULL,NULL,NULL,NULL,NULL,'2020-04-17 16:47:41','020207',NULL),(4,27,8,45,'testPro','4',NULL,0,NULL,0,0,NULL,1,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,'2020-04-20 16:53:47','',NULL),(5,31,8,45,'Novedosas estrategias para el abordaje clínico y la investigación de la carcinogénesis cervical','5',NULL,0,NULL,0,0,NULL,0,0,'CENTRO DE INVEST. EN ENFERMEDADES TROPICALES','791-2020',0,NULL,NULL,NULL,NULL,NULL,'2020-04-23 15:11:44','020207',NULL),(6,27,13,43,'Novedosas estrategias para el abordaje clínico y la investigación de la carcinogénesis cervical','6',NULL,0,NULL,0,0,NULL,NULL,NULL,'CENTRO DE INVEST. EN ENFERMEDADES TROPICALES','0791-2020',NULL,NULL,NULL,NULL,NULL,NULL,'2020-05-05 11:11:44','020207',NULL),(7,32,28,45,'Paisaje Religioso: las iglesias Neopentecostales y la influencia del discurso evangélico del Partido Restauración Nacional en el comportamiento electoral de la primera ronda de las elecciones presidenciales del 2018 en Paquera, Costa Rica.','7',NULL,0,'Distrito de Paquera, Puntarenas. Costa Rica.',1,0,NULL,1,0,NULL,NULL,0,'María José Carpio Ulloa',NULL,'maria.carpioulloa@ucr.ac.cr','Escuela de Geografía',NULL,'2020-05-27 19:00:54','',NULL),(8,28,30,45,'Percepción de los y las profesionales del sistema estatal universitario que laboran en las oficinas de orientación, promoción y atención en salud sobre la violencia de pareja en estudiantes universitarios','8',NULL,0,'Sistema universitario estatal (UNA, UCR, TEC, UTN & UNED)',1,0,NULL,NULL,NULL,'CENTRO INV EN CUIDADO DE ENFERMERIA Y SALUD CICES','714-2021',NULL,NULL,NULL,NULL,NULL,NULL,'2020-06-03 11:36:23','020251',NULL),(9,27,23,45,'Percepción de los y las profesionales del sistema estatal universitario que laboran en las oficinas de orientación, promoción y atención en salud sobre la violencia de pareja en estudiantes universitarios','9',NULL,0,NULL,0,0,NULL,NULL,NULL,'CENTRO INV EN CUIDADO DE ENFERMERIA Y SALUD CICES','714-2021',NULL,NULL,NULL,NULL,NULL,NULL,'2020-06-03 12:16:50','020251',NULL),(10,28,8,45,'Crisis política y polarización social en la Costa Rica del bicentenario: hacia una lectura social y psicoanalítica del Edipo rey.','10',NULL,0,NULL,0,0,NULL,NULL,NULL,'INSTITUTO INVESTIGACIONES SOCIALES','1622-2020',NULL,NULL,NULL,NULL,NULL,NULL,'2020-06-09 14:00:58','020217',NULL),(11,28,8,45,'Novedosas estrategias para el abordaje clínico y la investigación de la carcinogénesis cervical','11',NULL,0,NULL,0,0,NULL,NULL,NULL,'CENTRO DE INVEST. EN ENFERMEDADES TROPICALES','791-2020',NULL,NULL,NULL,NULL,NULL,NULL,'2020-06-09 14:05:40','020207',NULL),(12,31,8,45,'Crisis política y polarización social en la Costa Rica del bicentenario: hacia una lectura social y psicoanalítica del Edipo rey.','12',NULL,0,NULL,0,0,NULL,NULL,NULL,'INSTITUTO INVESTIGACIONES SOCIALES','1622-2020',NULL,NULL,NULL,NULL,NULL,NULL,'2020-06-09 14:15:32','020217',NULL);
/*!40000 ALTER TABLE `project_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status_request`
--

DROP TABLE IF EXISTS `status_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status_request`
--

LOCK TABLES `status_request` WRITE;
/*!40000 ALTER TABLE `status_request` DISABLE KEYS */;
/*!40000 ALTER TABLE `status_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team_works_project`
--

DROP TABLE IF EXISTS `team_works_project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `team_works_project` (
  `projectrequest_id` int(11) NOT NULL,
  `teamwork_id` int(11) NOT NULL,
  PRIMARY KEY (`projectrequest_id`,`teamwork_id`),
  KEY `IDX_9FE9EFE91EDE5C6F` (`projectrequest_id`),
  KEY `IDX_9FE9EFE9341CF381` (`teamwork_id`),
  CONSTRAINT `FK_9FE9EFE91EDE5C6F` FOREIGN KEY (`projectrequest_id`) REFERENCES `project_request` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_9FE9EFE9341CF381` FOREIGN KEY (`teamwork_id`) REFERENCES `TeamWork` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_works_project`
--

LOCK TABLES `team_works_project` WRITE;
/*!40000 ALTER TABLE `team_works_project` DISABLE KEYS */;
/*!40000 ALTER TABLE `team_works_project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_roles`
--

DROP TABLE IF EXISTS `users_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_roles`
--

LOCK TABLES `users_roles` WRITE;
/*!40000 ALTER TABLE `users_roles` DISABLE KEYS */;
INSERT INTO `users_roles` VALUES (1,'ROLE_ADMIN','Administrador'),(2,'ROLE_STUDENT','Estudiante investigador'),(3,'ROLE_RESEARCHER','Persona investigadora'),(4,'ROLE_EVALUATOR','Evaluador');
/*!40000 ALTER TABLE `users_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `work_log`
--

DROP TABLE IF EXISTS `work_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `work_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `request_id` int(11) DEFAULT NULL,
  `eval_request_id` int(11) DEFAULT NULL,
  `pre_eval_request_id` int(11) DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `observations` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F5513F59A76ED395` (`user_id`),
  KEY `IDX_F5513F59427EB8A5` (`request_id`),
  KEY `IDX_F5513F5948DB1F` (`eval_request_id`),
  KEY `IDX_F5513F5978195BB6` (`pre_eval_request_id`),
  CONSTRAINT `FK_F5513F59427EB8A5` FOREIGN KEY (`request_id`) REFERENCES `project_request` (`id`),
  CONSTRAINT `FK_F5513F5948DB1F` FOREIGN KEY (`eval_request_id`) REFERENCES `eval_request` (`id`),
  CONSTRAINT `FK_F5513F5978195BB6` FOREIGN KEY (`pre_eval_request_id`) REFERENCES `pre_eval_request` (`id`),
  CONSTRAINT `FK_F5513F59A76ED395` FOREIGN KEY (`user_id`) REFERENCES `ldap_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `work_log`
--

LOCK TABLES `work_log` WRITE;
/*!40000 ALTER TABLE `work_log` DISABLE KEYS */;
INSERT INTO `work_log` VALUES (1,13,3,NULL,NULL,'Enviada/Editado por solicitante','2020-04-17 17:09:02',NULL),(2,22,3,NULL,NULL,'Asignada a: alfonso.chaconmata@ucr.ac.cr, sandra.silva@ucr.ac.cr, karol.ramirez@ucr.ac.cr, ','2020-04-24 13:11:42',NULL),(3,15,3,NULL,NULL,'Revisión preliminar','2020-04-27 12:42:35',NULL),(4,8,NULL,NULL,NULL,'Insercion de usuario: admin@forms.com','2020-04-27 16:25:59',NULL),(5,25,1,NULL,NULL,'Asignada a: lfitoria@eldomo.net, ','2020-04-28 10:05:01',NULL),(6,8,1,NULL,NULL,'Devuelto con observaciones ','2020-04-28 10:07:50','text'),(7,8,1,NULL,NULL,'Devuelto con observaciones ','2020-04-28 10:25:57','text2'),(8,15,3,NULL,NULL,'Devuelto con observaciones','2020-04-30 16:37:02','Rodrigo, por favor nos envía un correo para saber los detalles de este paso. Esto es una prueba del sistema.\r\n\r\nLo estoy devolviendo con observaciones.'),(9,25,5,NULL,NULL,'Asignada a: lfitoria@eldomo.net, ','2020-05-02 10:57:24',NULL),(10,8,5,NULL,NULL,'Devuelto con observaciones','2020-05-02 11:06:53','devol'),(11,13,3,NULL,NULL,'Enviada/Editado por solicitante','2020-05-05 10:55:22',NULL),(12,25,NULL,NULL,NULL,'Insercion de usuario: jorge.sanabria@ucr.ac.cr','2020-05-27 13:34:47',NULL),(13,25,NULL,NULL,NULL,'Edición de usuario: anafournier@gmail.com','2020-05-27 13:39:52',NULL),(14,25,NULL,NULL,NULL,'Edición de usuario: cec@ucr.ac.cr','2020-05-27 13:40:12',NULL),(15,28,7,NULL,NULL,'Enviada por solicitante','2020-05-27 19:14:30',NULL),(16,22,7,NULL,NULL,'Asignada a: manuel.triana@ucr.ac.cr, karol.ramirez@ucr.ac.cr, jorge.sanabria@ucr.ac.cr, ','2020-05-28 10:14:16',NULL),(17,25,NULL,NULL,NULL,'Edición de usuario: oporrascr@gmail.com','2020-05-28 15:52:33',NULL),(18,15,7,NULL,NULL,'Devuelto con observaciones ','2020-05-29 15:14:51','1- Falta el acta de aprobación por parte de Trabajos Finales de graduación y en la misma que nos indiquen el nombre del tutor/asesores (si los tiene) y que es la última versión de la propuesta\r\n\r\n2-Si se hace uso del Consentimiento Informado, cada sección del documento, se debe llenar de acuerdo a lo que se va a realizar en el proyecto de investigación\r\n\r\n3- Falta la guía de lo que se preguntará o se discutirá en el grupo focal'),(19,23,2,NULL,NULL,'Enviada/Editado por solicitante','2020-06-02 13:18:08',NULL),(20,30,8,NULL,NULL,'Enviada/Editado por solicitante','2020-06-04 23:31:42',NULL),(21,8,10,NULL,NULL,'Enviada/Editado por solicitante','2020-06-09 14:01:20',NULL),(22,8,11,NULL,NULL,'Enviada/Editado por solicitante','2020-06-09 14:09:15',NULL),(23,8,12,NULL,NULL,'Enviada/Editado por solicitante','2020-06-09 14:15:51',NULL),(24,25,NULL,NULL,NULL,'Insercion de usuario: stud@forms.com','2020-06-09 15:01:10',NULL),(25,25,NULL,NULL,NULL,'Edición de usuario: alfonso.chaconmata@ucr.ac.cr','2020-06-09 15:38:42',NULL),(26,25,NULL,NULL,NULL,'Edición de usuario: manuel.triana@ucr.ac.cr','2020-06-09 15:39:05',NULL),(27,25,NULL,NULL,NULL,'Edición de usuario: sandra.silva@ucr.ac.cr','2020-06-09 15:40:35',NULL),(28,25,NULL,NULL,NULL,'Edición de usuario: maria.quesada@ucr.ac.cr','2020-06-09 15:41:13',NULL),(29,25,NULL,NULL,NULL,'Edición de usuario: derby.munoz@ucr.ac.cr','2020-06-09 15:41:55',NULL),(30,25,NULL,NULL,NULL,'Edición de usuario: ingrid.gomez@ucr.ac.cr','2020-06-09 15:42:22',NULL),(31,25,NULL,NULL,NULL,'Edición de usuario: freddy.arias_m@ucr.ac.cr','2020-06-09 15:42:44',NULL),(32,25,NULL,NULL,NULL,'Edición de usuario: daihanna.hernandez@ucr.ac.cr','2020-06-09 15:43:09',NULL),(33,25,NULL,NULL,NULL,'Edición de usuario: oporrascr@gmail.com','2020-06-09 15:43:58',NULL),(34,25,NULL,NULL,NULL,'Edición de usuario: anafournier@gmail.com','2020-06-09 15:44:35',NULL),(35,25,NULL,NULL,NULL,'Edición de usuario: karol.ramirez@ucr.ac.cr','2020-06-09 15:45:08',NULL),(36,25,NULL,NULL,NULL,'Edición de usuario: anafournier@gmail.com','2020-06-09 15:45:46',NULL),(37,25,NULL,NULL,NULL,'Edición de usuario: cec@ucr.ac.cr','2020-06-09 15:46:35',NULL),(38,25,NULL,NULL,NULL,'Edición de usuario: daihanna.hernandez@ucr.ac.cr','2020-06-09 15:55:38',NULL),(39,25,NULL,NULL,NULL,'Edición de usuario: evaluadorcec@eldomo.net','2020-06-09 15:58:11',NULL),(40,25,NULL,NULL,NULL,'Insercion de usuario: ire.camacho@gmail.com','2020-06-09 16:01:02',NULL),(41,25,1,NULL,NULL,'Asignada a: ire.camacho@gmail.com, ','2020-06-09 16:02:13',NULL),(42,25,12,NULL,NULL,'Asignada a: ire.camacho@gmail.com, ','2020-06-09 16:03:44',NULL),(43,32,12,NULL,NULL,'Revisión preliminar','2020-06-09 16:04:27',NULL),(44,22,2,NULL,NULL,'Asignada a: alfonso.chaconmata@ucr.ac.cr, manuel.triana@ucr.ac.cr, ','2020-06-09 16:05:12',NULL),(45,22,7,NULL,NULL,'Asignada a: manuel.triana@ucr.ac.cr, jorge.sanabria@ucr.ac.cr, ','2020-06-09 16:07:46',NULL),(46,25,NULL,NULL,NULL,'Edición de usuario: rodrigo.morarodriguez@ucr.ac.cr','2020-06-10 15:42:30',NULL),(47,25,NULL,NULL,NULL,'Edición de usuario: jimmy.washburn@ucr.ac.cr','2020-06-10 15:42:47',NULL);
/*!40000 ALTER TABLE `work_log` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-06-10 16:00:57
