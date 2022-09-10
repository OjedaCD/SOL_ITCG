/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE TABLE `calificaciones` (
  `id_MateriaG` int(11) NOT NULL,
  `alufic` char(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `calif` float DEFAULT NULL,
  PRIMARY KEY (`id_MateriaG`,`alufic`),
  KEY `fk_calificaciones_idMateriaG_idx` (`id_MateriaG`),
  KEY `fk_calificaciones_alufic` (`alufic`),
  CONSTRAINT `fk_calificaciones_alufic` FOREIGN KEY (`alufic`) REFERENCES `dficha` (`alufic`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_calificaciones_idMateriaG` FOREIGN KEY (`id_MateriaG`) REFERENCES `materia_grupo` (`id_MateriaG`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `carreras` (
  `idCar` int(2) NOT NULL,
  `nombcar` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idCar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `config` (
  `idConfig` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idConfig`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `detalles_config` (
  `idConfig` int(11) NOT NULL,
  `idCar` int(2) NOT NULL,
  `cant_Grupos` int(11) DEFAULT NULL,
  `cant_Elem_Grupo` int(11) DEFAULT NULL,
  PRIMARY KEY (`idConfig`,`idCar`),
  KEY `fk_detalles_config_idCar` (`idCar`),
  CONSTRAINT `fk_detalles_config_idCar` FOREIGN KEY (`idCar`) REFERENCES `carreras` (`idCar`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalles_config_idConfig` FOREIGN KEY (`idConfig`) REFERENCES `config` (`idConfig`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `dficha` (
  `alufic` char(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aluapp` char(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aluapm` char(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alunom` char(35) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alupro` int(3) DEFAULT NULL,
  `carcve1` int(2) NOT NULL,
  `carcve2` int(2) NOT NULL,
  `alucve` char(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `folio` char(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `calificacionCeneval` int(11) DEFAULT NULL,
  PRIMARY KEY (`alufic`),
  KEY `fk_DFICHA_carcve1` (`carcve1`),
  KEY `fk_DFICHA_carcve2` (`carcve2`),
  CONSTRAINT `fk_DFICHA_carcve1` FOREIGN KEY (`carcve1`) REFERENCES `carreras` (`idCar`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_DFICHA_carcve2` FOREIGN KEY (`carcve2`) REFERENCES `carreras` (`idCar`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `grupos` (
  `idGrupo` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alufic` char(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `letraGrupo` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idGrupo`,`alufic`),
  KEY `fk_grupos_alufic` (`alufic`),
  CONSTRAINT `fk_grupos_alufic` FOREIGN KEY (`alufic`) REFERENCES `dficha` (`alufic`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `maestros` (
  `idMaestro` int(10) unsigned NOT NULL,
  `nombre_Maestro` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idMaestro`),
  CONSTRAINT `fk_maestros_idMaestro` FOREIGN KEY (`idMaestro`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `materia_grupo` (
  `id_MateriaG` int(11) NOT NULL,
  `idMateria` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idMaestro` int(10) unsigned NOT NULL,
  `idGrupo` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_MateriaG`),
  KEY `fk_materia_Grupo_idMaestro_idx` (`idMaestro`),
  KEY `fk_materia_Grupo_idMateria` (`idMateria`),
  CONSTRAINT `fk_materia_Grupo_idMaestro` FOREIGN KEY (`idMaestro`) REFERENCES `maestros` (`idMaestro`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_materia_Grupo_idMateria` FOREIGN KEY (`idMateria`) REFERENCES `materias` (`idMateria`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `materias` (
  `idMateria` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_Mat` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idMateria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_usuario_unique` (`email`(191))
) ENGINE=InnoDB AUTO_INCREMENT=315 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



INSERT INTO `carreras` (`idCar`, `nombcar`) VALUES
(0, '');
INSERT INTO `carreras` (`idCar`, `nombcar`) VALUES
(4, 'INGENIERÍA ELECTRÓNICA');
INSERT INTO `carreras` (`idCar`, `nombcar`) VALUES
(5, 'INGENIERÍA MECÁNICA');
INSERT INTO `carreras` (`idCar`, `nombcar`) VALUES
(6, 'INGENIERÍA ELÉCTRICA'),
(15, 'INGENIERÍA EN SISTEMAS COMPUTACIONALES'),
(16, 'INGENIERÍA INDUSTRIAL'),
(18, 'MAESTRÍA EN INGENIERÍA ELECTRÓNICA'),
(20, 'INGENIERÍA AMBIENTAL'),
(21, 'ARQUITECTURA'),
(22, 'CONTADOR PÚBLICO'),
(23, 'INGENIERÍA EN GESTIÓN EMPRESARIAL'),
(24, 'INGENIERÍA INFORMÁTICA'),
(25, 'MAESTRÍA EN CIENCIAS DE LA COMPUTACIÓN');













INSERT INTO `materias` (`idMateria`, `nombre_Mat`) VALUES
('1', 'MATEMÁTICAS');
INSERT INTO `materias` (`idMateria`, `nombre_Mat`) VALUES
('2', 'DESARROLLO HUMANO');
INSERT INTO `materias` (`idMateria`, `nombre_Mat`) VALUES
('3', 'INTRODUCCIÓN A LA CARRERA');

INSERT INTO `users` (`id`, `email`, `role`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(314, 'fer-410@live.com.mx', 'admin', '$2y$10$r3VH0OtAD5NpfppwvSSkke5LgNy9dwAdt5puusg2W4CucqDp7meH2', NULL, '0000-00-00 00:00:00', NULL);



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;