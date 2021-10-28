-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 28-10-2021 a las 15:04:20
-- Versión del servidor: 10.3.29-MariaDB-0+deb10u1
-- Versión de PHP: 7.3.29-1+0~20210701.86+debian10~1.gbp7ad6eb

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pruebaphp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `description` varchar(250) NOT NULL,
  `confir` tinyint(1) NOT NULL,
  `iu_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id`, `date`, `time`, `description`, `confir`, `iu_user`) VALUES
(1, '2021-10-05', '23:50:52', 'paiente', 1, 1),
(2, '2021-10-05', '32:50:52', 'hola', 0, 1),
(3, '2021-10-06', '32:50:52', 'ggggg', 1, 1),
(4, '2021-10-05', '32:50:52', 'ssssssssssstt', 1, 1),
(5, '2021-10-05', '32:50:52', 'aaaaaa', 0, 1),
(6, '2021-10-05', '32:50:52', 'aaaaatta', 0, 1),
(7, '2021-10-05', '32:50:52', 'rrrr', 0, 1),
(8, '2021-10-05', '32:50:52', 'rrttttrr', 0, 1),
(9, '2021-10-28', '32:50:52', 'rrttttrr', 0, 1),
(10, '2021-10-28', '32:50:52', 'descripcion', 0, 1),
(11, '2021-10-28', '32:50:52', 'descripcion', 0, 1),
(12, '2021-10-28', '14:45:46', 'descripcion', 1, 1),
(13, '2021-10-28', '14:46:01', 'descripcion', 0, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_cita` (`iu_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `fk_user_cita` FOREIGN KEY (`iu_user`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
