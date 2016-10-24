/*
SQLyog Ultimate v11.33 (64 bit)
MySQL - 5.5.52-cll : Database - grapicco_nmx_test_devfs
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`grapicco_nmx_test_devfs` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `grapicco_nmx_test_devfs`;

/*Table structure for table `media` */

DROP TABLE IF EXISTS `media`;

CREATE TABLE `media` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `archivo` varchar(255) NOT NULL,
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `estatus` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `media` */

insert  into `media`(`id`,`archivo`,`create_date`,`estatus`) values (1,'content/gifs/231016015106.gif','2016-10-23 01:50:48',1),(2,'content/gifs/231016020500.gif','2016-10-23 02:04:42',0),(3,'content/gifs/231016020532.gif','2016-10-23 02:05:14',0),(4,'content/gifs/231016020719.gif','2016-10-23 02:07:01',0),(5,'content/gifs/231016023453.gif','2016-10-23 02:34:36',0),(6,'content/gifs/231016031851.gif','2016-10-23 03:18:34',0),(7,'content/gifs/231016032131.gif','2016-10-23 03:21:14',0),(8,'content/gifs/231016032331.gif','2016-10-23 03:23:14',1),(9,'content/gifs/231016092343.gif','2016-10-23 09:23:25',1),(10,'content/gifs/231016034714.gif','2016-10-23 15:46:57',1);

/*Table structure for table `usuario` */

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `guid` varchar(33) DEFAULT NULL,
  `nombre` varchar(75) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pass` varchar(33) NOT NULL,
  `login_date` datetime DEFAULT NULL,
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `estatus` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `usuario` */

insert  into `usuario`(`id`,`guid`,`nombre`,`email`,`pass`,`login_date`,`create_date`,`estatus`) values (1,NULL,'Rafael López','test@prueba.com','e10adc3949ba59abbe56e057f20f883e','2016-10-23 11:22:39','2016-10-23 11:01:31',1),(7,'1ab60d58d9e93f49253a1a98d5c6ae92','Samuel López','rafaellorey@gmail.com','e10adc3949ba59abbe56e057f20f883e','2016-10-23 22:29:10','2016-10-23 13:23:08',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
