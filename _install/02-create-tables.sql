
# Affichage de la table ca_athletes
# ------------------------------------------------------------

CREATE TABLE `ca_athletes` (
  `id_a` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nom_a` varchar(100) NOT NULL,
  `prenom_a` varchar(100) NOT NULL,
  `date_a` date NOT NULL,
  `sexe_a` varchar(2) NOT NULL,
  PRIMARY KEY (`id_a`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table ca_categories
# ------------------------------------------------------------

CREATE TABLE `ca_categories` (
  `id_cat` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nom_cat` varchar(50) NOT NULL,
  `limite_cat` int(11) NOT NULL,
  `sexe_cat` varchar(2) NOT NULL,
  `ordre_cat` int(11) NOT NULL,
  PRIMARY KEY (`id_cat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table ca_categories_competitions
# ------------------------------------------------------------

CREATE TABLE `ca_categories_competitions` (
  `id_cat_c` int(11) NOT NULL AUTO_INCREMENT,
  `nom_cat_c` varchar(11) DEFAULT NULL,
  `nomlong_cat_c` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_cat_c`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table ca_competitions
# ------------------------------------------------------------

CREATE TABLE `ca_competitions` (
  `id_c` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nom_c` varchar(100) NOT NULL,
  `lieu_c` varchar(100) NOT NULL,
  `date_c` date NOT NULL,
  `id_cat_c` int(11) NOT NULL,
  `link_c` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_c`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table ca_disciplines
# ------------------------------------------------------------

CREATE TABLE `ca_disciplines` (
  `id_d` int(11) NOT NULL AUTO_INCREMENT,
  `nom_d` varchar(50) NOT NULL,
  `tri_d` varchar(4) DEFAULT NULL,
  `type_d` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id_d`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table ca_palmares
# ------------------------------------------------------------

CREATE TABLE `ca_palmares` (
  `id_p` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_a` int(11) unsigned NOT NULL,
  `id_d` int(11) DEFAULT NULL,
  `rang_p` int(11) DEFAULT NULL,
  `id_cat_c` int(11) NOT NULL,
  `id_c` int(11) unsigned NOT NULL,
  `annee_p` year(4) DEFAULT NULL,
  `lieu_p` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_p`),
  KEY `id_cat_c` (`id_cat_c`),
  KEY `id_cat_c_2` (`id_cat_c`),
  KEY `id_c` (`id_c`),
  KEY `id_c_2` (`id_c`),
  KEY `id_d` (`id_d`),
  KEY `id_a` (`id_a`),
  CONSTRAINT `ca_palmares_ibfk_1` FOREIGN KEY (`id_cat_c`) REFERENCES `ca_categories_competitions` (`id_cat_c`) ON UPDATE CASCADE,
  CONSTRAINT `ca_palmares_ibfk_4` FOREIGN KEY (`id_a`) REFERENCES `ca_athletes` (`id_a`),
  CONSTRAINT `ca_palmares_ibfk_5` FOREIGN KEY (`id_d`) REFERENCES `ca_disciplines` (`id_d`),
  CONSTRAINT `ca_palmares_ibfk_6` FOREIGN KEY (`id_c`) REFERENCES `ca_competitions` (`id_c`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table ca_resultats
# ------------------------------------------------------------

CREATE TABLE `ca_resultats` (
  `id_r` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_a` int(11) unsigned NOT NULL,
  `id_d` int(11) NOT NULL,
  `id_cat` int(11) unsigned NOT NULL,
  `id_c` int(11) unsigned NOT NULL,
  `performance` varchar(11) NOT NULL,
  `rang_r` varchar(11) DEFAULT NULL,
  `vent_r` varchar(4) DEFAULT NULL,
  `info_r` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_r`),
  KEY `id_c` (`id_c`),
  KEY `id_d` (`id_d`),
  KEY `id_cat` (`id_cat`),
  KEY `id_a` (`id_a`),
  CONSTRAINT `ca_resultats_ibfk_1` FOREIGN KEY (`id_d`) REFERENCES `ca_disciplines` (`id_d`),
  CONSTRAINT `ca_resultats_ibfk_2` FOREIGN KEY (`id_cat`) REFERENCES `ca_categories` (`id_cat`),
  CONSTRAINT `ca_resultats_ibfk_3` FOREIGN KEY (`id_c`) REFERENCES `ca_competitions` (`id_c`),
  CONSTRAINT `ca_resultats_ibfk_4` FOREIGN KEY (`id_a`) REFERENCES `ca_athletes` (`id_a`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
