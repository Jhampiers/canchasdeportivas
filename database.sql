-- Sistema de Canchas - Dump completo con usuarios
CREATE DATABASE IF NOT EXISTS inventario CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE inventario;

DROP TABLE IF EXISTS canchas;
CREATE TABLE `canchas` (
  `id_cancha` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `ubicacion` varchar(150) NOT NULL,
  `descripcion` text,
  `estado` varchar(50) DEFAULT 'Disponible',
  `precio_hora` decimal(10,2) DEFAULT '0.00',
  `telefono` varchar(20) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_cancha`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `canchas` (`nombre`, `ubicacion`, `descripcion`, `estado`, `precio_hora`, `telefono`, `fecha_registro`) VALUES
('Cancha Municipal San Martín', 'Av. Principal #123, Distrito X', 'Cancha de césped sintético, iluminación nocturna', 'Disponible', '50.00', '999-888-777', NOW() - INTERVAL 6 DAY),
('Cancha Los Amigos', 'Jr. Deportes #456, Distrito X', 'Cancha techada, césped sintético, servicios higiénicos', 'Disponible', '60.00', '999-888-776', NOW() - INTERVAL 5 DAY),
('Don mario', 'chillicopampa', 'gras ihfiuhdfuihufoghudisyf', 'Cerrado', '30.00', '99999999', NOW() - INTERVAL 3 DAY),
('santa rosa', 'chillicopampa', 'iuygfuyigfuywg', 'Mantenimiento', '50.00', '966123456', NOW() - INTERVAL 1 DAY);

DROP TABLE IF EXISTS usuarios;
CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` varchar(20) DEFAULT 'admin',
  `fecha_registro` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `uniq_usuario` (`usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Usuario admin por defecto (password = admin, usando MD5 para compatibilidad)
INSERT INTO `usuarios` (`usuario`, `password`, `rol`) VALUES
('admin', MD5('admin'), 'admin');
