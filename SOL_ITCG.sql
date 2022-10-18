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

CREATE TABLE `users` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `token` varchar(250) NOT NULL,
  `nomUsuario` varchar(60) NOT NULL,
  `apellidoUsuario` varchar(60) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `edoUser` varchar(40) NOT NULL,
  `idRole` int(4) NOT NULL,
  `idDpto` int(4) NOT NULL,
  KEY `idRole_idx` (`idRole`),
  KEY `idDpto_idx` (`idDpto`),
  CONSTRAINT `idRole--us` FOREIGN KEY (`idRole`) REFERENCES `roles` (`idRole`),
  CONSTRAINT `idDptoAC` FOREIGN KEY (`idDpto`) REFERENCES `departamentos` (`idDpto`),
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

CREATE TABLE `solicitudes` (
  `idSolicitud` int(11) NOT NULL AUTO_INCREMENT,
  `idUser` int(4) NOT NULL,
  `idDpto` int(4) NOT NULL,
  `folio`  int(12) NOT NULL,
  `fecha`  DATE  NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `observacion` varchar(255) DEFAULT NULL,
  `Etapa` varchar(25) NOT NULL,
  `Prioridad` varchar(25) NOT NULL,
  `Estado` varchar(25) NOT NULL,
  KEY `idUser_idx` (`idUser`),
  KEY `idDpto_idx` (`idDpto`),
  CONSTRAINT `idUser` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`),
  CONSTRAINT `idDpto` FOREIGN KEY (`idDpto`) REFERENCES `departamentos` (`idDpto`),
  PRIMARY KEY (`idSolicitud`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

CREATE TABLE `fallas` (
  `idFalla` int(4) NOT NULL,
  `nomFalla` varchar(180) NOT NULL,
  PRIMARY KEY (`idFalla`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `detalles` (
  `idSolicitud` int(4) NOT NULL,
  `idFalla` int(4) NOT NULL,
  KEY `idSolicitud_idx` (`idSolicitud`),
  KEY `idFalla_idx` (`idFalla`),
  CONSTRAINT `idSolicitud` FOREIGN KEY (`idSolicitud`) REFERENCES `solicitudes` (`idSolicitud`),
  CONSTRAINT `idFalla` FOREIGN KEY (`idFalla`) REFERENCES `fallas` (`idFalla`)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



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
("22",'SUBDIRECCIÓN DE SERVICIOS ADMINISTRATIVOS'),
("23",'SUBDIRECCIÓN ACADÉMICA'),
("24",'SUBDIRECCIÓN DE PLANEACIÓN Y VINCULACIÓN'),
("25",'DIRECCIÓN');

INSERT INTO `fallas` (`idFalla`, `nomFalla`) VALUES
(1, 'En internet'),
(2, 'Imprimir'),
(3, 'Office (Word, Access, PowerPoint)'),
(4, 'Virus'),
(5, 'Software propio (Sie, Siatec, Siabug, Control de Asistencias, Ficha de Depósito, Control de Acceso a Biblioteca, Buzon de Quejas, Contpaq, Sii, Sahir, Siasep, etc).'),
(6, 'Mal funcionamiento del equipo'),
(7, 'Otra falla'),
(8, 'Mantenimiento eléctrico '),
(9, 'Mantenimiento hidráulico'),
(10, 'Mantenimiento sanitario'),
(11, 'Mantenimiento de vidrios y aluminios'),
(12, 'Mantenimiento de albañilería'),
(13, 'Mantenimiento de pintura'),
(14, 'Mantenimiento de impermeabilizantes'),
(15, 'Mantenimiento de herrería');

-- edouser y HABILITADO INHABILITADO , 'HABILITADO',  , 

INSERT INTO `users` (`idUser`, `email`, `token`, `nomUsuario`, `apellidoUsuario`, `telefono`, `edoUser`, `idRole`, `idDpto` ) VALUES
(1, 'L18290915@cdguzman.tecnm.mx', '$2y$10$Lfue7TaXi6y2Du3vohvdeOA5I1Qbjvrrbs98KatyfjPESXpdsEEZ.', 'David', 'Ojeda Cortes', '3421080534', 'HABILITADO', 1 , 20),   
(2, 'l18290817@cdguzman.tecnm.mx', '$2y$10$iW1o028yrwlFDyhgrR2E6ORmUp88eHO9ALs3DXG0qYdViCux5uNR2', 'Adrian', 'Perez Martinez', '3213121231', 'HABILITADO',  2, 1),
(3, '2313@cdguzman.tecnm.mx', '$2y$10$u4CBUxz9N7sbPQ1nnUryOeBIPfH40aDJxijvsJxbK.x9ErhZF1COK', 'Anahi', 'Gutierres Saldana', '2132131231', 'HABILITADO',  3, 24),
(4, '1322114@cdguzman.tecnm.mx', '$2y$10$Wh3INsa7cuKAr/UbXpA9iOnOcp0DWn.wSWKuQR4qt9FSC5DPdrFLi', 'Sergio', 'Lopez Cortes', '0', 'HABILITADO',  2, 17),
(5, 'sadasdas@cdguzman.tecnm.mx', '$2y$10$ALEl64jCFtM.f9vFL6ZUPOZ0om9sCYACxEblh307yfpYlhEyy6C7G', 'Alberto', 'Gutierres Castillo', '0', 'HABILITADO',  2, 1),
(6, 'fdsfdsfsd@cdguzman.tecnm.mx', '$2y$10$2Ru5.PXCRlRTujjk/VlDIudONBuY9YydCC4eD9whAtOhGMz4qHlma', 'Nestor', 'Saldana Martinez', '3213121231', 'HABILITADO',  3, 1),
(7, 'adasdasd@cdguzman.tecnm.mx', '$2y$10$J0VVVUjaoprAKJV5L/zsRechSMkKBtejLyTg0E0mgFEGegcPIl9pO', 'Jenefer', 'Yakitori Castillo', '0', 'HABILITADO',  3, 2),
(8, 'flores@cdguzman.tecnm.mx', '$2y$10$aSZ7.1GFeXA.vqWLwwNE3udpKaa89QI1qI1Qxv2zzKJwGaQiZte9K', 'Natalia', 'Flores Lopez', '2132131231', 'HABILITADO',  2, 18),
(9, 'Paulina@cdguzman.tecnm.mx', '$2y$10$ksTEdZQFMOzYJTgUaURIieKJt2unHqlOOBDmspwF1ubg/1.UDjGHy', 'Paulina', 'Martinez Cruz', '0', 'HABILITADO',  2, 15),
(10, 'Sabina@cdguzman.tecnm.mx', '$2y$10$XNqw9wdp23aOpb1FuPZX1O0SLEIKW8g9yI0c/v5nIrELeCXd4sJxW', 'Sabina', 'Sabina Montes', '0', 'HABILITADO',  3, 14),
(11, 'Alberto@cdguzman.tecnm.mx', '$2y$10$Ja1D8WWfYb47OGKvoSJfLeFQoyaWwwQpMUWEjXRu4SvmxErYHALd6', 'Alberto', 'Castillo Flores', '0', 'HABILITADO',  3, 13),
(12, 'Anahi@cdguzman.tecnm.mx', '$2y$10$bhUEd.cSeCeyNm3NxYOrQ.5FJZ6yja79EEQ4taIhUHXJzSpWeUuw.', 'Anahi', 'Montes Montes', '2132131231', 'HABILITADO',  2, 12),
(13, 'David@cdguzman.tecnm.mx', '$2y$10$xV2oG2k/92pLYbiwZqG2uu33ZpNV6RO.O0UR0uZ55rmgav3nUNkBi', 'David', 'Vasquez Ojeda', '0', 'HABILITADO',  2, 2),
(14, 'Nestords@cdguzman.tecnm.mx', '$2y$10$pe5QGsGfGHdvmEvQlqnReOY1XcDqVOo/HqDa0R1NG2GU3HfF7qKbC', 'Nestor', 'Vasquez Castillo', '3213121231', 'HABILITADO',  2, 8),
(15, 'Alexius@cdguzman.tecnm.mx', '$2y$10$VU/npV.HB/QjjC.gYqiHw.zMjsrxFlAS0eJgpiA8JwcYN5DdS6I4e', 'Alexius', 'Martinez Castillo', '0', 'HABILITADO',  3, 7),
(16, 'Sabinassd@cdguzman.tecnm.mx', '$2y$10$9Bc.Rp/GSbylEev0meD0/.HTOINJuxy3F8wXqZHzhl7Qvn/6xqi66', 'Sabina', 'Vasquez Montes', '0', 'HABILITADO',  2, 12),
(17, 'Fatima321@cdguzman.tecnm.mx', '$2y$10$y80gl2EkQpvt/XswgGG7cusFmtZdFRFI60D3Tq8dYylMQeteZwIve', 'Fatima', 'Cortes Cruz', '0', 'HABILITADO',  2, 9),
(18, 'Sandraasa@cdguzman.tecnm.mx', '$2y$10$EP3m9lm8sSLN248DyMlXE..KeLxqt4WmXPsP76NJL2Q4.4lFQYteu', 'Sandra', 'Cruz Montes', '0', 'HABILITADO',  3, 10),
(19, 'Alexiusas@cdguzman.tecnm.mx', '$2y$10$PtP9fRslYpmXEhu0eUKLBeRxOnN1xP6lGiaIn8o3dvoFkXXWwLpPG', 'Alexius', 'Martinez Montes', '2132131231', 'HABILITADO',  2, 23),
(20, 'Guillermoas@cdguzman.tecnm.mx', '$2y$10$Hvt39L8FwKpo4ZO.9104sOdOLR0z0AKl32IuibgbjHsNbqaB0GP5u', 'Guillermo', 'Estrada Martinez', '2132131231', 'HABILITADO',  2, 10),
(21, 'JeneferA@cdguzman.tecnm.mx', '$2y$10$cM4OVQ1eLLK6M7mLONTw8eXoPn7yKxCJwA8OVjLHGVoqjVhuvWGm2', 'Jenefer', 'Montes Lugo', '3213121231', 'HABILITADO',  2, 23),
(22, 'Sergioas@cdguzman.tecnm.mx', '$2y$10$.ko.wwbWQXrtLIZAoJm02OOzLp5TtptLVcd5Wq1bX6moi5S4fyNUK', 'Sergio', 'Meza Martinez', '2132131231', 'HABILITADO',  2, 15),
(23, 'Fatima2@cdguzman.tecnm.mx', '$2y$10$2y7N9kZW4cWE1d8i.ni6teqHQrJczOd0DYkdA1jlWltmi9JjB1IAy', 'Fatima', 'Martinez Castillo', '3213121231', 'HABILITADO',  3, 24),
(24, 'Sandra@cdguzman.tecnm.mx', '$2y$10$P2swA.cByvYGww6HRmFaHeQT0.IH.ETgh/FS.EINT19P6Wc8g..s2', 'Sandra', 'Montes Estrada', '2132131231', 'HABILITADO',  3, 23),
(25, 'Sara1@cdguzman.tecnm.mx', '$2y$10$vGhoklZhhTfLGLNz69C6MuqY8/.Qwd4NGcHsPMActV2u5h9/6SNhm', 'Sara', 'Montes Perez', '2132131231', 'HABILITADO',  2, 2),
(26, 'Natalia213@cdguzman.tecnm.mx', '$2y$10$l96g/iztnPmrDYiQkywJm.dpRLiKhxoISxuaqTQTieFcOl/Ns3S1O', 'Natalia', 'Martinez Flores', '3213121231', 'HABILITADO',  2, 7),
(27, 'Saraasds@cdguzman.tecnm.mx', '$2y$10$TgbEiF87Eu3jYtlHgi1YxuYmKDrj5G82u573.7onbZoscqNuyt8Z.', 'Sara', 'Castillo Lopez', '0', 'HABILITADO',  3, 2),
(28, 'Sandra2313@cdguzman.tecnm.mx', '$2y$10$R5NoiG6xZ4SHJ1JmKiNN1.EIRPoEimboxoTi3gdUWaLDU48/jNxVW', 'Sandra', 'Martinez Yakitori', '2132131231', 'HABILITADO',  2, 2),
(29, 'Natalia23213@cdguzman.tecnm.mx', '$2y$10$3Eipc1q0EjUDYavAm9reROkTd2QMBEDT04oTLDG7DgIRSNKMDdN1u', 'Natalia', 'Castillo Estrada', '2314132143', 'HABILITADO',  2, 16),
(30, 'Jenefer1s@cdguzman.tecnm.mx', '$2y$10$nQFBYLLDfrd.nvEeWULgF.I6CWpbip/v57Z0VJNL3Gwer56FFamIS', 'Jenefer', 'Martinez Lopez', '2213213123', 'HABILITADO',  3, 15),
(31, 'Antonio213@cdguzman.tecnm.mx', '$2y$10$gDpY5XDuLpj91KXmv93WpOqcnX0Pbc7rPUkSyy4JOySWBLyB9cqjK', 'Antonio', 'Castillo Castillo', '2314132143', 'HABILITADO',  2, 19),
(32, 'Estanislao121@cdguzman.tecnm.mx', '$2y$10$KHR0CjEahqGmSeqg6lXe.OoWuVwsUbHuGDwTHy/03Bj.rs0UkBtZa', 'Estanislao', 'Flores Perez', '2132131231', 'HABILITADO',  3, 1),
(33, 'Nestor23@cdguzman.tecnm.mx', '$2y$10$AlPD7fJpCxN84nrKw5IK.ujbGIluKW0cRk79rp.yUYM2xhHM5B0s2', 'Nestor', 'Flores Lugo', '3213121231', 'HABILITADO',  2, 19),
(34, 'Alexius23@cdguzman.tecnm.mx', '$2y$10$8TNNn6NpAr1kWMAUKp7GDOuwZZGNjdz9U4AIy0I7s/2B9jZ0AeVte', 'Alexius', 'Montes Flores', '3213121231', 'HABILITADO',  3, 9),
(35, 'Jenefer323@cdguzman.tecnm.mx', '$2y$10$F5C/Pum378MiDMUfZUKuNuNu.K0ERlmz4glr500Wyzrof3nxZ./CC', 'Jenefer', 'Castillo Lopez', '2132131231', 'HABILITADO',  2, 7),
(36, 'Sergioddfs@cdguzman.tecnm.mx', '$2y$10$SmbSim2rMhnjtkRlVVmcT.JFa6OK4.J/Re0ARh6MYi6AWeztYkrAC', 'Sergio', 'Martinez Yakitori', '3213121231', 'HABILITADO',  2, 7),
(37, 'Sandradsdasd@cdguzman.tecnm.mx', '$2y$10$LlOitUCDKoiCXqRWU0OOyueViManXx7tlxR9tiCpSaL3sILm9cmc2', 'Sandra', 'Montes Ojeda', '3213121231', 'HABILITADO',  2, 3),
(38, 'Monserrat@cdguzman.tecnm.mx', '$2y$10$QknwQ2KFSU/7JVqrTxw/Mu/EMBt41PWBQuZZ8ch6jVuFUXgljWXvW', 'Monserrat', 'Lopez Cortes', '3213121231', 'HABILITADO',  3, 3),
(39, 'Jenefersa@cdguzman.tecnm.mx', '$2y$10$/0UGuePZY5EdzyVXv2xpqeJ3DKH0i0rosoL.KWSt5lHD/9qekxbnm', 'Jenefer', 'Montes Saldana', '2314132143', 'HABILITADO',  3, 3),
(40, 'Alberto213@cdguzman.tecnm.mx', '$2y$10$vryYi2qJhuomGIPeD/uXE./9JzWZpkGYmhFrDSgFA.Vn8Ud/1gIRm', 'Alberto', 'Lopez Lugo', '3213121231', 'HABILITADO',  3, 5),
(41, 'Oscarsad@cdguzman.tecnm.mx', '$2y$10$hHXYzWylGYhs/jtR8JIifOwPW2iUfL1KnXaPtrA35G1d7MAqsuB/C', 'Oscar', 'Saldana Lopez', '2312332131', 'HABILITADO',  2, 5),
(42, 'Nataliasdsad@cdguzman.tecnm.mx', '$2y$10$3IEOs9Fn.BE3UePHZAfMNedxHQBU72STdG8iicklhINa2qiMtSxzu', 'Natalia', 'Martinez Perez', '3213123123', 'HABILITADO',  2, 22),
(43, 'David2321@cdguzman.tecnm.mx', '$2y$10$7FZNX38MCU8jOFkjAmwbb.OVPRZXaV7.Lml.knzCWLUKOhW9.O8.y', 'David', 'Martinez Saldana', '2213213123', 'HABILITADO',  2, 21),
(44, 'Alberto21@cdguzman.tecnm.mx', '$2y$10$6gWOjf3vhlWOheN5lpOT6ekEKHpPTQCV1kPPSZhl/8b2Be/A8gOzy', 'Alberto', 'Lopez Montes', '2321312321', 'HABILITADO',  3, 21),
(45, 'Sergio123@cdguzman.tecnm.mx', '$2y$10$Oa/fAAKjeeciO3JQ.WdKb.M7/EhuF/I2ysGRLYBQnOA/X90mWA5Fi', 'Sergio', 'Montes Cortes', '2314132143', 'HABILITADO',  3, 10),
(46, 'Manuel12@cdguzman.tecnm.mx', '$2y$10$8tZeMMoYK4Q2pvCWdA3Nee9/.dQUY4c6YcEfwwf9.hzR646rp1h22', 'Manuel', 'Meza Saldana', '2312312321', 'HABILITADO',  3, 11),
(47, 'Manuel2321@cdguzman.tecnm.mx', '$2y$10$Vdaat59lLy0Brz/5yWvJKe/I7CY4SyFfwAd4eHOSWEHqPcn64/Ey.', 'Manuel', 'Montes Yakitori', '2314132143', 'HABILITADO',  2, 12),
(48, 'Fatima23213@cdguzman.tecnm.mx', '$2y$10$Ywrt3hO08ZToV0ijq2.YRO6VzeZzjvcEnaDayHltbXwZxgkj7/zqm', 'Fatima', 'Lopez Flores', '3213121231', 'HABILITADO',  2, 11),
(49, 'Nestor32@cdguzman.tecnm.mx', '$2y$10$II6uBkdhlNEExhTTb1dzXOuBlaq4vs9qouddUMr2CpFsEyc2h0TZm', 'Nestor', 'Lopez Cortes', '2132131231', 'HABILITADO',  3, 25),
(50, 'Rubi@cdguzman.tecnm.mx', '$2y$10$t62QVVBD.znrTXMViXTT0.Y7T5R4/9v47gHmWkPVa0DEKIEdvogty', 'Rubi', 'Cuevas Maria', '2314132143', 'HABILITADO',  2, 10);




--
--
--

