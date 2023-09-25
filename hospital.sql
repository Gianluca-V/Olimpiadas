-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-09-2023 a las 20:49:07
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hospital`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

CREATE TABLE `areas` (
  `ID` int(11) NOT NULL,
  `Name` varchar(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `areas`
--

INSERT INTO `areas` (`ID`, `Name`) VALUES
(1, 'Emergency Ward'),
(2, 'Pediatrics'),
(3, 'Surgery'),
(35, 'Name');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calls`
--

CREATE TABLE `calls` (
  `ID` int(11) NOT NULL,
  `Type` varchar(10) NOT NULL,
  `ResponseTime` int(11) NOT NULL,
  `Attended` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `calls`
--

INSERT INTO `calls` (`ID`, `Type`, `ResponseTime`, `Attended`) VALUES
(1, 'Emergency', 10, 1),
(2, 'Normal', 5, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nurses`
--

CREATE TABLE `nurses` (
  `ID` int(11) NOT NULL,
  `FirstName` varchar(99) NOT NULL,
  `LastName` varchar(99) NOT NULL,
  `DNI` int(8) NOT NULL,
  `Phone` int(15) DEFAULT NULL,
  `Address` text DEFAULT NULL,
  `area` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `nurses`
--

INSERT INTO `nurses` (`ID`, `FirstName`, `LastName`, `DNI`, `Phone`, `Address`, `area`) VALUES
(1, 'Maria', 'Garcia', 20000000, 2147483647, '789 Cedar St', 1),
(2, 'Michael', 'Johnson', 30000000, 1234567891, '123 Pine St', 3),
(3, 'Anna', 'Brown', 25000000, 2147483647, '456 Birch St', 2),
(4, 'Sara', 'Martinez', 28000000, 2147483647, '789 Oak St', NULL),
(5, 'David', 'Williams', 32000000, 2147483647, '456 Elm St', NULL),
(6, 'Elena', 'Smith', 31000000, 2147483647, '123 Maple St', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patients`
--

CREATE TABLE `patients` (
  `ID` int(11) NOT NULL,
  `FirstName` varchar(99) NOT NULL,
  `LastName` varchar(99) NOT NULL,
  `DNI` int(8) NOT NULL,
  `Phone` int(15) DEFAULT NULL,
  `Address` text DEFAULT NULL,
  `BirthDate` varchar(10) DEFAULT NULL,
  `Location` int(11) DEFAULT NULL,
  `Nurse` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `patients`
--

INSERT INTO `patients` (`ID`, `FirstName`, `LastName`, `DNI`, `Phone`, `Address`, `BirthDate`, `Location`, `Nurse`) VALUES
(4, 'Patient 3', 'Lastname 3', 15000000, 1111111111, '101 Oak St', '1990-07-20', 2, 3),
(5, 'Patient 4', 'Lastname 4', 18000000, 2147483647, '202 Elm St', '1985-12-10', 3, 6),
(6, 'Patient 5', 'Lastname 5', 22000000, 2147483647, '303 Maple St', '2005-03-25', 1, 2),
(7, 'Patient 6', 'Lastname 6', 27000000, 2147483647, '101 Birch St', '1992-04-15', 1, 1),
(8, 'Patient 7', 'Lastname 7', 30000000, 2147483647, '202 Cedar St', '1988-09-28', 2, 5),
(9, 'Patient 8', 'Lastname 8', 34000000, 2147483647, '303 Pine St', '2000-12-05', 3, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `UserName` varchar(99) NOT NULL,
  `Password` text NOT NULL,
  `Salt` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`ID`, `UserName`, `Password`, `Salt`) VALUES
(4, 'Admin', '8bf69bc7d3ecc3a8a4b684680c12f143b74ccc3ae21eb921a823e4c628feb116', '312e2a48ec5338fb79388be0c8f75bbe');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `calls`
--
ALTER TABLE `calls`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `nurses`
--
ALTER TABLE `nurses`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `area` (`area`);

--
-- Indices de la tabla `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Location` (`Location`),
  ADD KEY `Nurse` (`Nurse`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `areas`
--
ALTER TABLE `areas`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `calls`
--
ALTER TABLE `calls`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `nurses`
--
ALTER TABLE `nurses`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `patients`
--
ALTER TABLE `patients`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `nurses`
--
ALTER TABLE `nurses`
  ADD CONSTRAINT `nurses_ibfk_1` FOREIGN KEY (`area`) REFERENCES `areas` (`ID`);

--
-- Filtros para la tabla `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_ibfk_1` FOREIGN KEY (`Location`) REFERENCES `areas` (`ID`),
  ADD CONSTRAINT `patients_ibfk_2` FOREIGN KEY (`Nurse`) REFERENCES `nurses` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
