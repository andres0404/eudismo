/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.5.39 : Database - uvd_eudista
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`uvd_eudista` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `uvd_eudista`;

/*Table structure for table `cjm` */

DROP TABLE IF EXISTS `cjm`;

CREATE TABLE `cjm` (
  `cjm_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint(20) unsigned DEFAULT NULL,
  `cjm_orden` smallint(5) unsigned DEFAULT NULL,
  `cjm_fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `cjm_estado` smallint(6) DEFAULT '1',
  PRIMARY KEY (`cjm_id`),
  KEY `FK_usuario_cjm` (`id_usuario`),
  CONSTRAINT `FK_usuario_cjm` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `cjm` */

insert  into `cjm`(`cjm_id`,`id_usuario`,`cjm_orden`,`cjm_fecha`,`cjm_estado`) values (1,1,12,'2017-09-11 10:08:36',1);

/*Table structure for table `familia_eudista` */

DROP TABLE IF EXISTS `familia_eudista`;

CREATE TABLE `familia_eudista` (
  `fame_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint(20) unsigned DEFAULT NULL,
  `fame_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fame_id_hija` bigint(20) unsigned DEFAULT NULL,
  `fame_estado` smallint(5) unsigned DEFAULT '1',
  PRIMARY KEY (`fame_id`),
  KEY `FK_usuario_familia_eudista` (`id_usuario`),
  CONSTRAINT `FK_usuario_familia_eudista` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `familia_eudista` */

/*Table structure for table `formar_jesus` */

DROP TABLE IF EXISTS `formar_jesus`;

CREATE TABLE `formar_jesus` (
  `fj_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fj_tematica` int(10) unsigned DEFAULT NULL,
  `fj_fecha_publicacion` varchar(20) DEFAULT NULL,
  `fj_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fj_estado` smallint(5) unsigned DEFAULT '1',
  PRIMARY KEY (`fj_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `formar_jesus` */

insert  into `formar_jesus`(`fj_id`,`fj_tematica`,`fj_fecha_publicacion`,`fj_fecha`,`fj_estado`) values (1,1,'2017-09-07','2017-09-07 18:39:32',1);

/*Table structure for table `lang_textos` */

DROP TABLE IF EXISTS `lang_textos`;

CREATE TABLE `lang_textos` (
  `lang_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `lang_tbl` varchar(30) NOT NULL,
  `lang_id_tbl` bigint(20) unsigned NOT NULL,
  `lang_lengua` smallint(5) unsigned NOT NULL,
  `lang_texto` text,
  `lang_seccion` varchar(30) NOT NULL,
  PRIMARY KEY (`lang_id`),
  UNIQUE KEY `unico_lenguaje` (`lang_tbl`,`lang_id_tbl`,`lang_lengua`,`lang_seccion`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;

/*Data for the table `lang_textos` */

insert  into `lang_textos`(`lang_id`,`lang_tbl`,`lang_id_tbl`,`lang_lengua`,`lang_texto`,`lang_seccion`) values (1,'temas_fundamentales',2,1,'Una red peer-TO-peer, red de pares, red entre iguales o red entre pares (P2P, por sus siglas en inglés) es una red de ordenadores en la que todos o algunos aspectos funcionan SIN clientes ni servidores fijos, sino una serie de nodos que se comportan como iguales entre sí','desc'),(2,'temas_fundamentales',2,2,'A peer-TO-peer network, peer-to-peer network, or peer-to-peer network (P2P) is a computer network in which all or some aspects work without clients or fixed servers, of nodes that behave as equals','desc'),(3,'temas_fundamentales',2,3,'Un réseau peer-to-peer, un réseau peer-to-peer ou un réseau peer-to-peer (P2P) est un réseau informatique dans lequel tous ou certains aspects fonctionnent sans clients ni serveurs fixes, des noeuds qui se comportent comme égaux','desc'),(4,'temas_fundamentales',2,4,'Ein Peer-TO-Peer-Netzwerk, Peer-to-Peer-Netzwerk oder Peer-to-Peer-Netzwerk (P2P) ist ein Computernetzwerk, in dem alle oder einige Aspekte ohne Clients oder feste Server arbeiten, von Knoten, die sich als gleichermaßen verhalten','desc'),(6,'temas_fundamentales',2,5,'Uma rede peer-to-peer, rede peer-to-peer ou rede peer-to-peer (P2P) é uma rede informática na qual todos ou alguns aspectos funcionam sem clientes ou servidores fixos, de nós que se comportam como iguais','desc'),(7,'formar_jesus',1,1,'Cada moneda bitcóin puede subdividirse en cantidades más pequeñas, hasta llegar a los ocho decimales, cien millonésimas de bitcóin, es decir, 0,00000001 bitcoines. Esta unidad es conocida como satoshi, en honor al creador de Bitcoin. En la medida que se vaya extendiendo el uso de Bitcoin, al haber un número limitado, sus subdivisiones irán teniendo cada vez más importancia. En el estado actual de expansión en frecuente hablar de milibitcoin (1 mBTC=0,001 BTC), microbitcoin (1 µBTC=0,000001 BTC)','Referencia'),(8,'formar_jesus',1,2,'Each bitcoin coin can be subdivided into smaller quantities, up to eight decimals, one hundred millionths of bitcoin, that is, 0.00000001 bitcoins. This unit is known as satoshi, in honor of the creator of Bitcoin. To the extent that Bitcoin\'s use is extended, with a limited number, its subdivisions will become increasingly important. In the current state of expansion in frequent talk of milibitcoin (1 mBTC = 0.001 BTC), microbitcoin (1 ?BTC = 0.000001 BTC)','Bible Refence'),(9,'formar_jesus',1,1,'Aunque existen monedas19? y billetes fabricados por particulares y empresas, normalmente para poder comerciar con bitcoines se utilizan programas cliente,Nota 2? que pueden ser aplicaciones nativas o aplicaciones web.','Lectura Eudista'),(10,'formar_jesus',1,2,'Although there are coins19 and bills made by individuals and companies, usually to be able to trade with bitcoines are used client programs, Note 2 that can be native applications or web applications.','Eudist rea'),(11,'temas_fundamentales',2,1,'espanol','titulo'),(12,'temas_fundamentales',2,2,'ingles','titulo'),(13,'temas_fundamentales',2,3,'frances','titulo'),(14,'temas_fundamentales',2,4,'aleman','titulo'),(32,'temas_fundamentales',17,3,'Pour supprimer','titulo'),(33,'temas_fundamentales',17,3,'Pour supprimer un référentiel de GitHub, nous devons aller à la zone du projet que nous voulons supprimer. À droite, il y a un menu dans lequel nous devrons rechercher les \'Paramètres\'. Si nous cliquons sur le bouton, cela nous amènera à la page de paramètres où, à la fin, la zone de danger','desc'),(34,'temas_fundamentales',18,1,'Para eliminar un repositorio','titulo'),(35,'temas_fundamentales',18,1,'Para eliminar un repositorio de GitHub debemos ir al área del proyecto que deseamos borrar. A la derecha hay un menú en el que tendremos que buscar \'Settings\' (\'Ajustes\'). Si hacemos click en el botón, nos llevará a la página de ajustes en la que, al final de ésta, se encuentra la zona peligrosa','desc'),(36,'temas_fundamentales',19,1,'Pour supprimer','titulo'),(37,'temas_fundamentales',19,1,'Pour supprimer un référentiel de GitHub, nous devons aller à la zone du projet que nous voulons supprimer. À droite, il y a un menu dans lequel nous devrons rechercher les \'Paramètres\'. Si nous cliquons sur le bouton, cela nous amènera à la page de paramètres où, à la fin, la zone de danger','desc'),(38,'temas_fundamentales',20,1,'Pour supprimer','titulo'),(39,'temas_fundamentales',20,1,'Pour supprimer un référentiel de GitHub, nous devons aller à la zone du projet que nous voulons supprimer. À droite, il y a un menu dans lequel nous devrons rechercher les \'Paramètres\'. Si nous cliquons sur le bouton, cela nous amènera à la page de paramètres où, à la fin, la zone de danger','desc'),(40,'temas_fundamentales',21,1,'Pour supprimer','titulo'),(41,'temas_fundamentales',21,1,'Pour supprimer un référentiel de GitHub, nous devons aller à la zone du projet que nous voulons supprimer. À droite, il y a un menu dans lequel nous devrons rechercher les \'Paramètres\'. Si nous cliquons sur le bouton, cela nous amènera à la page de paramètres où, à la fin, la zone de danger','desc'),(43,'temas_fundamentales',18,2,'To remove a repository','titulo'),(44,'temas_fundamentales',18,2,'To remove a repository from GitHub we must go to the project area that we want to delete. On the right there is a menu in which we will have to search for \'Settings\'. If we click on the button, it will take us to the settings page where, at the end of it, is the danger zone','desc'),(51,'cjm',1,4,'Watson','titulo'),(52,'cjm',1,4,'Watson ist ein Computerprogramm aus dem Bereich der Künstlichen Intelligenz. Es wurde von IBM entwickelt, um Antworten auf Fragen zu geben, die in digitaler Form in natürlicher Sprache eingegeben werden. Das nach Thomas J. Watson, einem der ersten Präsidenten von IBM, benannte Programm wurde als Teil des DeepQA-Forschungsprojektes entwickelt','desc'),(53,'cjm',1,3,'Watson','titulo'),(54,'cjm',1,3,'Watson est un programme informatique d\'intelligence artificielle conçu par IBM dans le but de répondre à des questions formulées en langage naturel1. Il s\'intègre dans un programme de développement plus vaste, le DeepQA research project. Le nom « Watson » fait référence à Thomas J. Watson, dirigeant d\'IBM de 1914 à 19562, avant même que cette société ne s\'appelle ainsi. Le programme a notamment acquis une notoriété mondiale en devenant en 2011 champion du jeu télévisé américain Jeopardy!','desc'),(55,'cjm',1,5,'Watson','titulo'),(56,'cjm',1,5,'Watson é um sistema para o processamento avançado, recuperação de informação, representação de conhecimento, raciocínio automatizado e tecnologias de aprendizado de máquinas','desc'),(57,'cjm',1,2,'Watson','titulo'),(58,'cjm',1,2,'Watson is a question answering computer system capable of answering questions posed in natural language,[2] developed in IBM\'s DeepQA project by a research team led by principal investigator David Ferrucci.[3] Watson was named after IBM\'s first CEO, industrialist Thomas J. Watson.[4][5] The computer system was specifically developed to answer questions on the quiz show Jeopardy![6] and, in 2011, the Watson computer system competed on Jeopardy! against former winners Brad Rutter and Ken Jennings[4][7] winning the first place prize of $1 million','desc'),(59,'cjm',1,1,'Watson','titulo'),(60,'cjm',1,1,'Watson es un sistema informático de inteligencia artificial que es capaz de responder a preguntas formuladas en lenguaje natural,1? desarrollado por la corporación estadounidense IBM. Forma parte del proyecto del equipo de investigación DeepQA, liderado por el investigador principal David Ferrucci. Lleva su nombre en honor del fundador y primer presidente de IBM, Thomas J. Watson','desc'),(61,'cjm',1,6,'Watson','titulo'),(62,'cjm',1,6,'Watson è un sistema informatico rispondente alle domande poste in linguaggio naturale [2] sviluppato nel progetto DeepQA di IBM da un gruppo di ricerca guidato dal principale investigatore David Ferrucci [3]. Watson è stato nominato dal primo CEO di IBM, l\'industrialista Thomas J. Watson. [4] [5] Il sistema informatico è stato sviluppato appositamente per rispondere alle domande sul tema Jeopardy! [6] e nel 2011 il sistema informatico Watson ha competito su Jeopardy! contro gli ex vincitori Brad Rutter e Ken Jennings [4] [7] vincendo il premio di primo piano di $ 1 milione','desc');

/*Table structure for table `mt_contenidos` */

DROP TABLE IF EXISTS `mt_contenidos`;

CREATE TABLE `mt_contenidos` (
  `id_contenido` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_tabla` bigint(20) unsigned DEFAULT NULL,
  `id_valor` bigint(20) unsigned DEFAULT NULL,
  `valor` varchar(150) DEFAULT NULL,
  `estado` smallint(5) unsigned DEFAULT '1',
  PRIMARY KEY (`id_contenido`),
  UNIQUE KEY `unico_mt_contenido` (`id_tabla`,`id_valor`,`valor`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Data for the table `mt_contenidos` */

insert  into `mt_contenidos`(`id_contenido`,`id_tabla`,`id_valor`,`valor`,`estado`) values (1,1,1,'Español',1),(2,1,2,'English',1),(3,1,3,'Français',1),(4,1,4,'Deutsch',1),(5,1,5,'Portugues',1),(6,2,1,'Tema 1',1),(7,2,2,'Tema 2',1),(8,2,3,'Tema 3',1),(9,3,1,'Categoria 1',1),(10,3,2,'Categoria 2',1),(11,3,3,'Categoria 3',1),(12,4,1,'es',1),(13,4,2,'en',1),(14,4,3,'fr',1),(15,4,4,'de',1),(16,4,5,'pt',1),(17,1,6,'Italiano',1),(18,4,6,'it',1);

/*Table structure for table `mt_tablas` */

DROP TABLE IF EXISTS `mt_tablas`;

CREATE TABLE `mt_tablas` (
  `id_tablas` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nom_tabla` varchar(40) DEFAULT NULL,
  `estado` smallint(5) unsigned DEFAULT '1',
  PRIMARY KEY (`id_tablas`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `mt_tablas` */

insert  into `mt_tablas`(`id_tablas`,`nom_tabla`,`estado`) values (1,'Lenguajes',1),(2,'Formar a Jesus tematicas',1),(3,'Oraciones Lista Categorias',1),(4,'Lenguaje cod ISO',1);

/*Table structure for table `novedades_noticias` */

DROP TABLE IF EXISTS `novedades_noticias`;

CREATE TABLE `novedades_noticias` (
  `novt_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `novt_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `novt_estado` smallint(5) unsigned DEFAULT '1',
  PRIMARY KEY (`novt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `novedades_noticias` */

/*Table structure for table `oraciones` */

DROP TABLE IF EXISTS `oraciones`;

CREATE TABLE `oraciones` (
  `ora_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ora_categoria` int(10) unsigned DEFAULT NULL,
  `ora_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ora_estado` smallint(5) unsigned DEFAULT '1',
  PRIMARY KEY (`ora_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `oraciones` */

/*Table structure for table `temas_fundamentales` */

DROP TABLE IF EXISTS `temas_fundamentales`;

CREATE TABLE `temas_fundamentales` (
  `temf_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint(20) unsigned DEFAULT NULL,
  `temf_orden` smallint(5) unsigned DEFAULT NULL,
  `temf_fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `temf_estado` smallint(6) DEFAULT '1',
  PRIMARY KEY (`temf_id`),
  KEY `FK_usuario_temas_fundamentales` (`id_usuario`),
  CONSTRAINT `FK_usuario_temas_fundamentales` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

/*Data for the table `temas_fundamentales` */

insert  into `temas_fundamentales`(`temf_id`,`id_usuario`,`temf_orden`,`temf_fecha`,`temf_estado`) values (7,1,10,'2017-09-10 20:11:06',1),(17,1,10,'2017-09-10 20:30:17',1),(18,1,10,'2017-09-10 20:32:09',1),(19,1,10,'2017-09-10 20:32:34',1),(20,1,10,'2017-09-10 20:33:20',1),(21,1,10,'2017-09-10 21:16:21',1);

/*Table structure for table `testimonios` */

DROP TABLE IF EXISTS `testimonios`;

CREATE TABLE `testimonios` (
  `test_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint(20) unsigned DEFAULT NULL,
  `test_titulo` tinytext,
  `test_testimonio` varchar(2000) DEFAULT NULL,
  `test_leng` smallint(5) unsigned DEFAULT NULL,
  `test_foto` mediumtext,
  PRIMARY KEY (`test_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `testimonios` */

/*Table structure for table `usuarios` */

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `id_usuario` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `u_tipousuario` smallint(5) unsigned DEFAULT NULL,
  `u_lengua` smallint(5) unsigned DEFAULT NULL,
  `u_nombre` varchar(60) DEFAULT NULL,
  `u_correo` varchar(50) DEFAULT NULL,
  `u_clave` varchar(50) DEFAULT NULL,
  `u_sexo` smallint(5) unsigned DEFAULT NULL,
  `u_activo` smallint(5) unsigned DEFAULT '1',
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `usuarios` */

insert  into `usuarios`(`id_usuario`,`u_tipousuario`,`u_lengua`,`u_nombre`,`u_correo`,`u_clave`,`u_sexo`,`u_activo`) values (1,2,1,'Andres Pachon','andres@loquesea.com','40bd001563085fc35165329ea1ff5c5ecbdbbeef',2,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
