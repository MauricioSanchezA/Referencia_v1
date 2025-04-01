-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-03-2025 a las 15:50:02
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pdo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `categoria_id` int(7) NOT NULL,
  `categoria_nombre` varchar(50) NOT NULL,
  `categoria_ubicacion` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`categoria_id`, `categoria_nombre`, `categoria_ubicacion`) VALUES
(6, 'Ortopedia', 'ES1002'),
(7, 'Neonatos', 'ES1001'),
(8, 'Psiquiatria', 'ES1003'),
(9, 'Nutricion', 'ES1008'),
(10, 'Oncologia', 'ES1005'),
(11, 'Hermodinamia', 'ES1007'),
(14, 'Cardiovascular', 'ES1004'),
(16, 'Pediatria', 'ES1013');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contrato`
--

CREATE TABLE `contrato` (
  `contrato_id` int(11) NOT NULL,
  `contrato_nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contrato`
--

INSERT INTO `contrato` (`contrato_id`, `contrato_nombre`) VALUES
(1, 'Nueva EPS Contributivo'),
(3, 'Asmet Salud Subsidiado'),
(4, 'Asmet Salud Contributivo'),
(5, 'Comfenalco Contributivo'),
(6, 'Comfenalco Subsidiado'),
(7, 'Nueva EPS Subsidiado'),
(8, 'Sura Contributivo'),
(11, 'Sura Subsidiado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE `paciente` (
  `paciente_id` int(11) NOT NULL,
  `paciente_tipodoc` varchar(20) NOT NULL,
  `paciente_numdoc` varchar(15) NOT NULL,
  `paciente_nacimiento` date NOT NULL,
  `paciente_nombre` varchar(45) NOT NULL,
  `paciente_apellido` varchar(45) NOT NULL,
  `paciente_eps` varchar(45) NOT NULL,
  `paciente_contrato` varchar(150) DEFAULT NULL,
  `paciente_especialidad` varchar(45) NOT NULL,
  `paciente_novedad` varchar(500) NOT NULL,
  `paciente_estado` varchar(20) NOT NULL,
  `paciente_oxigeno` varchar(45) NOT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `dia_creacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`paciente_id`, `paciente_tipodoc`, `paciente_numdoc`, `paciente_nacimiento`, `paciente_nombre`, `paciente_apellido`, `paciente_eps`, `paciente_contrato`, `paciente_especialidad`, `paciente_novedad`, `paciente_estado`, `paciente_oxigeno`, `categoria_id`, `producto_id`, `usuario_id`, `dia_creacion`) VALUES
