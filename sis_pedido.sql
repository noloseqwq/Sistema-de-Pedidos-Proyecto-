-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-04-2024 a las 04:43:22
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
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `cliente_rif` varchar(250) NOT NULL,
  `cliente_tlf` varchar(250) NOT NULL,
  `cliente_razon` varchar(250) NOT NULL,
  `cliente_direccion` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `cliente_rif`, `cliente_tlf`, `cliente_razon`, `cliente_direccion`) VALUES
(1, '11111111', '04123654789', 'Surtigranos', 'Av Libertador'),
(3, '556456465', '014256486521', 'MilenaSHOP', '17 de Dic'),
(4, '45456456456', '04241597856', 'Nuevo Eden', 'Av Germania'),
(5, '545456456', '04123654749', 'TucheMarket', 'Av rotaria'),
(6, '64545456', '01256789634', 'Sweet Cristal', 'Av Republica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `codigo_producto` varchar(250) NOT NULL,
  `nombre_producto` varchar(250) NOT NULL,
  `descripcion_producto` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(2, 'noloseqwq', 'Gabriel', 'Perdomo', '30040201', 'gabrieldjesus@gmail.com', 'NUY2NC9nalcvQjdSU2s2bkYxZ2EvZz09', 1),
(6, 'mely', 'Josmely', 'Durán', '30826174', 'josmely15@gmail.com', 'NUY2NC9nalcvQjdSU2s2bkYxZ2EvZz09', 2),
(7, 'hola', 'asdasd', 'asdasd', '12121212121', 'h@a.ads', 'NUY2NC9nalcvQjdSU2s2bkYxZ2EvZz09', 2),
(9, 'rosa', 'Rosa', 'Camargo', '14296279', 'rosamaricampe@gmail.com', 'd0tyZzVOR1JOWFJvOHcvSnJQaDhZUT09', 1),
(12, 'nasdsa', 'aasdas', 'asdas', '330030', 'sad@asd.asd', 'NUY2NC9nalcvQjdSU2s2bkYxZ2EvZz09', 3),
(13, 'nolose', 'adssad', 'adsasxcf', '4545454', 'asd@ads.qsa', 'NUY2NC9nalcvQjdSU2s2bkYxZ2EvZz09', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
