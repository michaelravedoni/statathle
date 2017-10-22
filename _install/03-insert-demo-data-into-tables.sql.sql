# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Hôte: localhost (MySQL 5.6.35)
# Base de données: stats
# Temps de génération: 2017-08-09 13:06:54 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Affichage de la table ca_athletes
# ------------------------------------------------------------

LOCK TABLES `ca_athletes` WRITE;
/*!40000 ALTER TABLE `ca_athletes` DISABLE KEYS */;

INSERT INTO `ca_athletes` (`id_a`, `nom_a`, `prenom_a`, `date_a`, `sexe_a`)
VALUES
	(1,'Ravedoni','Michael','1994-07-26','m'),
	(2,'Aubertin','Pierre-Yves','1996-01-01','m'),
	(3,'Putallaz','Anne-Valérie','1987-01-01','w'),

/*!40000 ALTER TABLE `ca_categories_competitions` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table ca_competitions
# ------------------------------------------------------------

LOCK TABLES `ca_competitions` WRITE;
/*!40000 ALTER TABLE `ca_competitions` DISABLE KEYS */;

INSERT INTO `ca_competitions` (`id_c`, `nom_c`, `lieu_c`, `date_c`, `id_cat_c`, `link_c`)
VALUES
	(1,'Course de Noël','Sion','2014-12-13',10,'http://services.datasport.com/2014/lauf/sion/'),
	(2,'Championnats valaisans jeunesse en salle','Salles Centre professionnel / Sion','2015-03-07',3,'http://casion.ch/contenu/resultats/2015/20150307-CVSJeunesseSalle-Sion.pdf'),
	(3,'Championnats valaisans U16 et plus âgés en salle','Aigle','2014-01-11',3,'http://www.cabvmartigny.ch/04RubResultats/Fichiers/2014111_resultats110114.pdf'),
	(4,'Meeting national en salle','Macolin','2014-02-01',9,'http://la-bern.ch/labern1/images/anlaesse/2014/Rangliste_MAG-2014SA.pdf'),

/*!40000 ALTER TABLE `ca_competitions` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table ca_categories
# ------------------------------------------------------------

LOCK TABLES `ca_categories` WRITE;
/*!40000 ALTER TABLE `ca_categories` DISABLE KEYS */;

INSERT INTO `ca_categories` (`id_cat`, `nom_cat`, `limite_cat`, `sexe_cat`, `ordre_cat`)
VALUES
	(1,'MAN',99,'m',1),
	(2,'U20 M',19,'m',3),
	(3,'U18 M',17,'m',4),
	(4,'U16 M',15,'m',5),
	(5,'U14 M',13,'m',6),
	(6,'U12 M',11,'m',7),
	(7,'WOM',99,'w',10),
	(8,'U20 W',19,'w',12),
	(9,'U18 W',17,'w',13),
	(10,'U16 W',15,'w',14),
	(11,'U14 W',13,'w',15),
	(12,'U12 W',11,'w',16),
	(13,'U23 M',22,'m',2),
	(14,'U23 W',22,'w',11),
	(16,'U10 M',9,'m',8),
	(17,'U10 W',9,'w',17),
	(18,'MASTERS M',99,'m',9),
	(19,'MASTERS W',99,'w',18),
	(20,'U16 M15',15,'m',19),
	(21,'U16 M14',14,'m',20),
	(22,'U14 M13',13,'m',21),
	(23,'U14 M12',12,'m',22),
	(24,'U12 M11',11,'m',23),
	(25,'U12 M10',10,'m',24),
	(26,'U10 M09',9,'m',25),
	(27,'U10 M08',8,'m',26),
	(28,'U10 M07',7,'m',27),
	(29,'U16 W15',15,'w',28),
	(30,'U16 W14',14,'w',29),
	(31,'U14 W13',13,'w',30),
	(32,'U14 W12',12,'w',31),
	(33,'U12 W11',11,'w',32),
	(34,'U12 W10',10,'w',33),
	(35,'U10 W09',9,'w',34),
	(36,'U10 W08',8,'w',35),
	(37,'U10 W07',7,'w',36),
	(38,'U12 MIX',11,'m',37),
	(39,'U23 M',22,'m',38),
	(40,'U23 W',22,'w',39);

