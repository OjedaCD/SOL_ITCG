SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
--
-- Database: `sol_itcg`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `idRole` int NOT NULL,
  `nomRole` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`idRole`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



CREATE TABLE IF NOT EXISTS `departamentos` (
  `idDpto` int NOT NULL,
  `nomDpto` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idDpto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



CREATE TABLE IF NOT EXISTS `users` (
  `idUser` int NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `token` varchar(250) NOT NULL,
  `nomUsuario` varchar(60) NOT NULL,
  `apellidoUsuario` varchar(60) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `edoUser` varchar(40) NOT NULL,
  `idRole` int NOT NULL,
  `idDpto` int NOT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `idRole_idx` (`idRole`),
  KEY `idDpto_idx` (`idDpto`),
  CONSTRAINT `idDptoAC` FOREIGN KEY (`idDpto`) REFERENCES `departamentos` (`idDpto`),
  CONSTRAINT `idRole--us` FOREIGN KEY (`idRole`) REFERENCES `roles` (`idRole`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb3;



CREATE TABLE IF NOT EXISTS `solicitudes` (
  `idSolicitud` int NOT NULL AUTO_INCREMENT,
  `idUser` int NOT NULL,
  `idDpto` int NOT NULL,
  `folio` varchar(25) NOT NULL,
  `fecha` date NOT NULL,
  `tipo` varchar(25) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `observacion` varchar(255) DEFAULT NULL,
  `Etapa` varchar(25) NOT NULL,
  `Prioridad` varchar(25) NOT NULL,
  `Estado` varchar(25) NOT NULL,
  PRIMARY KEY (`idSolicitud`),
  KEY `idUser_idx` (`idUser`),
  KEY `idDpto_idx` (`idDpto`),
  CONSTRAINT `idDpto` FOREIGN KEY (`idDpto`) REFERENCES `departamentos` (`idDpto`),
  CONSTRAINT `idUser` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb3;



CREATE TABLE IF NOT EXISTS `fallas` (
  `idFalla` int NOT NULL,
  `nomFalla` varchar(180) NOT NULL,
  PRIMARY KEY (`idFalla`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



CREATE TABLE IF NOT EXISTS `detalles` (
  `idSolicitud` int NOT NULL,
  `idFalla` int NOT NULL,
  KEY `idSolicitud_idx` (`idSolicitud`),
  KEY `idFalla_idx` (`idFalla`),
  CONSTRAINT `idFalla` FOREIGN KEY (`idFalla`) REFERENCES `fallas` (`idFalla`),
  CONSTRAINT `idSolicitud` FOREIGN KEY (`idSolicitud`) REFERENCES `solicitudes` (`idSolicitud`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO roles VALUES
("1","SUPERADMIN"),
("2","ADMINISTRADOR"),
("3","SOLICITANTE");



INSERT INTO departamentos VALUES
("1","PLANEACIÓN, PROGRAMACIÓN Y PRESUPUESTACIÓN"),
("2","GESTIÓN TECNOLÓGICA Y VINCULACIÓN"),
("3","COMUNICACIÓN Y DIFUSIÓN"),
("4","ACTIVIDADES EXTRAESCOLARES"),
("5","SERVICIOS ESCOLARES"),
("6","CENTRO DE INFORMACIÓN"),
("7","CIENCIAS BÁSICAS"),
("8","SISTEMAS Y COMPUTACIÓN"),
("9","METAL – MECÁNICA"),
("10","CIENCIAS DE LA TIERRA"),
("11","INGENIERÍA INDUSTRIAL"),
("12","INGENIERÍA ELÉCTRICA Y ELECTRÓNICA"),
("13","CIENCIAS ECONÓMICO – ADMINISTRATIVAS"),
("14","DESARROLLO ACADÉMICO"),
("15","DIVISIÓN DE ESTUDIOS PROFESIONALES"),
("16","DIVISIÓN DE ESTUDIOS DE POSGRADO E INVESTIGACIÓN"),
("17","RECURSOS HUMANOS"),
("18","RECURSOS FINANCIEROS"),
("19","RECURSOS MATERIALES Y SERVICIOS"),
("20","CENTRO DE CÓMPUTO"),
("21","MANTENIMIENTO DE EQUIPO"),
("22","SUBDIRECCIÓN DE SERVICIOS ADMINISTRATIVOS"),
("23","SUBDIRECCIÓN ACADÉMICA"),
("24","SUBDIRECCIÓN DE PLANEACIÓN Y VINCULACIÓN"),
("25","DIRECCIÓN");



INSERT INTO users VALUES
("1","estanislao.ch@cdguzman.tecnm.mx","$2y$10$GogtrcKgO4lVFU419jMIHuit5CRg8xRKdv5tnMPjPkhgj1LCX3dmG","Estanislao","Castillo Horta","0","HABILITADO","1","20");




INSERT INTO fallas VALUES
("1","En internet"),
("2","Imprimir"),
("3","Office (Word, Access, PowerPoint)"),
("4","Virus"),
("5","Software propio (Sie, Siatec, Siabug, Control de Asistencias, Ficha de Depósito, Control de Acceso a Biblioteca, Buzon de Quejas, Contpaq, Sii, Sahir, Siasep, etc)."),
("6","Mal funcionamiento del equipo"),
("7","Otra falla"),
("8","Mantenimiento eléctrico "),
("9","Mantenimiento hidráulico"),
("10","Mantenimiento sanitario"),
("11","Mantenimiento de vidrios y aluminios"),
("12","Mantenimiento de albañilería"),
("13","Mantenimiento de pintura"),
("14","Mantenimiento de impermeabilizantes"),
("15","Mantenimiento de herrería"),
("16","Otra falla");




/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;