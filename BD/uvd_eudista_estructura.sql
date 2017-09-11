/*
SQLyog Community v9.30 
MySQL - 5.5.5-10.1.13-MariaDB : Database - uvd_eudista
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
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Table structure for table `mt_tablas` */

DROP TABLE IF EXISTS `mt_tablas`;

CREATE TABLE `mt_tablas` (
  `id_tablas` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nom_tabla` varchar(40) DEFAULT NULL,
  `estado` smallint(5) unsigned DEFAULT '1',
  PRIMARY KEY (`id_tablas`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `novedades_noticias` */

DROP TABLE IF EXISTS `novedades_noticias`;

CREATE TABLE `novedades_noticias` (
  `novt_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `novt_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `novt_estado` smallint(5) unsigned DEFAULT '1',
  PRIMARY KEY (`novt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `oraciones` */

DROP TABLE IF EXISTS `oraciones`;

CREATE TABLE `oraciones` (
  `ora_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ora_categoria` int(10) unsigned DEFAULT NULL,
  `ora_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ora_estado` smallint(5) unsigned DEFAULT '1',
  PRIMARY KEY (`ora_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