/*!40000 ALTER TABLE `ca_categories` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table ca_categories_competitions
# ------------------------------------------------------------

LOCK TABLES `ca_categories_competitions` WRITE;
/*!40000 ALTER TABLE `ca_categories_competitions` DISABLE KEYS */;

INSERT INTO `ca_categories_competitions` (`id_cat_c`, `nom_cat_c`, `nomlong_cat_c`)
VALUES
	(1,'cs','Championnats suisses élites'),
	(2,'cr','Championnats romands'),
	(3,'cvs','Championnats valaisans'),
	(4,'ce','Championnats d\'Europe'),
	(5,'cm','Championnats du monde'),
	(6,'jo','Jeux olympiques'),
	(7,'si','Séléction internationale'),
	(8,'csi','Championnats suisses interclubs'),
	(9,'m','Meeting'),
	(10,'c','Course'),
	(11,'coupe','Coupe d\'Europe'),
	(12,'match','Match des 6 cantons'),
	(13,'cross','Cross'),
	(14,'kids','UBS Kids Cup'),
	(15,'sprintkm','Finale sprint et kilomètre'),
	(16,'css','Championnats suisses élites en salle'),
	(17,'cvss','Championnats valaisans en salle'),
	(18,'crs','Championnats romands en salle'),
	(19,'ces','Championnats d’Europe en salle'),
	(20,'cms','Championnats du monde en salle'),
	(21,'cee','Championnats d\'Europe par équipes'),
	(22,'cec','Championnats d\'Europe de cross-country'),
	(23,'cem','Championnats d\'Europe de course en montagne'),
	(24,'ceu23','Championnats d\'Europe U23'),
	(25,'cej','Championnats d\'Europe juniors'),
	(26,'ceu18','Championnats d\'Europe U18'),
	(27,'ceec','Coupe d\'Europe d\'épreuves combinées'),
	(28,'ce10000','Coupe d\'Europe du 10000 mètres'),
	(29,'cema','Coupe d\'Europe de marche'),
	(30,'cehl','Coupe d\'Europe hivernale des lancers'),
	(31,'cmeu23','Championnat Méditerranéen U23'),
	(32,'jf','Jeux de la Francophonie'),
	(33,'jm','Jeux méditerranéens'),
	(34,'cmj','Championnats du monde juniors'),
	(35,'cmu20','Championnats du monde jeunesse'),
	(36,'cc','Coupe continentale'),
	(37,'cmc','Championnats du monde de cross-country'),
	(38,'cmm','Coupe du monde de marche'),
	(39,'rm','Relais mondiaux'),
	(40,'cen','Coupe d\'Europe des nations'),
	(41,'cens','Coupe d\'Europe des nations en salle'),
	(42,'cmm','Coupe du monde de marche'),
	(43,'cmec','Coupe du monde des épreuves combinées'),
	(44,'cg','Commonwealth Games'),
	(45,'cem','Championnats d\'Europe masters'),
	(46,'cmma','Championnats du monde masters'),
	(47,'cmmas','Championnats du monde masters en salle'),
	(48,'cems','Championnats d\'Europe masters en salle'),
	(49,'uni','Universiade'),
	(50,'mwg','Military World Games'),
	(51,'foje','Festival olympique de la jeunesse européenne'),
	(52,'cyg','Commonwealth Youth Games'),
	(53,'joj','Jeux olympique de la jeunesse'),
	(54,'wc','IAAF World Challenge'),
	(55,'dl','Diamond League'),
	(56,'wim','World Indoor Meetings'),
	(57,'cssj','Championnats suisses jeunesses en salle'),
	(58,'csj','Championnats suisses jeunesses'),
	(59,'cscr','Championnats suisses de cross'),
	(60,'cvscr','Championnats valaisans de cross'),
	(61,'csst','Championnats suisses de 10 000m et steeple'),
	(62,'fvssk','Finale valaisanne de sprint et kilomètre'),
	(63,'csr','Championnats suisse de 100km sur route'),
	(64,'csm','Championnats suisses de la montagne'),
	(65,'csre','Championnats suisses de relais'),
	(66,'cscm','Championnats suisses de concours multiples'),
	(67,'cvscm','Championnats valaisans de concours multiples');

