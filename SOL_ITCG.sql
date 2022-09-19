
CREATE TABLE `roles` (
  `idRole` int(4) NOT NULL,
  `nomRole` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`idRole`)
);


CREATE TABLE `departamentos` (
  `idDpto` int(4) NOT NULL,
  `nomDpto` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idDpto`)
);

CREATE TABLE IF NOT EXISTS `users` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(120) DEFAULT NULL,
  `token` varchar(250) DEFAULT NULL,
  `nomUsuario` varchar(60) DEFAULT NULL,
  `apellidoUsuario` varchar(60) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `idRole` int(4) DEFAULT NULL,
  KEY `idRole_idx` (`idRole`),
  CONSTRAINT `idRole--us` FOREIGN KEY (`idRole`) REFERENCES `roles` (`idRole`),
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;


CREATE TABLE `accesos` (
  `idUser` int(4) DEFAULT NULL,
  `idRole` int(4) DEFAULT NULL,
  KEY `idUser_idx` (`idUser`),
  KEY `idRole_idx` (`idRole`),
  CONSTRAINT `idUser` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`),
  CONSTRAINT `idRole` FOREIGN KEY (`idRole`) REFERENCES `roles` (`idRole`)
);

CREATE TABLE `pertenencias` (
  `idUser` int(4) DEFAULT NULL,
  `idDpto` int(4) DEFAULT NULL,
  KEY `idUser_idx` (`idUser`),
  KEY `idDpto_idx` (`idDpto`),
  CONSTRAINT `idUser--per` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`),
  CONSTRAINT `idDpto` FOREIGN KEY (`idDpto`) REFERENCES `departamentos` (`idDpto`)
);


INSERT INTO roles VALUES
("1","superAdmin"),
("2","admin"),
("3","solic");


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
("21","MANTENIMIENTO DE EQUIPO");
