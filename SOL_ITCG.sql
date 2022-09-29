-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3307
-- Tiempo de generación: 23-09-2022 a las 00:10:13
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sol_itcg`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accesos`
--

CREATE TABLE `accesos` (
  `idUser` int(4) DEFAULT NULL,
  `idRole` int(4) DEFAULT NULL,
  `idDpto` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `accesos`
--

INSERT INTO `accesos` (`idUser`, `idRole`, `idDpto`) VALUES
(1, 1, 20),
(2, 2, 9),
(3, 3, 15),
(4, 2, 16),
(5, 3, 18),
(6, 2, 21),
(7, 3, 2),
(8, 2, 18),
(9, 2, 20),
(10, 3, 16),
(11, 3, 17),
(12, 2, 17),
(13, 2, 21),
(14, 2, 4),
(15, 2, 17),
(16, 2, 16),
(17, 2, 17),
(18, 2, 21),
(19, 2, 3),
(20, 2, 17),
(21, 2, 20),
(22, 2, 3),
(23, 3, 17),
(24, 2, 18),
(25, 2, 2),
(26, 2, 21),
(27, 2, 17),
(28, 2, 19),
(29, 2, 19),
(30, 2, 15),
(31, 3, 12),
(32, 3, 18),
(33, 2, 18),
(34, 2, 20),
(35, 2, 8),
(36, 3, 3),
(37, 2, 21),
(38, 2, 17),
(39, 3, 17),
(40, 2, 9),
(41, 3, 17),
(42, 3, 18),
(43, 3, 3),
(44, 2, 18),
(45, 2, 17),
(46, 2, 1),
(47, 2, 17),
(48, 2, 20),
(49, 2, 20),
(50, 2, 3),
(51, 2, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `idDpto` int(4) NOT NULL,
  `nomDpto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`idDpto`, `nomDpto`) VALUES
(1, 'PLANEACIÓN, PROGRAMACIÓN Y PRESUPUESTACIÓN'),
(2, 'GESTIÓN TECNOLÓGICA Y VINCULACIÓN'),
(3, 'COMUNICACIÓN Y DIFUSIÓN'),
(4, 'ACTIVIDADES EXTRAESCOLARES'),
(5, 'SERVICIOS ESCOLARES'),
(6, 'CENTRO DE INFORMACIÓN'),
(7, 'CIENCIAS BÁSICAS'),
(8, 'SISTEMAS Y COMPUTACIÓN'),
(9, 'METAL – MECÁNICA'),
(10, 'CIENCIAS DE LA TIERRA'),
(11, 'INGENIERÍA INDUSTRIAL'),
(12, 'INGENIERÍA ELÉCTRICA Y ELECTRÓNICA'),
(13, 'CIENCIAS ECONÓMICO – ADMINISTRATIVAS'),
(14, 'DESARROLLO ACADÉMICO'),
(15, 'DIVISIÓN DE ESTUDIOS PROFESIONALES'),
(16, 'DIVISIÓN DE ESTUDIOS DE POSGRADO E INVESTIGACIÓN'),
(17, 'RECURSOS HUMANOS'),
(18, 'RECURSOS FINANCIEROS'),
(19, 'RECURSOS MATERIALES Y SERVICIOS'),
(20, 'CENTRO DE CÓMPUTO'),
(21, 'MANTENIMIENTO DE EQUIPO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idRole` int(4) NOT NULL,
  `nomRole` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`idRole`, `nomRole`) VALUES
(1, 'superAdmin'),
(2, 'admin'),
(3, 'solic');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `idUser` int(11) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `token` varchar(250) DEFAULT NULL,
  `nomUsuario` varchar(60) DEFAULT NULL,
  `apellidoUsuario` varchar(60) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `idRole` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`idUser`, `email`, `token`, `nomUsuario`, `apellidoUsuario`, `telefono`, `idRole`) VALUES
