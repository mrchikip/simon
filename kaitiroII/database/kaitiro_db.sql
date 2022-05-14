-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-07-2021 a las 21:53:43
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `kaitiro`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recurso`
--

CREATE TABLE `recurso` (
  `Dispositivo` int(11) NOT NULL,
  `SAP` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
  `Descripcion` varchar(29) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `recurso`
--

INSERT INTO `recurso` (`Dispositivo`, `SAP`, `Descripcion`) VALUES
(3, 'TCR03', 'TELAR CROCHET 03'),
(4, 'TCR04', 'TELAR CROCHET 04'),
(5, 'TPL05', 'TELAR PLANO 05'),
(6, 'TPL06', 'TELAR PLANO 06'),
(7, 'TPL07', 'TELAR PLANO 07'),
(8, 'TCR08', 'TELAR CROCHET 08'),
(9, 'TCR09', 'TELAR CROCHET 09'),
(10, 'TPL10', 'TELAR PLANO 10'),
(11, 'TPL11', 'TELAR PLANO 11'),
(12, 'TPL12', 'TELAR PLANO 12'),
(13, 'TPL13', 'TELAR PLANO 13'),
(14, 'TCR14', 'TELAR CROCHET 14'),
(15, 'TPL15', 'TELAR PLANO 15'),
(16, 'TCR16', 'TELAR CROCHET 16'),
(17, 'TCR17', 'TELAR CROCHET 17'),
(18, 'TPL18', 'TELAR PLANO 18'),
(19, 'TPL19', 'TELAR PLANO 19'),
(20, 'TCR20', 'TELAR CROCHET 20'),
(21, 'TCR21', 'TELAR CROCHET 21'),
(22, 'TPL22', 'TELAR PLANO 22'),
(23, 'TJQ23', 'TELAR JACQUARD 23'),
(24, 'TJQ24', 'TELAR JACQUARD 24'),
(25, 'TPL25', 'TELAR PLANO 25'),
(26, 'TPL26', 'TELAR PLANO 26'),
(27, 'TPL27', 'TELAR PLANO 27'),
(28, 'TPL28', 'TELAR PLANO 28'),
(29, 'TPL29', 'TELAR PLANO 29'),
(30, 'TCR30', 'TELAR CROCHET 30'),
(31, 'TJQ31', 'TELAR JACQUARD 31'),
(32, 'TJQ32', 'TELAR JACQUARD 32'),
(33, 'TPL33', 'TELAR PLANO 33'),
(34, 'TPL34', 'TELAR PLANO 34'),
(35, 'TPL35', 'TELAR PLANO 35'),
(36, 'TPL36', 'TELAR PLANO 36'),
(37, 'TPL37', 'TELAR PLANO 37'),
(38, 'TJQ38', 'TELAR JACQUARD 38'),
(39, 'TPL39', 'TELAR PLANO 39 (ELATEX 04)'),
(40, 'TPL40', 'TELAR PLANO 40 (ELATEX 13)'),
(41, 'TPL41', 'TELAR PLANO 41 (ELATEX 01)'),
(42, 'TPL42', 'TELAR PLANO 42 (ELATEX 02)'),
(43, 'TPL43', 'TELAR PLANO 43 (ELATEX 03)'),
(44, 'TPL44', 'TELAR PLANO 44 (ELATEX 05)'),
(45, 'TPL45', 'TELAR PLANO 45 (ELATEX 07)'),
(46, 'TPL46', 'TELAR PLANO 46 (ELATEX 08)'),
(47, 'TPL47', 'TELAR PLANO 47 (ELATEX 10)'),
(48, 'TPL48', 'TELAR PLANO 48 (ELATEX 11)'),
(49, 'TPL49', 'TELAR PLANO 49 (ELATEX 12)'),
(50, 'TJQ50', 'TELAR JACQUARD 50 (ELATEX 06)'),
(51, 'TJQ51', 'TELAR JACQUARD 51 (ELATEX 09)'),
(52, 'TJQ52', 'TELAR JACQUARD 52 (ELATEX 14)'),
(53, 'TJQ53', 'TELAR JACQUARD 53 (ELATEX 15)'),
(54, 'TJQ54', 'TELAR JACQUARD 54 (ELATEX 16)'),
(55, 'TJQ55', 'TELAR JACQUARD 55 (ELATEX 17)'),
(56, 'TJQ56', 'TELAR JACQUARD 56 (ELATEX 18)'),
(57, 'TJQ57', 'TELAR JACQUARD 57 (ELATEX 19)'),
(58, 'TJQ58', 'TELAR JACQUARD 58 (ELATEX 20)'),
(59, 'TJQ59', 'TELAR JACQUARD 59 (ELATEX 21)'),
(60, 'TJQ60', 'TELAR JACQUARD 60 (ELATEX 22)'),
(61, 'TJQ61', 'TELAR JACQUARD 61 (ELATEX 23)'),
(62, 'TCR62', 'TELAR CROCHET 62');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros`
--

CREATE TABLE `registros` (
  `id` double NOT NULL,
  `contador` int(11) NOT NULL,
  `tiempo` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `valor` int(11) NOT NULL,
  `dispositivo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `registros`
--

INSERT INTO `registros` (`id`, `contador`, `tiempo`, `valor`, `dispositivo`);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `recurso`
--
ALTER TABLE `recurso`
  ADD PRIMARY KEY (`Dispositivo`);

--
-- Indices de la tabla `registros`
--
ALTER TABLE `registros`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `registros`
--
ALTER TABLE `registros`
  MODIFY `id` double NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=369188;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
