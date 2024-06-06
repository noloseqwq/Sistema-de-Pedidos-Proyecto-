SET FOREIGN_KEY_CHECKS=0;

CREATE DATABASE IF NOT EXISTS sis_pedido;

USE sis_pedido;

DROP TABLE IF EXISTS cliente;

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_rif` varchar(250) NOT NULL,
  `cliente_tlf` varchar(250) NOT NULL,
  `cliente_razon` varchar(250) NOT NULL,
  `cliente_direccion` varchar(250) NOT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO cliente VALUES("1","11111111","04123654789","Surtigranos","Av Libertador");
INSERT INTO cliente VALUES("5","545456456","04123654749","TucheMarket","Av rotaria");
INSERT INTO cliente VALUES("6","64545456","01256789634","Sweet Cristal","Av Republica");
INSERT INTO cliente VALUES("7","56544658","04245687568","WAOS COMP","sabanita");



DROP TABLE IF EXISTS detalle_pedido;

CREATE TABLE `detalle_pedido` (
  `id_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `producto_nombre` varchar(250) NOT NULL,
  `cantidad_detalle` varchar(250) NOT NULL,
  `pedido_codigo` varchar(250) NOT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `pedido_codigo` (`pedido_codigo`),
  CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`pedido_codigo`) REFERENCES `pedido` (`codigo_pedido`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO detalle_pedido VALUES("28","Manga Blanca Clase A #16","12","CJ9274053-1");
INSERT INTO detalle_pedido VALUES("29","Manga Blanca Clase A #14","24","CJ8498494-2");
INSERT INTO detalle_pedido VALUES("30","Manga Blanca Clase A #8","15","CJ8498494-2");
INSERT INTO detalle_pedido VALUES("31","Kit de Manga Blanca Clase A #10","32","CJ8498494-2");
INSERT INTO detalle_pedido VALUES("32","Kit de Manga Amarilla #21 para churro","5","CJ2507620-3");
INSERT INTO detalle_pedido VALUES("33","Manga Blanca Clase A #18","4","CJ8469229-4");
INSERT INTO detalle_pedido VALUES("34","Manga Blanca Clase A #8","5","CJ8469229-4");
INSERT INTO detalle_pedido VALUES("35","Manga Desechable #12","2","CJ4162715-5");
INSERT INTO detalle_pedido VALUES("36","Kit con 3 Mangas Desechable","3","CJ9279045-6");
INSERT INTO detalle_pedido VALUES("37","Manga Desechable #14","32","CJ6554385-7");
INSERT INTO detalle_pedido VALUES("38","Manga Blanca Clase A #12","23","CJ2583283-8");



DROP TABLE IF EXISTS pedido;

CREATE TABLE `pedido` (
  `id_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_pedido` varchar(250) NOT NULL,
  `cantidad_pedido` int(11) NOT NULL,
  `estado_pedido` varchar(250) NOT NULL,
  `fecha_pedido` date NOT NULL,
  `id_client` int(11) NOT NULL,
  PRIMARY KEY (`id_pedido`),
  UNIQUE KEY `codigo_pedido` (`codigo_pedido`) USING BTREE,
  KEY `cliente` (`id_client`),
  CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO pedido VALUES("44","CJ9274053-1","12","Realizado","2024-06-05","5");
INSERT INTO pedido VALUES("45","CJ8498494-2","71","Pendiente","2024-06-05","6");
INSERT INTO pedido VALUES("46","CJ2507620-3","5","Pendiente","2024-06-01","6");
INSERT INTO pedido VALUES("47","CJ8469229-4","9","Pendiente","2024-06-03","6");
INSERT INTO pedido VALUES("48","CJ4162715-5","2","Pendiente","2024-06-04","6");
INSERT INTO pedido VALUES("49","CJ9279045-6","3","Pendiente","2024-06-04","6");
INSERT INTO pedido VALUES("50","CJ6554385-7","32","Pendiente","2024-06-04","6");
INSERT INTO pedido VALUES("51","CJ2583283-8","23","Pendiente","2024-06-04","6");



DROP TABLE IF EXISTS persona;

CREATE TABLE `persona` (
  `id_persona` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_persona` varchar(250) NOT NULL,
  `apellido_persona` varchar(250) NOT NULL,
  `CI_persona` varchar(250) NOT NULL,
  `id_usu` int(11) NOT NULL,
  PRIMARY KEY (`id_persona`),
  KEY `FKuser` (`id_usu`),
  CONSTRAINT `persona_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO persona VALUES("1","Administrador","Principal","00000000","1");
INSERT INTO persona VALUES("46","pepe","perales","30303030","80");
INSERT INTO persona VALUES("47","Rosa","Camargo","14296279","81");
INSERT INTO persona VALUES("48","Gabriel","Perdomo","11273546","82");
INSERT INTO persona VALUES("49","Andreyna","Camargo","18854631","83");
INSERT INTO persona VALUES("50","Gabriel","Perdomo","30040201","84");
INSERT INTO persona VALUES("51","Josmely","Durán","30826174","85");
INSERT INTO persona VALUES("52","Dolid","Mora","20258438","86");
INSERT INTO persona VALUES("53","waos","WAOS","2667895","87");



DROP TABLE IF EXISTS producto;

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_producto` varchar(250) NOT NULL,
  `nombre_producto` varchar(250) NOT NULL,
  `descripcion_producto` varchar(250) NOT NULL,
  PRIMARY KEY (`id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO producto VALUES("1","MB8","Manga Blanca Clase A #8","");
INSERT INTO producto VALUES("2","MB10","Manga Blanca Clase A #10","");
INSERT INTO producto VALUES("3","KMD","Kit con 3 Mangas Desechable","Con tres boquillas, un acople y tres mangas desechable");
INSERT INTO producto VALUES("4","KMA21","Kit de Manga Amarilla #21 para churro","Trae un a manga amarilla # 21, una boquilla grande 14B y la receta de churro");
INSERT INTO producto VALUES("7","MB12","Manga Blanca Clase A #12","");
INSERT INTO producto VALUES("8","MB14","Manga Blanca Clase A #14","");
INSERT INTO producto VALUES("9","MB16","Manga Blanca Clase A #16","");
INSERT INTO producto VALUES("10","MB18","Manga Blanca Clase A #18","");
INSERT INTO producto VALUES("11","MD10","Manga Desechable #20","");
INSERT INTO producto VALUES("12","MD12","Manga Desechable #12","");
INSERT INTO producto VALUES("13","MD14","Manga Desechable #14","");
INSERT INTO producto VALUES("14","MD16","Manga Desechable #16","");
INSERT INTO producto VALUES("15","MD18","Manga Desechable #18","");
INSERT INTO producto VALUES("16","MD22","Manga Desechable #22","");
INSERT INTO producto VALUES("17","KMB10","Kit de Manga Blanca Clase A #10","con tres boquillas, un acople y una mangas");



DROP TABLE IF EXISTS usuarios;

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(30) NOT NULL,
  `email` varchar(60) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `privilegio` int(2) NOT NULL,
  `pregunta1` varchar(250) DEFAULT NULL,
  `pregunta2` varchar(250) DEFAULT NULL,
  `respuesta1` varchar(250) DEFAULT NULL,
  `respuesta2` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO usuarios VALUES("1","admin123","ga@gmail.com","Tmd6ODlyOXp1NnVTdFBvQmN1SUc2UT09","1","que te gusta comer?","palabra Random","quesadillas","aceitunas");
INSERT INTO usuarios VALUES("80","pepes","pepe@perales.papas","bktUOUc0Wjd3MUVGN2JkUWZleDBNZz09","2","Lugar Favorito?","Pais Favorito?","paseo","Paris");
INSERT INTO usuarios VALUES("81","rosa","rosamaricampe@gmail.com","bktUOUc0Wjd3MUVGN2JkUWZleDBNZz09","1","Lugar Favorito?","Pais Favorito?","paseo","Paris");
INSERT INTO usuarios VALUES("82","caiman","gabrieljesusperdomo@gmail.com","bktUOUc0Wjd3MUVGN2JkUWZleDBNZz09","2","Lugar Favorito?","Pais Favorito?","paseo","Paris");
INSERT INTO usuarios VALUES("83","isabela","andre_isabel@gmail.com","bktUOUc0Wjd3MUVGN2JkUWZleDBNZz09","1","Lugar Favorito?","Pais Favorito?","paseo","Paris");
INSERT INTO usuarios VALUES("84","noloseqwq","gabrieldjesusperdomo@gmail.com","OExRUzJiNGdXbjNWWXpWa21jUDE4Zz09","3","Lugar Favorito?","Pais Favorito?","paseo","Paris");
INSERT INTO usuarios VALUES("85","mely","josmely15@gmail.com","bktUOUc0Wjd3MUVGN2JkUWZleDBNZz09","3","Lugar Favorito?","Pais Favorito?","paseo","Paris");
INSERT INTO usuarios VALUES("86","mora","moradolid@gmail.com","bktUOUc0Wjd3MUVGN2JkUWZleDBNZz09","3","Lugar Favorito?","Pais Favorito?","paseo","Paris");
INSERT INTO usuarios VALUES("87","skaskj","asd@sa.qde","bktUOUc0Wjd3MUVGN2JkUWZleDBNZz09","2","Lugar Favorito?","Pais Favorito?","paseo","Paris");



SET FOREIGN_KEY_CHECKS=1;