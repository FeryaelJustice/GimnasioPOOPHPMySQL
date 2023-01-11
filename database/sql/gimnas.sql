SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

DROP DATABASE if EXISTS gimnaspoo;
CREATE DATABASE gimnaspoo;
USE gimnaspoo;

CREATE TABLE `usuaris` (
  `idusuari` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `llinatges` varchar(50) NOT NULL,
  `telefon` varchar(12) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` VARCHAR(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuaris`
--

INSERT INTO `usuaris` (`idusuari`, `nom`, `llinatges`, `telefon`, `username`, `password`) VALUES
(1, 'Miquel', 'Mir', '632452314', 'miquelet', '81dc9bdb52d04dc20036dbd8313ed055'),
(2, 'Joana', 'Pons', '656998877', 'joana22', '81dc9bdb52d04dc20036dbd8313ed055'),
(3, 'Laura ', 'Gonzalez', '696568423', 'laureta', '81dc9bdb52d04dc20036dbd8313ed055');

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
  `idusuari` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `reserves`
--

INSERT INTO `reserves` (`data`, `idpista`, `idusuari`) VALUES
('2021-11-04 16:00:00', 2, 1),
('2021-11-22 15:00:00', 1, 1),
('2021-10-20 18:00:00', 2, 2),
('2021-11-01 19:00:00', 1, 2),
('2021-10-20 18:00:00', 1, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuaris`
--
ALTER TABLE `usuaris`
  ADD PRIMARY KEY (`idusuari`);

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
  ADD KEY `idusuari` (`idusuari`),
  ADD KEY `idpista` (`idpista`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuaris`
--
ALTER TABLE `usuaris`
  MODIFY `idusuari` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  ADD CONSTRAINT `reserves_ibfk_1` FOREIGN KEY (`idusuari`) REFERENCES `usuaris` (`idusuari`),
  ADD CONSTRAINT `reserves_ibfk_2` FOREIGN KEY (`idpista`) REFERENCES `pistes` (`idpista`);
COMMIT;