/*!40000 ALTER TABLE `ca_categories_competitions` ENABLE KEYS */;
UNLOCK TABLES;

# Affichage de la table ca_disciplines
# ------------------------------------------------------------

LOCK TABLES `ca_disciplines` WRITE;
/*!40000 ALTER TABLE `ca_disciplines` DISABLE KEYS */;

INSERT INTO `ca_disciplines` (`id_d`, `nom_d`, `tri_d`, `type_d`)
VALUES
	(38,'50 m','ASC',NULL),
	(39,'55 m','ASC',NULL),
	(40,'60 m','ASC',NULL),
	(41,'80 m','ASC',NULL),
	(42,'100 m','ASC',NULL),
	(43,'150 m','ASC',NULL),
	(44,'200 m','ASC',NULL),
	(45,'300 m','ASC',NULL),
	(46,'400 m','ASC',NULL),
	(47,'600 m','ASC',NULL),
	(48,'800 m','ASC',NULL),
	(49,'1000 m','ASC',NULL),
	(50,'1500 m','ASC',NULL),
	(51,'1 mile','ASC',NULL),
	(52,'2000 m','ASC',NULL),
	(53,'3000 m','ASC',NULL),
	(54,'5000 m','ASC',NULL),
	(55,'10 000 m','ASC',NULL),
	(56,'20 000 m','ASC',NULL),
	(57,'1 heure','ASC',NULL),
	(58,'25 000 m','ASC',NULL),
	(59,'30 000 m','ASC',NULL),
	(61,'Demimarathon','ASC',NULL),
	(62,'Marathon','ASC',NULL),
	(64,'50 m haies 106.7','ASC',NULL),
	(65,'50 m haies 99.1','ASC',NULL),
	(66,'50 m haies 91.4','ASC',NULL),
	(67,'50 m haies 84.0','ASC',NULL),
	(68,'50 m haies 76.2  U18 W','ASC',NULL),
	(69,'60 m haies 106.7','ASC',NULL),
	(70,'60 m haies 99.1','ASC',NULL),
	(71,'60 m haies 91.4','ASC',NULL),
	(72,'60 m haies 84.0','ASC',NULL),
	(73,'60 m haies 76.2  U18 W','ASC',NULL),
	(74,'80 m haies 76.2','ASC',NULL),
	(75,'100 m haies 84.0','ASC',NULL),
	(76,'100 m haies 76.2','ASC',NULL),
	(77,'110 m haies 106.7','ASC',NULL),
	(78,'110 m haies 99.1','ASC',NULL),
	(79,'110 m haies 91.4','ASC',NULL),
	(80,'200 m haies','ASC',NULL),
	(81,'300 m haies 84.0','ASC',NULL),
	(82,'300 m haies 76.2','ASC',NULL),
	(83,'400 m haies 91.4','ASC',NULL),
	(84,'400 m haies 76.2','ASC',NULL),
	(85,'1500 m Steeple','ASC',NULL),
	(86,'2000 m Steeple','ASC',NULL),
	(87,'3000 m Steeple','ASC',NULL),
	(88,'5x libre','ASC',NULL),
	(89,'5x80 m','ASC',NULL),
	(90,'6x libre','ASC',NULL),
	(91,'4x100 m','ASC',NULL),
	(92,'4x200 m','ASC',NULL),
	(93,'4x400 m','ASC',NULL),
	(94,'3x800 m','ASC',NULL),
	(95,'4x800 m','ASC',NULL),
	(96,'3x1000 m','ASC',NULL),
	(97,'4x1500 m','ASC',NULL),
	(98,'Olympique','ASC',NULL),
	(99,'Américaine','ASC',NULL),
	(100,'Hauteur','DESC',NULL),
	(101,'Perche','DESC',NULL),
	(102,'Longueur','DESC',NULL),
	(103,'Triple','DESC',NULL),
	(104,'Poids 7.26 kg','DESC',NULL),
	(105,'Poids 6.00 kg','DESC',NULL),
	(106,'Poids 5.00 kg','DESC',NULL),
	(107,'Poids 4.00 kg','DESC',NULL),
	(108,'Poids 3.00 kg','DESC',NULL),
	(109,'Poids 2.50 kg','DESC',NULL),
	(110,'Disque 2.00 kg','DESC',NULL),
	(111,'Disque 1.75 kg','DESC',NULL),
	(112,'Disque 1.50 kg','DESC',NULL),
	(113,'Disque 1.00 kg','DESC',NULL),
	(114,'Disque 0.75 kg','DESC',NULL),
	(115,'Marteau 7.26 kg','DESC',NULL),
	(116,'Marteau 6.00 kg','DESC',NULL),
	(117,'Marteau 5.00 kg','DESC',NULL),
	(118,'Marteau 4.00 kg','DESC',NULL),
	(119,'Marteau 3.00 kg','DESC',NULL),
	(120,'Javelot 800 gr','DESC',NULL),
	(121,'Javelot 700 gr','DESC',NULL),
	(122,'Javelot 600 gr','DESC',NULL),
	(123,'Javelot 400 gr','DESC',NULL),
	(124,'Balle 200 gr','DESC',NULL),
	(125,'Pentathlon W / U20 W Indoor','DESC',NULL),
	(126,'Pentathlon U18 W Indoor','DESC',NULL),
	(127,'Heptathlon M Indoor','DESC',NULL),
	(128,'Heptathlon U20 M Indoor','DESC',NULL),
	(129,'Heptathlon U18 M Indoor','DESC',NULL),
	(130,'Décathlon M','DESC',NULL),
	(131,'Décathlon U20 M','DESC',NULL),
	(132,'Décathlon U18 M','DESC',NULL),
	(133,'Décathlon W','DESC',NULL),
	(134,'Heptathlon','DESC',NULL),
	(135,'Heptathlon U18 W','DESC',NULL),
	(136,'Hexathlon U16 M','DESC',NULL),
	(137,'Pentathlon U16 W','DESC',NULL),
	(138,'UBS Kids Cup','DESC',NULL),
	(139,'Mile walk','ASC',NULL),
	(140,'3000 m walk','ASC',NULL),
	(141,'5000 m walk','ASC',NULL),
	(142,'10000 m walk','ASC',NULL),
	(143,'20000 m walk','ASC',NULL),
	(144,'50000 m walk','ASC',NULL),
	(145,'3 km walk','ASC',NULL),
	(146,'5 km walk','ASC',NULL),
	(147,'10 km walk','ASC',NULL),
	(150,'20 km walk','ASC',NULL),
	(152,'35 km walk','ASC',NULL),
	(154,'50 km walk','ASC',NULL),
	(156,'10 km','ASC',NULL),
	(157,'15 km','ASC',NULL),
	(158,'20 km','ASC',NULL),
	(159,'25 km','ASC',NULL),
	(160,'30 km','ASC',NULL),
	(162,'1 h  walk','ASC',NULL),
	(163,'2 h  walk','ASC',NULL),
	(164,'100 km walk','ASC',NULL),
	(165,'Balle 80 gr','DESC',NULL),
	(166,'300 m haies 91.4','ASC',NULL),
	(167,'...athlon','DESC',NULL),
	(168,'75 m','ASC',NULL),
	(169,'50 m haies 68.6','ASC',NULL),
	(170,'60 m haies 68.6','ASC',NULL),
	(171,'80 m haies 84.0','ASC',NULL),
	(172,'80 m haies 68.6','ASC',NULL),
	(173,'300 m haies 68.6','ASC',NULL),
	(174,'Javelot 500 gr','DESC',NULL),
	(175,'Pentathlon M','DESC',NULL),
	(176,'Pentathlon U20 M','DESC',NULL),
	(177,'Pentathlon U18 M','DESC',NULL),
	(178,'Pentathlon F','DESC',NULL),
	(180,'Pentathlon U18 F','DESC',NULL),
	(181,'Décathlon Master','DESC',NULL),
	(182,'2000 m walk','ASC',NULL),
	(183,'...cours','ASC',NULL),
	(184,'...longueur','DESC',NULL),
	(185,'...lancer','DESC',NULL),
	(186,'Longueur (zone)','DESC',NULL),
	(187,'50 m haies 76.2  U16W/U14M','ASC',NULL),
	(188,'50 m haies 76.2  U14 W (In)','ASC',NULL),
	(189,'50 m haies 60-76.2 U12 (In)','ASC',NULL),
	(190,'60 m haies 76.2  U16W/U14M','ASC',NULL),
	(191,'60 m haies 76.2  U14W (In)','ASC',NULL),
	(192,'60 m haies 60-76.2  U12 (In)','ASC',NULL),
	(193,'60 m H 76.2 U14 W Outdoor','ASC',NULL),
	(194,'60 m H 60-76.2 U12','ASC',NULL),
	(195,'Athlon U16 M','DESC',NULL),
	(196,'Pentathlon U18 M Indoor','DESC',NULL),
	(197,'Pentathlon U23 M','DESC',NULL),
	(198,'Pentathlon U20 W','DESC',NULL),
	(199,'Pentathlon U16 M Indoor','DESC',NULL),
	(200,'Pentathlon U16 w Indoor','DESC',NULL),
	(201,'Octathlon U18 M','DESC',NULL),
	(202,'Relais suédois','ASC',NULL),
	(203,'Javelot 500 gr','DESC',NULL),