(1, 'L18290915@cdguzman.tecnm.mx', '$2y$10$Lfue7TaXi6y2Du3vohvdeOA5I1Qbjvrrbs98KatyfjPESXpdsEEZ.', 'David', 'Ojeda Cortes', '3421080534', 1),
(2, 'l18290817@cdguzman.tecnm.mx', '$2y$10$iW1o028yrwlFDyhgrR2E6ORmUp88eHO9ALs3DXG0qYdViCux5uNR2', 'Adrian', 'Perez Martinez', '3213121231', 2),
(3, '2313@cdguzman.tecnm.mx', '$2y$10$u4CBUxz9N7sbPQ1nnUryOeBIPfH40aDJxijvsJxbK.x9ErhZF1COK', 'Anahi', 'Gutierres Saldana', '2132131231', 3),
(4, '1322114@cdguzman.tecnm.mx', '$2y$10$Wh3INsa7cuKAr/UbXpA9iOnOcp0DWn.wSWKuQR4qt9FSC5DPdrFLi', 'Sergio', 'Lopez Cortes', '0', 2),
(5, 'sadasdas@cdguzman.tecnm.mx', '$2y$10$ALEl64jCFtM.f9vFL6ZUPOZ0om9sCYACxEblh307yfpYlhEyy6C7G', 'Alberto', 'Gutierres Castillo', '0', 3),
(6, 'fdsfdsfsd@cdguzman.tecnm.mx', '$2y$10$2Ru5.PXCRlRTujjk/VlDIudONBuY9YydCC4eD9whAtOhGMz4qHlma', 'Nestor', 'Saldana Martinez', '3213121231', 2),
(7, 'adasdasd@cdguzman.tecnm.mx', '$2y$10$J0VVVUjaoprAKJV5L/zsRechSMkKBtejLyTg0E0mgFEGegcPIl9pO', 'Jenefer', 'Yakitori Castillo', '0', 3),
(8, 'flores@cdguzman.tecnm.mx', '$2y$10$aSZ7.1GFeXA.vqWLwwNE3udpKaa89QI1qI1Qxv2zzKJwGaQiZte9K', 'Natalia', 'Flores Lopez', '2132131231', 2),
(9, 'Paulina@cdguzman.tecnm.mx', '$2y$10$ksTEdZQFMOzYJTgUaURIieKJt2unHqlOOBDmspwF1ubg/1.UDjGHy', 'Paulina', 'Martinez Cruz', '0', 2),
(10, 'Sabina@cdguzman.tecnm.mx', '$2y$10$XNqw9wdp23aOpb1FuPZX1O0SLEIKW8g9yI0c/v5nIrELeCXd4sJxW', 'Sabina', 'Sabina Montes', '0', 3),
(11, 'Alberto@cdguzman.tecnm.mx', '$2y$10$Ja1D8WWfYb47OGKvoSJfLeFQoyaWwwQpMUWEjXRu4SvmxErYHALd6', 'Alberto', 'Castillo Flores', '0', 3),
(12, 'Anahi@cdguzman.tecnm.mx', '$2y$10$bhUEd.cSeCeyNm3NxYOrQ.5FJZ6yja79EEQ4taIhUHXJzSpWeUuw.', 'Anahi', 'Montes Montes', '2132131231', 2),
(13, 'David@cdguzman.tecnm.mx', '$2y$10$xV2oG2k/92pLYbiwZqG2uu33ZpNV6RO.O0UR0uZ55rmgav3nUNkBi', 'David', 'Vasquez Ojeda', '0', 2),
(14, 'Nestords@cdguzman.tecnm.mx', '$2y$10$pe5QGsGfGHdvmEvQlqnReOY1XcDqVOo/HqDa0R1NG2GU3HfF7qKbC', 'Nestor', 'Vasquez Castillo', '3213121231', 2),
(15, 'Alexius@cdguzman.tecnm.mx', '$2y$10$VU/npV.HB/QjjC.gYqiHw.zMjsrxFlAS0eJgpiA8JwcYN5DdS6I4e', 'Alexius', 'Martinez Castillo', '0', 2),
(16, 'Sabinassd@cdguzman.tecnm.mx', '$2y$10$9Bc.Rp/GSbylEev0meD0/.HTOINJuxy3F8wXqZHzhl7Qvn/6xqi66', 'Sabina', 'Vasquez Montes', '0', 2),
(17, 'Fatima321@cdguzman.tecnm.mx', '$2y$10$y80gl2EkQpvt/XswgGG7cusFmtZdFRFI60D3Tq8dYylMQeteZwIve', 'Fatima', 'Cortes Cruz', '0', 2),
(18, 'Sandraasa@cdguzman.tecnm.mx', '$2y$10$EP3m9lm8sSLN248DyMlXE..KeLxqt4WmXPsP76NJL2Q4.4lFQYteu', 'Sandra', 'Cruz Montes', '0', 2),
(19, 'Alexiusas@cdguzman.tecnm.mx', '$2y$10$PtP9fRslYpmXEhu0eUKLBeRxOnN1xP6lGiaIn8o3dvoFkXXWwLpPG', 'Alexius', 'Martinez Montes', '2132131231', 2),
(20, 'Guillermoas@cdguzman.tecnm.mx', '$2y$10$Hvt39L8FwKpo4ZO.9104sOdOLR0z0AKl32IuibgbjHsNbqaB0GP5u', 'Guillermo', 'Estrada Martinez', '2132131231', 2),
(21, 'JeneferA@cdguzman.tecnm.mx', '$2y$10$cM4OVQ1eLLK6M7mLONTw8eXoPn7yKxCJwA8OVjLHGVoqjVhuvWGm2', 'Jenefer', 'Montes Lugo', '3213121231', 2),
(22, 'Sergioas@cdguzman.tecnm.mx', '$2y$10$.ko.wwbWQXrtLIZAoJm02OOzLp5TtptLVcd5Wq1bX6moi5S4fyNUK', 'Sergio', 'Meza Martinez', '2132131231', 2),
(23, 'Fatima2@cdguzman.tecnm.mx', '$2y$10$2y7N9kZW4cWE1d8i.ni6teqHQrJczOd0DYkdA1jlWltmi9JjB1IAy', 'Fatima', 'Martinez Castillo', '3213121231', 3),
(24, 'Sandra@cdguzman.tecnm.mx', '$2y$10$P2swA.cByvYGww6HRmFaHeQT0.IH.ETgh/FS.EINT19P6Wc8g..s2', 'Sandra', 'Montes Estrada', '2132131231', 2),
(25, 'Sara1@cdguzman.tecnm.mx', '$2y$10$vGhoklZhhTfLGLNz69C6MuqY8/.Qwd4NGcHsPMActV2u5h9/6SNhm', 'Sara', 'Montes Perez', '2132131231', 2),
(26, 'Natalia213@cdguzman.tecnm.mx', '$2y$10$l96g/iztnPmrDYiQkywJm.dpRLiKhxoISxuaqTQTieFcOl/Ns3S1O', 'Natalia', 'Martinez Flores', '3213121231', 2),
(27, 'Saraasds@cdguzman.tecnm.mx', '$2y$10$TgbEiF87Eu3jYtlHgi1YxuYmKDrj5G82u573.7onbZoscqNuyt8Z.', 'Sara', 'Castillo Lopez', '0', 2),
(28, 'Sandra2313@cdguzman.tecnm.mx', '$2y$10$R5NoiG6xZ4SHJ1JmKiNN1.EIRPoEimboxoTi3gdUWaLDU48/jNxVW', 'Sandra', 'Martinez Yakitori', '2132131231', 2),
(29, 'Natalia23213@cdguzman.tecnm.mx', '$2y$10$3Eipc1q0EjUDYavAm9reROkTd2QMBEDT04oTLDG7DgIRSNKMDdN1u', 'Natalia', 'Castillo Estrada', '2314132143', 2),
(30, 'Jenefer1s@cdguzman.tecnm.mx', '$2y$10$nQFBYLLDfrd.nvEeWULgF.I6CWpbip/v57Z0VJNL3Gwer56FFamIS', 'Jenefer', 'Martinez Lopez', '2213213123', 2),
(31, 'Antonio213@cdguzman.tecnm.mx', '$2y$10$gDpY5XDuLpj91KXmv93WpOqcnX0Pbc7rPUkSyy4JOySWBLyB9cqjK', 'Antonio', 'Castillo Castillo', '2314132143', 3),
(32, 'Estanislao121@cdguzman.tecnm.mx', '$2y$10$KHR0CjEahqGmSeqg6lXe.OoWuVwsUbHuGDwTHy/03Bj.rs0UkBtZa', 'Estanislao', 'Flores Perez', '2132131231', 3),
(33, 'Nestor23@cdguzman.tecnm.mx', '$2y$10$AlPD7fJpCxN84nrKw5IK.ujbGIluKW0cRk79rp.yUYM2xhHM5B0s2', 'Nestor', 'Flores Lugo', '3213121231', 2),
(34, 'Alexius23@cdguzman.tecnm.mx', '$2y$10$8TNNn6NpAr1kWMAUKp7GDOuwZZGNjdz9U4AIy0I7s/2B9jZ0AeVte', 'Alexius', 'Montes Flores', '3213121231', 2),
(35, 'Jenefer323@cdguzman.tecnm.mx', '$2y$10$F5C/Pum378MiDMUfZUKuNuNu.K0ERlmz4glr500Wyzrof3nxZ./CC', 'Jenefer', 'Castillo Lopez', '2132131231', 2),
(36, 'Sergioddfs@cdguzman.tecnm.mx', '$2y$10$SmbSim2rMhnjtkRlVVmcT.JFa6OK4.J/Re0ARh6MYi6AWeztYkrAC', 'Sergio', 'Martinez Yakitori', '3213121231', 3),
(37, 'Sandradsdasd@cdguzman.tecnm.mx', '$2y$10$LlOitUCDKoiCXqRWU0OOyueViManXx7tlxR9tiCpSaL3sILm9cmc2', 'Sandra', 'Montes Ojeda', '3213121231', 2),
(38, 'Monserrat@cdguzman.tecnm.mx', '$2y$10$QknwQ2KFSU/7JVqrTxw/Mu/EMBt41PWBQuZZ8ch6jVuFUXgljWXvW', 'Monserrat', 'Lopez Cortes', '3213121231', 2),
(39, 'Jenefersa@cdguzman.tecnm.mx', '$2y$10$/0UGuePZY5EdzyVXv2xpqeJ3DKH0i0rosoL.KWSt5lHD/9qekxbnm', 'Jenefer', 'Montes Saldana', '2314132143', 3),
(40, 'Alberto213@cdguzman.tecnm.mx', '$2y$10$vryYi2qJhuomGIPeD/uXE./9JzWZpkGYmhFrDSgFA.Vn8Ud/1gIRm', 'Alberto', 'Lopez Lugo', '3213121231', 2),
(41, 'Oscarsad@cdguzman.tecnm.mx', '$2y$10$hHXYzWylGYhs/jtR8JIifOwPW2iUfL1KnXaPtrA35G1d7MAqsuB/C', 'Oscar', 'Saldana Lopez', '2312332131', 3),
(42, 'Nataliasdsad@cdguzman.tecnm.mx', '$2y$10$3IEOs9Fn.BE3UePHZAfMNedxHQBU72STdG8iicklhINa2qiMtSxzu', 'Natalia', 'Martinez Perez', '3213123123', 3),
(43, 'David2321@cdguzman.tecnm.mx', '$2y$10$7FZNX38MCU8jOFkjAmwbb.OVPRZXaV7.Lml.knzCWLUKOhW9.O8.y', 'David', 'Martinez Saldana', '2213213123', 3),
(44, 'Alberto21@cdguzman.tecnm.mx', '$2y$10$6gWOjf3vhlWOheN5lpOT6ekEKHpPTQCV1kPPSZhl/8b2Be/A8gOzy', 'Alberto', 'Lopez Montes', '2321312321', 2),
(45, 'Sergio123@cdguzman.tecnm.mx', '$2y$10$Oa/fAAKjeeciO3JQ.WdKb.M7/EhuF/I2ysGRLYBQnOA/X90mWA5Fi', 'Sergio', 'Montes Cortes', '2314132143', 2),
(46, 'Manuel12@cdguzman.tecnm.mx', '$2y$10$8tZeMMoYK4Q2pvCWdA3Nee9/.dQUY4c6YcEfwwf9.hzR646rp1h22', 'Manuel', 'Meza Saldana', '2312312321', 2),
(47, 'Manuel2321@cdguzman.tecnm.mx', '$2y$10$Vdaat59lLy0Brz/5yWvJKe/I7CY4SyFfwAd4eHOSWEHqPcn64/Ey.', 'Manuel', 'Montes Yakitori', '2314132143', 2),
(48, 'Fatima23213@cdguzman.tecnm.mx', '$2y$10$Ywrt3hO08ZToV0ijq2.YRO6VzeZzjvcEnaDayHltbXwZxgkj7/zqm', 'Fatima', 'Lopez Flores', '3213121231', 2),
(49, 'Nestor32@cdguzman.tecnm.mx', '$2y$10$II6uBkdhlNEExhTTb1dzXOuBlaq4vs9qouddUMr2CpFsEyc2h0TZm', 'Nestor', 'Lopez Cortes', '2132131231', 2),
(50, 'Rubi@cdguzman.tecnm.mx', '$2y$10$t62QVVBD.znrTXMViXTT0.Y7T5R4/9v47gHmWkPVa0DEKIEdvogty', 'Rubi', 'Cuevas Maria', '2314132143', 2),
(51, 'L18290816@cdguzman.tecnm.mx', '$2y$10$IpWyzWNoReHvw0eEHsT2BeHUnHbN8wSw501Tv9BxvHLehbdDlmjvG', 'David', 'Lopez Ojeda', '0', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accesos`
--
ALTER TABLE `accesos`
  ADD KEY `idUser_idx` (`idUser`),
  ADD KEY `idRole_idx` (`idRole`),
  ADD KEY `idDpto_idx` (`idDpto`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`idDpto`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idRole`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD KEY `idRole_idx` (`idRole`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `accesos`
--
ALTER TABLE `accesos`
  ADD CONSTRAINT `idDpto` FOREIGN KEY (`idDpto`) REFERENCES `departamentos` (`idDpto`),
  ADD CONSTRAINT `idRole` FOREIGN KEY (`idRole`) REFERENCES `roles` (`idRole`),
  ADD CONSTRAINT `idUser` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `idRole--us` FOREIGN KEY (`idRole`) REFERENCES `roles` (`idRole`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