(2, 'CC', '1006332997', '1986-10-14', 'Edison Nolberto', 'Lopez Jojoa', 'ESE Hospital San Vicente', 'Comfenalco Subsidiado', 'Neonatos', 'Se realiza la segunda carga de info', 'Pendiente', 'Si', 7, 19, NULL, '2025-03-24'),
(6, 'CC', '1092917707', '2022-07-26', 'Eliecer', 'Ladino Carrasco', 'ESE Hospital San Rafael', 'Comfenalco Contributivo', 'Ortopedia', 'Verificando cambio aceptacion autocomplete update', 'Pendiente', 'Si', 6, 24, NULL, '2025-03-23'),
(12, 'CC', '15270143', '2001-12-03', 'German Antonio', 'Rojas Ossa', 'ESE Hospital del Centro', 'Nueva EPS Contributivo', 'Cardiovascular', 'campo contrato con autocomplete verificar guardar', 'Pendiente', 'No', 14, 18, NULL, '2025-03-25'),
(14, 'CC', '1093543314', '2001-12-03', 'Jesica Alejandra', 'Amaya', 'ESE Hospital del Centro', 'Sura Contributivo', 'Psiquiatria', 'Revision de espacio redirigir redirigir', 'Pendiente', 'Si', 8, 18, 3, '2025-03-24'),
(17, 'CC', '1053855085', '2003-11-02', 'Jhinier Alejandro', 'Vargas Lopez', 'ESE Hospital San Rafael', 'Comfenalco Contributivo', 'Cardiovascular', 'verificacion de campos en su longitud ya que esta adecuadoa 500 caracteres o mas', 'Pendiente', 'Si', 14, 24, NULL, '2025-03-25'),
(18, 'CC', '9800111', '2001-08-12', 'Jairo de Jesus', 'Velez', 'ESE Hospital Santa Monica', 'Asmet Salud Contributivo', 'Cardiovascular', 'verificacion con sesion por usuario o administrador', 'Pendiente', 'Si', 14, 12, NULL, '2025-03-24'),
(19, 'CC', '100238734', '2015-02-18', 'Carlos Mario', 'Jaramillo', 'Clinica Guadalupe', 'Nueva EPS Contributivo', 'Nutricion', 'Verificacion de paciente nuevo estado pendiente', 'Pendiente', 'Si', 9, 31, NULL, '2025-03-24'),
(20, 'CC', '4591042', '1995-07-03', 'FABIAN', 'DIAZ', 'ESE Hospital Belen de Umbria', 'Comfenalco Contributivo', 'Cardiovascular', 'PRUEBA DE INGRESO NUEVO', 'Pendiente', 'Si', 14, 13, NULL, '2025-03-27'),
(22, 'CC', '1092914926', '2002-05-05', 'Erika Yineth', 'Osorio', 'ESE Hospital San pedro', 'Asmet Salud Contributivo', 'Nutricion', 'Verificacion de datos en pendiente', 'Pendiente', 'Si', 9, 16, NULL, '2025-03-26'),
(24, 'CC', '1089609105', '2011-06-12', 'Susana', 'Lopez Quintero', 'ESE Hospital San pedro', 'Comfenalco Contributivo', 'Neonatos', 'Verificando tester 02 de pendiente', 'Pendiente', 'No', 7, 16, NULL, '2025-03-27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente_aceptado`
--

CREATE TABLE `paciente_aceptado` (
  `paciente_id` int(11) NOT NULL,
  `paciente_tipodoc` varchar(10) NOT NULL,
  `paciente_numdoc` varchar(15) NOT NULL,
  `paciente_nacimiento` date NOT NULL,
  `paciente_nombre` varchar(50) NOT NULL,
  `paciente_apellido` varchar(150) NOT NULL,
  `paciente_eps` varchar(45) NOT NULL,
  `paciente_especialidad` varchar(45) NOT NULL,
  `paciente_contrato` varchar(45) NOT NULL,
  `paciente_novedad` varchar(500) NOT NULL,
  `paciente_estado` enum('Pendiente','Aceptado','Cerrado') DEFAULT 'Pendiente',
  `paciente_oxigeno` enum('Si','No') NOT NULL,
  `dia_creacion` date NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `num_cama` varchar(20) NOT NULL,
  `remitido_por` varchar(100) NOT NULL,
  `fecha_entrada` date NOT NULL,
  `fecha_salida` date NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `paciente_aceptado`
--

INSERT INTO `paciente_aceptado` (`paciente_id`, `paciente_tipodoc`, `paciente_numdoc`, `paciente_nacimiento`, `paciente_nombre`, `paciente_apellido`, `paciente_eps`, `paciente_especialidad`, `paciente_contrato`, `paciente_novedad`, `paciente_estado`, `paciente_oxigeno`, `dia_creacion`, `codigo`, `num_cama`, `remitido_por`, `fecha_entrada`, `fecha_salida`, `categoria_id`, `producto_id`) VALUES
(12, 'CC', '15270143', '2001-12-03', 'German Antonio', 'Rojas Ossa', 'ESE Hospital del Centro', 'Nutricion', 'Nueva EPS Contributivo', 'campo contrato con autocomplete verificar guardar', 'Aceptado', 'Si', '2025-03-25', 'LMAR24D06', 'Cama07', 'Santiago Pradilla', '2025-03-17', '2025-03-31', 9, 18),
(14, 'CC', '1093543314', '2001-12-03', 'Jesica Alejandra', 'Amaya', 'ESE Hospital del Centro', 'Psiquiatria', 'Sura Contributivo', 'Revision de espacio redirigir redirigir', 'Aceptado', 'Si', '2025-03-24', 'LMAR24D03', 'cama20', 'Andry melisa', '2025-03-23', '2025-03-31', 8, 18),
(16, 'CC', '10129606', '1995-09-03', 'Sebastian', 'Gil Molina', 'ESE Hospital San pedro', 'Nutricion', 'Comfenalco Contributivo', 'verificando con campo de fecha', 'Aceptado', 'Si', '2025-03-26', 'MMAR25D03', 'CAMA16', 'Juan Pablo Vergara', '2025-03-21', '2025-03-31', 9, 16),
(17, 'CC', '1053855085', '2003-11-02', 'Jhinier Alejandro', 'Vargas Lopez', 'ESE Hospital San Rafael', 'Cardiovascular', 'Comfenalco Contributivo', 'verificacion de campos en su longitud ya que esta adecuadoa 500 caracteres o mas', 'Aceptado', 'Si', '2025-03-24', 'LMAR24D05', 'CAMA01', 'Luz Piedad Abella', '2025-03-24', '2025-04-09', 14, 24),
(18, 'CC', '9800111', '2001-08-12', 'Jairo de Jesus', 'Velez', 'ESE Hospital Santa Monica', 'Cardiovascular', 'Asmet Salud Contributivo', 'verificacion con sesion por usuario o administrador', 'Aceptado', 'Si', '2025-03-24', 'LMAR24D01', 'cama18', 'Luis Fdo Sanz', '2025-03-24', '2025-03-31', 14, 12),
(20, 'CC', '4591042', '1995-07-03', 'FABIAN', 'DIAZ', 'ESE Hospital Belen de Umbria', 'Nutricion', 'Comfenalco Contributivo', 'PRUEBA DE INGRESO NUEVO', 'Aceptado', 'Si', '2025-03-25', 'MMAR25D28', 'CAM15', 'HAROLD RAMIREZ', '2025-03-26', '2025-03-27', 9, 13),
(21, 'CC', '111409591', '2006-04-13', 'VALENTINA', 'GONZALEZ', 'ESE Hospital Santa Monica', 'Nutricion', 'Sura Contributivo', 'REVISION EN LOS CAMBIOS DE ESTADO aqui de pen a acep', 'Aceptado', 'Si', '2025-03-26', 'm2345', 'cam14', 'restrepo', '2025-03-03', '2025-03-21', 9, 12),
(23, 'CC', '1059713091', '2009-10-09', 'Lysbey', 'Betancurh Motato', 'ESE Hospital San Pedro y San Pablo', 'Psiquiatria', 'Asmet Salud Contributivo', 'tester para ingreso de paciente', 'Aceptado', 'No', '2025-03-27', 'JMAR27D01', 'CAMA12', 'Yenny Hernandez', '2025-03-24', '2025-03-31', 8, 14),
(25, 'CC', '10084422', '2002-04-19', 'German', 'Quimbaya Ospina', 'ESE Hospital Belen de Umbria', 'Psiquiatria', 'Asmet Salud Contributivo', 'verificacion paso 3 de Aceptado a Aceptado', 'Aceptado', 'Si', '2025-03-28', 'VMAR28D01', 'CAMA 03', 'Luisa Fernanda Botero', '2025-03-19', '2025-03-30', 8, 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente_cerrado`
--

CREATE TABLE `paciente_cerrado` (
  `cerrado_id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `paciente_tipodoc` varchar(10) NOT NULL,
  `paciente_numdoc` varchar(15) NOT NULL,
  `paciente_nacimiento` date NOT NULL,
  `paciente_nombre` varchar(50) NOT NULL,
  `paciente_apellido` varchar(150) NOT NULL,
  `paciente_eps` varchar(45) NOT NULL,
  `paciente_especialidad` varchar(45) NOT NULL,
  `paciente_contrato` varchar(45) NOT NULL,
  `paciente_novedad` varchar(500) NOT NULL,
  `paciente_estado` enum('Pendiente','Aceptado','Cerrado') DEFAULT 'Cerrado',
  `paciente_oxigeno` enum('Si','No') NOT NULL,
  `dia_creacion` date NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `num_cama` varchar(20) NOT NULL,
  `remitido_por` varchar(100) NOT NULL,
  `fecha_entrada` date NOT NULL,
  `fecha_salida` date NOT NULL,
  `novedad_final` text DEFAULT NULL,
  `categoria_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `fecha_cerrado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `producto_id` int(20) NOT NULL,
  `producto_codigo` varchar(70) NOT NULL,
  `producto_nombre` varchar(70) NOT NULL,
  `producto_precio` varchar(125) NOT NULL,
  `producto_stock` varchar(125) NOT NULL,
  `producto_foto` varchar(500) NOT NULL,
  `categoria_id` int(7) NOT NULL,
  `usuario_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`producto_id`, `producto_codigo`, `producto_nombre`, `producto_precio`, `producto_stock`, `producto_foto`, `categoria_id`, `usuario_id`) VALUES
(11, '101', 'ESE Hospital San Jorge', 'Pereira', 'Rsaralda', 'ESE_Hospital_San_Jorge_82.png', 7, 1),
(12, '102', 'ESE Hospital Santa Monica', 'Dosquebradas', 'Risaralda', 'ESE_Hospital_Santa_Monica_27.png', 6, 1),
(13, '104', 'ESE Hospital Belen de Umbria', 'Belen de Umbria', 'Risaralda', 'ESE_Hospital_Belen_de_Umbria_34.png', 8, 2),
(14, '105', 'ESE Hospital San Pedro y San Pablo', 'La Virginia', 'Risaralda', 'ESE_Hospital_San_Pedro_y_San_Pablo_43.png', 8, 2),
(15, '106', 'ESE San Pedro y San Pablo', 'La Virginia', 'Risaralda', 'ESE_San_Pedro_y_San_Pablo_7.png', 8, 1),
(16, '107', 'ESE Hospital San pedro', 'La Virginia', 'Risaralda', 'ESE_Hospital_San_pedro_80.png', 8, 2),
(18, '110', 'ESE Hospital del Centro', 'Pereira', 'Risaralda', 'ESE_Hospital_del_Centro_39.png', 6, 2),
(19, '111', 'ESE Hospital San Vicente', 'Santa Rosa', 'Risaralda', 'ESE_Hospital_San_Vicente_60.png', 7, 2),
(22, '115', 'ESE Hospital UTP', 'Pereira', 'Risaralda', 'producto.png', 6, 2),
(23, '119', 'ESE San Jorge', 'Pereira', 'Risaralda', 'producto.png', 8, 2),
(24, '120', 'ESE Hospital San Rafael', 'Pereira', 'Risaralda', 'ESE_Hospital_San_Rafael_6.png', 8, 2),
(29, '103', 'Hospital San Juan de Dios', 'Santa Rosa de Cabal', 'Risaralda', 'Hospital_San_Juan_de_Dios_85.png', 7, 3),
(30, '109', 'Hospital Maria Claret', 'Santa Rosa de cabal', 'Risaralda', 'Hospital_Maria_Claret_19.png', 6, 3),
(31, '118', 'Clinica Guadalupe', 'Dosquebradas', 'Risaralda', 'Clinica_Guadalupe_46.png', 16, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(10) NOT NULL,
  `usuario_nombre` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `usuario_apellido` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `usuario_usuario` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `usuario_clave` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `usuario_email` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'Usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `usuario_nombre`, `usuario_apellido`, `usuario_usuario`, `usuario_clave`, `usuario_email`, `role`) VALUES
(1, 'Administrador', 'Principal', 'Administrador', '$2y$10$EPY9LSLOFLDDBriuJICmFOqmZdnDXxLJG8YFbog5LcExp77DBQvgC', '', 'Administrador'),
(2, 'mauricio', 'sanchez abella', 'msanchez', '$2y$10$CEQIrEvlPzfDAsydCvs/U.WSbggp1emoYt9BWvVPR0uYqSASIamdC', 'samauricio71@gmail.com', 'Usuario'),
(3, 'Andry Melisa', 'Sarmiento Ospina', 'andrym', '$2y$10$Wrh5i1hddVaqHA3TRilaA.9fnvkwMHse.0WpZs6Q77ze3F.MQrEWC', 'andry@gmail.com', 'Usuario');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`categoria_id`);

--
-- Indices de la tabla `contrato`
--
ALTER TABLE `contrato`
  ADD PRIMARY KEY (`contrato_id`);

--
-- Indices de la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`paciente_id`),
  ADD KEY `categoria_id` (`categoria_id`),
  ADD KEY `producto_id` (`producto_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `paciente_aceptado`
--
ALTER TABLE `paciente_aceptado`
  ADD PRIMARY KEY (`paciente_id`),
  ADD KEY `categoria_id` (`categoria_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `paciente_cerrado`
--
ALTER TABLE `paciente_cerrado`
  ADD PRIMARY KEY (`cerrado_id`),
  ADD KEY `categoria_id` (`categoria_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`producto_id`),
  ADD KEY `categoria_id` (`categoria_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `categoria_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `contrato`
--
ALTER TABLE `contrato`
  MODIFY `contrato_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `paciente_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `paciente_aceptado`
--
ALTER TABLE `paciente_aceptado`
  MODIFY `paciente_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `paciente_cerrado`
--
ALTER TABLE `paciente_cerrado`
  MODIFY `cerrado_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `producto_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD CONSTRAINT `paciente_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`categoria_id`),
  ADD CONSTRAINT `paciente_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`producto_id`),
  ADD CONSTRAINT `paciente_ibfk_3` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`);

--
-- Filtros para la tabla `paciente_aceptado`
--
ALTER TABLE `paciente_aceptado`
  ADD CONSTRAINT `paciente_aceptado_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`categoria_id`),
  ADD CONSTRAINT `paciente_aceptado_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`producto_id`);

--
-- Filtros para la tabla `paciente_cerrado`
--
ALTER TABLE `paciente_cerrado`
  ADD CONSTRAINT `paciente_cerrado_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`categoria_id`),
  ADD CONSTRAINT `paciente_cerrado_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`producto_id`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`categoria_id`),
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
