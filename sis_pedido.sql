-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-05-2024 a las 04:35:01
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
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `id_detalle` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `producto_nombre` varchar(250) NOT NULL,
  `cantidad_detalle` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id_pedido` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `estado_producto` varchar(250) NOT NULL,
  `fecha_producto` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id_persona` int(11) NOT NULL,
  `nombre_persona` varchar(250) NOT NULL,
  `apellido_persona` varchar(250) NOT NULL,
  `CI_persona` varchar(250) NOT NULL,
  `id_usu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id_persona`, `nombre_persona`, `apellido_persona`, `CI_persona`, `id_usu`) VALUES
(1, 'Administrador', 'Principal', '00000000', 1),
(46, 'pepe', 'perales', '30303030', 80),
(47, 'Rosa', 'Camargo', '14296279', 81),
(48, 'Gabriel', 'Perdomo', '11273546', 82),
(49, 'Andreyna', 'Camargo', '18854631', 83),
(50, 'Gabriel', 'Perdomo', '30040201', 84),
(51, 'Josmely', 'Durán', '30826174', 85),
(52, 'Dolid', 'Mora', '20258438', 86),
(53, 'waos', 'WAOS', '2667895', 87);

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

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `codigo_producto`, `nombre_producto`, `descripcion_producto`) VALUES
(1, 'MB8', 'Manga Blanca Clase A #8', ''),
(2, 'MB10', 'Manga Blanca Clase A #10', ''),
(3, 'KMD', 'Kit con 3 Mangas Desechable', 'Con tres boquillas, un acople y tres mangas desechable'),
(4, 'KMA21', 'Kit de Manga Amarilla #21 para churro', 'Trae un a manga amarilla # 21, una boquilla grande 14B y la receta de churro'),
(7, 'MB12', 'Manga Blanca Clase A #12', ''),
(8, 'MB14', 'Manga Blanca Clase A #14', ''),
(9, 'MB16', 'Manga Blanca Clase A #16', ''),
(10, 'MB18', 'Manga Blanca Clase A #18', ''),
(11, 'MD10', 'Manga Desechable #20', ''),
(12, 'MD12', 'Manga Desechable #12', ''),
(13, 'MD14', 'Manga Desechable #14', ''),
(14, 'MD16', 'Manga Desechable #16', ''),
(15, 'MD18', 'Manga Desechable #18', ''),
(16, 'MD22', 'Manga Desechable #22', ''),
(17, 'KMB10', 'Kit de Manga Blanca Clase A #10', 'con tres boquillas, un acople y una mangas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `email` varchar(60) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `privilegio` int(2) NOT NULL,
  `pregunta1` varchar(250) DEFAULT NULL,
  `pregunta2` varchar(250) DEFAULT NULL,
  `respuesta1` varchar(250) DEFAULT NULL,
  `respuesta2` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `usuario`, `email`, `clave`, `privilegio`, `pregunta1`, `pregunta2`, `respuesta1`, `respuesta2`) VALUES
(1, 'admin123', 'ga@gmail.com', 'Tmd6ODlyOXp1NnVTdFBvQmN1SUc2UT09', 1, 'que te gusta comer?', 'palabra Random', 'quesadillas', 'aceitunas'),
(80, 'pepes', 'pepe@perales.papas', 'bktUOUc0Wjd3MUVGN2JkUWZleDBNZz09', 2, 'Lugar Favorito?', 'Pais Favorito?', 'paseo', 'Paris'),
(81, 'rosa', 'rosamaricampe@gmail.com', 'bktUOUc0Wjd3MUVGN2JkUWZleDBNZz09', 1, 'Lugar Favorito?', 'Pais Favorito?', 'paseo', 'Paris'),
(82, 'caiman', 'gabrieljesusperdomo@gmail.com', 'bktUOUc0Wjd3MUVGN2JkUWZleDBNZz09', 2, 'Lugar Favorito?', 'Pais Favorito?', 'paseo', 'Paris'),
(83, 'isabela', 'andre_isabel@gmail.com', 'bktUOUc0Wjd3MUVGN2JkUWZleDBNZz09', 1, 'Lugar Favorito?', 'Pais Favorito?', 'paseo', 'Paris'),
(84, 'noloseqwq', 'gabrieldjesusperdomo@gmail.com', 'OExRUzJiNGdXbjNWWXpWa21jUDE4Zz09', 3, 'Lugar Favorito?', 'Pais Favorito?', 'paseo', 'Paris'),
(85, 'mely', 'josmely15@gmail.com', 'bktUOUc0Wjd3MUVGN2JkUWZleDBNZz09', 3, 'Lugar Favorito?', 'Pais Favorito?', 'paseo', 'Paris'),
(86, 'mora', 'moradolid@gmail.com', 'bktUOUc0Wjd3MUVGN2JkUWZleDBNZz09', 3, 'Lugar Favorito?', 'Pais Favorito?', 'paseo', 'Paris'),
(87, 'skaskj', 'asd@sa.qde', 'bktUOUc0Wjd3MUVGN2JkUWZleDBNZz09', 2, 'Lugar Favorito?', 'Pais Favorito?', 'paseo', 'Paris');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `pedido` (`id_pedido`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `cliente` (`id_client`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id_persona`),
  ADD KEY `FKuser` (`id_usu`);

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
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `persona_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
