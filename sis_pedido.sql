-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-03-2024 a las 05:43:54
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sis_pedido`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `CI` varchar(30) NOT NULL,
  `email` varchar(60) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `privilegio` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `usuario`, `nombre`, `apellido`, `CI`, `email`, `clave`, `privilegio`) VALUES
(1, 'admin123', 'Administrador', 'Principal', '30303030', 'ga@gmail.com', 'Tmd6ODlyOXp1NnVTdFBvQmN1SUc2UT09', 1),
(2, 'noloseqwq', 'Gabriel', 'Perdomo', '30040201', 'gabrieldjesus@gmail.com', 'NWYxb1B2Y2hONVNYaGhWTWtlQU1Rdz09', 1),
(6, 'mely', 'Josmely', 'Durán', '30826174', 'josmely15@gmail.com', 'MnlzVG1NZzFxNjA0aWh2cGZRK2ZaQT09', 2),
(7, 'hola', 'asdasd', 'asdasd', '12121212121', 'h@a.ads', 'NUY2NC9nalcvQjdSU2s2bkYxZ2EvZz09', 2),
(9, 'rosa', 'Rosa', 'Camargo', '14296279', 'rosamaricampe@gmail.com', 'd0tyZzVOR1JOWFJvOHcvSnJQaDhZUT09', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