/*!40000 ALTER TABLE `ca_disciplines` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table ca_palmares
# ------------------------------------------------------------

LOCK TABLES `ca_palmares` WRITE;
/*!40000 ALTER TABLE `ca_palmares` DISABLE KEYS */;

INSERT INTO `ca_palmares` (`id_p`, `id_a`, `id_d`, `rang_p`, `id_cat_c`, `id_c`, `annee_p`, `lieu_p`)
VALUES
	(2,1,100,2,16,63,'2015','St-Galles'),
	(3,1,100,2,18,53,'2015','Aigle'),
	(4,1,100,1,17,50,'2015','Aigle'),

/*!40000 ALTER TABLE `ca_palmares` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table ca_resultats
# ------------------------------------------------------------

LOCK TABLES `ca_resultats` WRITE;
/*!40000 ALTER TABLE `ca_resultats` DISABLE KEYS */;

INSERT INTO `ca_resultats` (`id_r`, `id_a`, `id_d`, `id_cat`, `id_c`, `performance`, `rang_r`, `vent_r`, `info_r`)
VALUES
	(1,1,41,12,2,'10.85','1','',''),
	(2,1,42,12,3,'12.03','3','',''),
	(3,1,42,12,4,'13.12','8','',''),
	(4,2,41,12,5,'13.20','10','',''),
	(5,2,41,12,6,'15.29','14','',''),
	(6,3,42,12,2,'16.09','2','',''),
	(7,3,42,12,4,'17.80','3','',''),

/*!40000 ALTER TABLE `ca_resultats` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
