-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-10-2021 a las 09:53:31
-- Versión del servidor: 10.4.6-MariaDB-log
-- Versión de PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gimnas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clients`
--

CREATE TABLE `clients` (
  `idclient` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `llinatges` varchar(50) NOT NULL,
  `telefon` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `clients`
--

INSERT INTO `clients` (`idclient`, `nom`, `llinatges`, `telefon`) VALUES
(1, 'Miquel', 'Mir', '632452314'),
(2, 'Joana', 'Pons', '656998877'),
(3, 'Laura ', 'Gonzalez', '696568423');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pistes`
--

CREATE TABLE `pistes` (
  `idpista` int(11) NOT NULL,
  `tipo` enum('Coberta','Exterior','','') NOT NULL,
  `preu` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pistes`
--

INSERT INTO `pistes` (`idpista`, `tipo`, `preu`) VALUES
(1, 'Coberta', 12),
(2, 'Exterior', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserves`
--

CREATE TABLE `reserves` (
  `data` datetime NOT NULL,
  `idpista` int(11) NOT NULL,
  `idclient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `reserves`
--

INSERT INTO `reserves` (`data`, `idpista`, `idclient`) VALUES
('2021-11-04 16:00:00', 2, 1),
('2021-11-22 15:00:00', 1, 1),
('2021-10-20 18:00:00', 2, 2),
('2021-11-01 19:00:00', 1, 2),
('2021-10-20 18:00:00', 1, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`idclient`);

--
-- Indices de la tabla `pistes`
--
ALTER TABLE `pistes`
  ADD PRIMARY KEY (`idpista`);

--
-- Indices de la tabla `reserves`
--
ALTER TABLE `reserves`
  ADD PRIMARY KEY (`data`,`idpista`),
  ADD KEY `idclient` (`idclient`),
  ADD KEY `idpista` (`idpista`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clients`
--
ALTER TABLE `clients`
  MODIFY `idclient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pistes`
--
ALTER TABLE `pistes`
  MODIFY `idpista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `reserves`
--
ALTER TABLE `reserves`
  ADD CONSTRAINT `reserves_ibfk_1` FOREIGN KEY (`idclient`) REFERENCES `clients` (`idclient`),
  ADD CONSTRAINT `reserves_ibfk_2` FOREIGN KEY (`idpista`) REFERENCES `pistes` (`idpista`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
