-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-11-2023 a las 14:56:35
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `qrcodebd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `table_attendance`
--

CREATE TABLE `table_attendance` (
  `ID` int(11) NOT NULL,
  `STUDENTID` varchar(255) NOT NULL,
  `TIMEIN` datetime NOT NULL,
  `OPCION` varchar(255) NOT NULL,
  `CARGO` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `table_attendance`
--

INSERT INTO `table_attendance` (`ID`, `STUDENTID`, `TIMEIN`, `OPCION`, `CARGO`) VALUES
(1, 'Cotera juanante', '2023-11-16 08:39:52', 'entrada', 'docente'),
(2, 'edward juan', '2023-11-16 08:40:18', 'salida', 'estudiante'),
(3, 'Cotera juanante', '2023-11-16 08:48:07', 'permiso', 'otro');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `table_attendance`
--
ALTER TABLE `table_attendance`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `table_attendance`
--
ALTER TABLE `table_attendance`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
