-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-03-2022 a las 21:32:39
-- Versión del servidor: 10.3.9-MariaDB-log
-- Versión de PHP: 7.4.3

CREATE DATABASE sistemageneral;
USE sistemageneral;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistemageneral`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE `area` (
  `id` int(11) NOT NULL,
  `nombre_area` varchar(150) NOT NULL,
  `abreviatura` varchar(20) NOT NULL,
  `estatus_area` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `area`
--

INSERT INTO `area` (`id`, `nombre_area`, `abreviatura`, `estatus_area`) VALUES
(1, 'Sin Area', '', 1),
(2, 'CoordinaciÃ³n De Sistemas De InformÃ¡tica', 'CSI', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaciones`
--

CREATE TABLE `asignaciones` (
  `id` int(11) NOT NULL,
  `id_componente` int(11) NOT NULL,
  `marca_modelo` varchar(45) NOT NULL,
  `cantidad` varchar(45) NOT NULL,
  `no_serie` varchar(45) NOT NULL,
  `descripcion` varchar(250) DEFAULT NULL,
  `id_detalle_usuario` int(11) NOT NULL,
  `fecha_asignacion` date NOT NULL,
  `estatus_asignacion` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaciones_vehiculos`
--

CREATE TABLE `asignaciones_vehiculos` (
  `id` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `marca_modelo` varchar(255) NOT NULL,
  `no_serie` varchar(255) NOT NULL,
  `placas` varchar(255) NOT NULL,
  `descripcion` varchar(300) DEFAULT NULL,
  `id_detalle_usuario` int(11) NOT NULL,
  `fecha_asignacion` date NOT NULL,
  `estatus_asignacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `capacitaciones`
--

CREATE TABLE `capacitaciones` (
  `id` int(11) NOT NULL,
  `nombre_capacitacion` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `quien_solicita` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `lugar` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `no_asistentes` int(11) NOT NULL,
  `modalidad` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `depto_org` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `capacitador` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `curriculum` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `constancia` varchar(250) CHARACTER SET ucs2 COLLATE ucs2_spanish_ci DEFAULT NULL,
  `folio` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `capacitaciones`
--

INSERT INTO `capacitaciones` (`id`, `nombre_capacitacion`, `quien_solicita`, `fecha`, `hora`, `lugar`, `no_asistentes`, `modalidad`, `depto_org`, `capacitador`, `curriculum`, `constancia`, `folio`) VALUES
(1, 'Finanzas', 'MartÃ­n LÃ³pez CÃ¡zares', '2022-03-03', '11:00:00', 'Auditorio CEDH', 40, 'Presencial', 'ContralorÃ­a', 'Juan JosÃ© Escutia RodrÃ­guez', 'resguardo.pdf', '', 'CEDH/0002/2022-CAP');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargos`
--

CREATE TABLE `cargos` (
  `id` int(11) NOT NULL,
  `nombre_cargo` varchar(100) NOT NULL,
  `id_area` int(11) NOT NULL,
  `estatus_cargo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cargos`
--

INSERT INTO `cargos` (`id`, `nombre_cargo`, `id_area`, `estatus_cargo`) VALUES
(1, 'Sin Cargo', 1, 1),
(2, 'Coordinador de Sistemas', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre_categoria` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre_categoria`) VALUES
(1, 'Sin Categoria');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `componentes`
--

CREATE TABLE `componentes` (
  `id` int(11) NOT NULL,
  `nombre_componente` varchar(45) NOT NULL,
  `marca` varchar(45) NOT NULL,
  `modelo` varchar(45) NOT NULL,
  `serie` varchar(45) NOT NULL,
  `cantidad` varchar(45) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `descripcion_particular` varchar(250) DEFAULT NULL,
  `precio_compra` decimal(25,2) NOT NULL,
  `fecha_registro` date NOT NULL,
  `media_id` varchar(45) DEFAULT NULL,
  `estatus_componente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `convenios`
--

CREATE TABLE `convenios` (
  `id` int(11) NOT NULL,
  `folio_solicitud` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha_convenio` date NOT NULL,
  `institucion` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion_convenio` varchar(400) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `vigencia` date NOT NULL,
  `direccion_institucion` varchar(400) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `convenios`
--

INSERT INTO `convenios` (`id`, `folio_solicitud`, `fecha_convenio`, `institucion`, `descripcion_convenio`, `vigencia`, `direccion_institucion`, `telefono`) VALUES
(1, 'CEDH/0001/2022-CONV', '2021-01-04', 'ComisiÃ³n Federal de Electricidad', 'Convenio de bienes elÃ©ctricos', '2022-03-03', 'Lomas de la Villa 154, Los Montes', '1234567890');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_usuario`
--

CREATE TABLE `detalles_usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `sexo` varchar(1) NOT NULL,
  `curp` varchar(45) NOT NULL,
  `rfc` varchar(45) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `telefono_casa` varchar(45) DEFAULT NULL,
  `telefono_celular` varchar(45) NOT NULL,
  `calle_numero` varchar(150) NOT NULL,
  `colonia` varchar(150) NOT NULL,
  `municipio` varchar(150) NOT NULL,
  `estado` varchar(150) NOT NULL,
  `pais` varchar(100) NOT NULL DEFAULT 'México',
  `id_cargo` int(11) NOT NULL,
  `estatus_detalle` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalles_usuario`
--

INSERT INTO `detalles_usuario` (`id`, `nombre`, `apellidos`, `sexo`, `curp`, `rfc`, `correo`, `telefono_casa`, `telefono_celular`, `calle_numero`, `colonia`, `municipio`, `estado`, `pais`, `id_cargo`, `estatus_detalle`) VALUES
(1, 'SuperAdmin', 'Super', 'H', 'XXXXXXXXXXXXXX', 'XXXXXXXXXXX', 'admin@gmail.com', '1234567890', '1234567890', 'Calle 12', 'Colonia 2', 'Morelia', 'MichoacÃ¡n', 'MÃ©xico', 2, 1),
(2, 'Trabajador X', 'Trabajador', 'H', 'XXXXXXXXXXXXXX', 'XXXXXXXXXXX', 'prueba@gmail.com', '1234567890', '1234567890', 'Calle 12', 'Colonia 2', 'Morelia', 'MichoacÃ¡n', 'MÃ©xico', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fichas`
--

CREATE TABLE `fichas` (
  `id` int(11) NOT NULL,
  `folio` varchar(40) NOT NULL,
  `tipo_solicitud` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `num_expediente` varchar(80) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `solicitante` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `visitaduria` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `hechos` varchar(500) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `autoridad` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `quien_presenta` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nombre_usuario` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `parentesco` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `edad` int(11) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `sexo` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `grupo_vulnerable` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `tutor` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `contacto` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha_intervencion` date NOT NULL,
  `hora_lugar` varchar(300) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `actividad_realizada` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `observaciones` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `fichas`
--

INSERT INTO `fichas` (`id`, `folio`, `tipo_solicitud`, `num_expediente`, `solicitante`, `visitaduria`, `hechos`, `autoridad`, `quien_presenta`, `nombre_usuario`, `parentesco`, `edad`, `fecha_nacimiento`, `sexo`, `grupo_vulnerable`, `tutor`, `contacto`, `fecha_intervencion`, `hora_lugar`, `actividad_realizada`, `observaciones`) VALUES
(1, 'CEDH/0006/2022-FT', 'Certificado', '12345', 'Juan PÃ©rez LÃ³pez', 'Regional de Morelia', 'NO SE PRESENTÃ³', 'ComisiÃ³n Estatal de Cultura FÃ­sica y Deporte', 'Luis DÃ­az Robles', 'LuisD', '', 23, '1998-02-03', 'Mujer', 'Personas con discapacidad', '', '1234567890', '2022-03-03', '2:50 Morelia En el aeropuerto', 'Visita', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `folios`
--

CREATE TABLE `folios` (
  `id` int(11) NOT NULL,
  `folio` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `contador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `folios`
--

INSERT INTO `folios` (`id`, `folio`, `contador`) VALUES
(1, 'CEDH/0001/2022-CONV', 1),
(2, 'CEDH/0002/2022-CAP', 2),
(3, 'CEDH/0003/2022-O', 3),
(4, 'CEDH/0004/2022-C', 4),
(5, 'CEDH/0005/2022-C', 5),
(6, 'CEDH/0006/2022-FT', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo_usuarios`
--

CREATE TABLE `grupo_usuarios` (
  `id` int(11) NOT NULL,
  `nombre_grupo` varchar(45) NOT NULL,
  `nivel_grupo` int(11) NOT NULL,
  `estatus_grupo` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `grupo_usuarios`
--

INSERT INTO `grupo_usuarios` (`id`, `nombre_grupo`, `nivel_grupo`, `estatus_grupo`) VALUES
(1, 'SuperAdmin', 1, 1),
(2, 'Admin', 2, 1),
(3, 'User', 3, 1),
(4, 'Capturista', 4, 1),
(5, 'Ciudadano', 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `nombre_archivo` varchar(255) NOT NULL,
  `tipo_archivo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orientacion_canalizacion`
--

CREATE TABLE `orientacion_canalizacion` (
  `id` int(11) NOT NULL,
  `folio` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `correo_electronico` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre_completo` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nivel_estudios` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `ocupacion` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `edad` int(3) NOT NULL,
  `telefono` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `extension` varchar(4) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `sexo` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `calle_numero` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `colonia` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codigo_postal` varchar(5) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `municipio_localidad` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `entidad` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nacionalidad` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `tipo_solicitud` int(11) NOT NULL,
  `medio_presentacion` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `observaciones` varchar(300) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `adjunto` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_creador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `orientacion_canalizacion`
--

INSERT INTO `orientacion_canalizacion` (`id`, `folio`, `correo_electronico`, `nombre_completo`, `nivel_estudios`, `ocupacion`, `edad`, `telefono`, `extension`, `sexo`, `calle_numero`, `colonia`, `codigo_postal`, `municipio_localidad`, `entidad`, `nacionalidad`, `tipo_solicitud`, `medio_presentacion`, `observaciones`, `adjunto`, `id_creador`) VALUES
(1, 'CEDH/0003/2022-O', 'gabriela@gmail.com', 'Gabriel SÃ¡nchez RuÃ­z', 'Licenciatura', 'Deportista', 40, '1234567890', '123', 'M', 'Flores del mar 45', 'Villafuerte', '12345', 'Morelia', 'MichoacÃ¡n', 'Mexicana', 1, 'Escrito', '', 'resguardo.pdf', 1),
(2, 'CEDH/0004/2022-C', 'javier@gmail.com', 'Javier Villa LÃ³pez', 'Preparatoria', 'Comerciante', 32, '2334567890', '567', 'H', 'Calle de los RÃ­os', 'Villa Castilla', '89075', 'Morelia', 'MichoacÃ¡n', 'Mexicana', 2, 'Comparecencia', '', 'resguardo.pdf', 1),
(3, 'CEDH/0005/2022-C', 'polo@gmail.com', 'Polo', 'Sin estudios', 'Agricultor(a)', 36, '1234567890', '123', 'H', 'Calle de Prueba', 'Villafuerte', '36521', 'Morelia', 'MichoacÃ¡n', 'Mexicana', 2, 'Escrito', '', 'acta_nacimiento.pdf', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resguardos`
--

CREATE TABLE `resguardos` (
  `id` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_termino` varchar(25) DEFAULT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `id_asignacion` int(11) NOT NULL,
  `folio` varchar(50) NOT NULL,
  `estatus_resguardo` int(1) NOT NULL,
  `id_asignacion_resguardo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resguardos_vehiculos`
--

CREATE TABLE `resguardos_vehiculos` (
  `id` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_termino` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `observaciones` varchar(300) CHARACTER SET utf8 DEFAULT NULL,
  `id_asignacion_vehiculo` int(11) NOT NULL,
  `folio` varchar(50) CHARACTER SET utf8 NOT NULL,
  `estatus_resguardo` int(11) NOT NULL,
  `id_asignacion_resguardo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_orien_canal`
--

CREATE TABLE `tipo_orien_canal` (
  `id` int(11) NOT NULL,
  `nombre_solicitud` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_orien_canal`
--

INSERT INTO `tipo_orien_canal` (`id`, `nombre_solicitud`) VALUES
(1, 'Orientación'),
(2, 'Canalización');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_vehiculo`
--

CREATE TABLE `tipo_vehiculo` (
  `id` int(11) NOT NULL,
  `tipo_vehiculo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_vehiculo`
--

INSERT INTO `tipo_vehiculo` (`id`, `tipo_vehiculo`) VALUES
(1, 'Sin tipo de vehiculo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `id_detalle_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(45) NOT NULL,
  `user_level` int(11) NOT NULL,
  `imagen` varchar(255) DEFAULT 'no_image.jpg',
  `status` int(1) NOT NULL,
  `ultimo_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `id_detalle_user`, `username`, `password`, `user_level`, `imagen`, `status`, `ultimo_login`) VALUES
(1, 1, 'Administrador', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, NULL, 1, '2022-02-28 11:01:17'),
(2, 2, 'prueba', '8cb2237d0679ca88db6464eac60da96345513964', 1, 'no_image.jpg', 1, '2022-02-28 10:59:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id` int(11) NOT NULL,
  `nombre_vehiculo` varchar(100) NOT NULL,
  `id_tipo_vehiculo` int(11) NOT NULL,
  `marca` varchar(255) NOT NULL,
  `modelo` varchar(255) NOT NULL,
  `anio` varchar(5) NOT NULL,
  `no_serie` varchar(100) NOT NULL,
  `color` varchar(255) NOT NULL,
  `placas` varchar(255) NOT NULL,
  `motor` varchar(255) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `observaciones` varchar(500) DEFAULT NULL,
  `kilometraje` varchar(120) NOT NULL,
  `ultimo_servicio` date DEFAULT NULL,
  `proximo_servicio` date DEFAULT NULL,
  `estatus_vehiculo` int(11) NOT NULL,
  `media_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detalle_usuario_idx` (`id_detalle_usuario`),
  ADD KEY `fk_componente_idx` (`id_componente`);

--
-- Indices de la tabla `asignaciones_vehiculos`
--
ALTER TABLE `asignaciones_vehiculos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_vehiculo` (`id_vehiculo`,`id_detalle_usuario`),
  ADD KEY `asignaciones_vehiculos_ibfk_2` (`id_detalle_usuario`);

--
-- Indices de la tabla `capacitaciones`
--
ALTER TABLE `capacitaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cargos`
--
ALTER TABLE `cargos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_area_idx` (`id_area`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `componentes`
--
ALTER TABLE `componentes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_categoria_idx` (`id_categoria`);

--
-- Indices de la tabla `convenios`
--
ALTER TABLE `convenios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalles_usuario`
--
ALTER TABLE `detalles_usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cargo_idx` (`id_cargo`);

--
-- Indices de la tabla `fichas`
--
ALTER TABLE `fichas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `folios`
--
ALTER TABLE `folios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `grupo_usuarios`
--
ALTER TABLE `grupo_usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nivel_grupo_UNIQUE` (`nivel_grupo`);

--
-- Indices de la tabla `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `orientacion_canalizacion`
--
ALTER TABLE `orientacion_canalizacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo_solicitud` (`tipo_solicitud`) USING BTREE,
  ADD KEY `id_creador` (`id_creador`);

--
-- Indices de la tabla `resguardos`
--
ALTER TABLE `resguardos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_asignacion_idx` (`id_asignacion`);

--
-- Indices de la tabla `resguardos_vehiculos`
--
ALTER TABLE `resguardos_vehiculos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_asignacion_vehiculo` (`id_asignacion_vehiculo`);

--
-- Indices de la tabla `tipo_orien_canal`
--
ALTER TABLE `tipo_orien_canal`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_vehiculo`
--
ALTER TABLE `tipo_vehiculo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk_detalle_user_idx` (`id_detalle_user`),
  ADD KEY `fk_user_level_idx` (`user_level`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tipo_vehiculo` (`id_tipo_vehiculo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `area`
--
ALTER TABLE `area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `asignaciones_vehiculos`
--
ALTER TABLE `asignaciones_vehiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `capacitaciones`
--
ALTER TABLE `capacitaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cargos`
--
ALTER TABLE `cargos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `componentes`
--
ALTER TABLE `componentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `convenios`
--
ALTER TABLE `convenios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalles_usuario`
--
ALTER TABLE `detalles_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `fichas`
--
ALTER TABLE `fichas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `folios`
--
ALTER TABLE `folios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `grupo_usuarios`
--
ALTER TABLE `grupo_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `orientacion_canalizacion`
--
ALTER TABLE `orientacion_canalizacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `resguardos`
--
ALTER TABLE `resguardos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `resguardos_vehiculos`
--
ALTER TABLE `resguardos_vehiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_orien_canal`
--
ALTER TABLE `tipo_orien_canal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_vehiculo`
--
ALTER TABLE `tipo_vehiculo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  ADD CONSTRAINT `fk_componente` FOREIGN KEY (`id_componente`) REFERENCES `componentes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_usuario` FOREIGN KEY (`id_detalle_usuario`) REFERENCES `detalles_usuario` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `asignaciones_vehiculos`
--
ALTER TABLE `asignaciones_vehiculos`
  ADD CONSTRAINT `asignaciones_vehiculos_ibfk_1` FOREIGN KEY (`id_vehiculo`) REFERENCES `vehiculos` (`id`),
  ADD CONSTRAINT `asignaciones_vehiculos_ibfk_2` FOREIGN KEY (`id_detalle_usuario`) REFERENCES `detalles_usuario` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cargos`
--
ALTER TABLE `cargos`
  ADD CONSTRAINT `fk_area` FOREIGN KEY (`id_area`) REFERENCES `area` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `componentes`
--
ALTER TABLE `componentes`
  ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalles_usuario`
--
ALTER TABLE `detalles_usuario`
  ADD CONSTRAINT `fk_cargo` FOREIGN KEY (`id_cargo`) REFERENCES `cargos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `orientacion_canalizacion`
--
ALTER TABLE `orientacion_canalizacion`
  ADD CONSTRAINT `orientacion_canalizacion_ibfk_1` FOREIGN KEY (`tipo_solicitud`) REFERENCES `tipo_orien_canal` (`id`),
  ADD CONSTRAINT `orientacion_canalizacion_ibfk_2` FOREIGN KEY (`tipo_solicitud`) REFERENCES `tipo_orien_canal` (`id`),
  ADD CONSTRAINT `orientacion_canalizacion_ibfk_3` FOREIGN KEY (`id_creador`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `resguardos`
--
ALTER TABLE `resguardos`
  ADD CONSTRAINT `fk_asignacion` FOREIGN KEY (`id_asignacion`) REFERENCES `asignaciones` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `resguardos_vehiculos`
--
ALTER TABLE `resguardos_vehiculos`
  ADD CONSTRAINT `resguardos_vehiculos_ibfk_1` FOREIGN KEY (`id_asignacion_vehiculo`) REFERENCES `asignaciones_vehiculos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_detalle_user` FOREIGN KEY (`id_detalle_user`) REFERENCES `detalles_usuario` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_level` FOREIGN KEY (`user_level`) REFERENCES `grupo_usuarios` (`nivel_grupo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD CONSTRAINT `vehiculos_ibfk_1` FOREIGN KEY (`id_tipo_vehiculo`) REFERENCES `tipo_vehiculo` (`id`) ON DELETE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
