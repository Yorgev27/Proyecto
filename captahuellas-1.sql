-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-05-2020 a las 17:51:31
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `captahuellas`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `imprimir_personal` ()  SELECT * FROM personal ORDER BY id desc$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admins`
--

CREATE TABLE `admins` (
  `Id_admin` int(255) NOT NULL,
  `nombre` varchar(50) DEFAULT 'admin',
  `password` varchar(33) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `foto` varchar(55) NOT NULL DEFAULT 'default.jpg',
  `privilegio` enum('administrador','asistAdmin','recursoshumanos','seguridad') NOT NULL DEFAULT 'administrador',
  `fecha_registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `statusAdmin` enum('activo','desactivado') NOT NULL DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `admins`
--

INSERT INTO `admins` (`Id_admin`, `nombre`, `password`, `correo`, `foto`, `privilegio`, `fecha_registro`, `statusAdmin`) VALUES
(1, 'jorbi', 'Sumagro01', 'jorbinogales@gmail.com', 'default.jpg', 'administrador', '2020-05-09 16:42:52', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `id_cargo` int(255) NOT NULL,
  `nombre` varchar(55) NOT NULL,
  `icono` varchar(55) NOT NULL,
  `creado_por` varchar(55) NOT NULL,
  `editado_por` varchar(55) NOT NULL DEFAULT 'null',
  `estado` enum('activo','eliminado') NOT NULL DEFAULT 'activo',
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_edicion` datetime DEFAULT NULL,
  `max_faltas` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cargo`
--

INSERT INTO `cargo` (`id_cargo`, `nombre`, `icono`, `creado_por`, `editado_por`, `estado`, `fecha`, `fecha_edicion`, `max_faltas`) VALUES
(1, 'Estudiante', 'icon-user', 'jorbinogales@gmail.com', 'null', 'activo', '2020-05-11 15:46:11', NULL, 3),
(2, 'Docente', 'icon-graduation-cap', 'jorbinogales@gmail.com', 'null', 'activo', '2020-05-11 15:46:23', NULL, 5),
(3, 'Administrativo', 'icon-archive-1', 'jorbinogales@gmail.com', 'jorbinogales@gmail.com', 'activo', '2020-05-11 15:46:35', '2020-05-19 22:28:53', 5),
(7, 'Obrero', 'icon-msn-messenger', 'jorbinogales@gmail.com', 'jorbinogales@gmail.com', 'activo', '2020-05-11 15:49:41', '2020-05-20 18:57:24', 3),
(9, 'Transportista', 'icon-taxi', 'jorbinogales@gmail.com', 'null', 'eliminado', '2020-05-15 21:05:06', NULL, 3),
(15, 'Vigilante', 'icon-zynga', 'jorbinogales@gmail.com', 'null', 'activo', '2020-05-18 09:47:54', NULL, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `faltas`
--

CREATE TABLE `faltas` (
  `id_falta` int(255) NOT NULL,
  `id_personal` int(255) NOT NULL,
  `razon` varchar(255) NOT NULL,
  `cantidad` int(255) NOT NULL,
  `fecha_falta` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` enum('activo','eliminado') NOT NULL DEFAULT 'activo',
  `admin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `faltas`
--

INSERT INTO `faltas` (`id_falta`, `id_personal`, `razon`, `cantidad`, `fecha_falta`, `estado`, `admin`) VALUES
(23, 1012, 'dasda', 1, '2020-05-20 14:53:27', 'eliminado', 'jorbinogales@gmail.com'),
(24, 1012, 'dasda', 1, '2020-05-20 14:57:17', 'eliminado', 'jorbinogales@gmail.com'),
(25, 1, 'zapatos rotos', 2, '2020-05-20 14:57:46', 'eliminado', 'jorbinogales@gmail.com'),
(26, 1344, 'Estaba teniendo sexo en la oficina', 2, '2020-05-20 14:58:08', 'eliminado', 'jorbinogales@gmail.com'),
(27, 1344, 'Cogia nuevamente en la oficina', 1, '2020-05-20 15:40:22', 'activo', 'jorbinogales@gmail.com'),
(28, 1344, 'tiene las tetas muy grandes', 1, '2020-05-20 17:09:47', 'activo', 'jorbinogales@gmail.com'),
(29, 1, 'Se masturbaba en clases', 1, '2020-05-21 09:21:24', 'activo', 'jorbinogales@gmail.com'),
(30, 5167, 'Por alguna extraña razon se peleo con un miliciano', 1, '2020-05-21 15:29:29', 'eliminado', 'jorbinogales@gmail.com'),
(31, 5167, 'Por alguna razon insulto a un miliciano', 1, '2020-05-21 15:30:35', 'eliminado', 'jorbinogales@gmail.com'),
(32, 5167, 'Por alguna extrana razon insulto a un miliciano', 1, '2020-05-21 15:34:58', 'activo', 'jorbinogales@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historico_huella`
--

CREATE TABLE `historico_huella` (
  `id_historico` int(255) NOT NULL,
  `Logid` int(255) NOT NULL,
  `id_huella` int(255) NOT NULL,
  `fecha_entrada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` enum('activo','eliminado') NOT NULL DEFAULT 'activo',
  `entro_salio` enum('entro','salio') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `historico_huella`
--

INSERT INTO `historico_huella` (`id_historico`, `Logid`, `id_huella`, `fecha_entrada`, `estado`, `entro_salio`) VALUES
(1, 94841, 5167, '2020-05-21 13:39:51', 'activo', 'salio'),
(2, 94840, 1, '2020-05-21 13:39:13', 'activo', 'entro'),
(3, 94839, 1, '2020-05-21 13:39:12', 'activo', 'salio'),
(4, 94847, 5225, '2020-05-21 22:55:33', 'activo', 'entro'),
(5, 94846, 5167, '2020-05-21 22:55:27', 'activo', 'entro'),
(6, 94845, 5046, '2020-05-21 22:55:25', 'activo', 'entro'),
(7, 94844, 1567, '2020-05-21 22:55:23', 'activo', 'entro'),
(8, 94843, 1344, '2020-05-21 22:55:21', 'activo', 'entro'),
(9, 94842, 1012, '2020-05-21 22:55:17', 'activo', 'entro'),
(10, 94848, 1, '2020-05-21 22:55:39', 'activo', 'entro'),
(19, 94850, 1000, '2020-05-28 09:54:18', 'activo', 'entro'),
(20, 94849, 1129, '2020-05-28 09:49:06', 'activo', 'entro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `id_huella` int(255) NOT NULL,
  `id_personal` int(255) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `cedula` varchar(50) DEFAULT NULL,
  `foto` varchar(55) NOT NULL DEFAULT 'default.jpg',
  `cargo` int(255) DEFAULT NULL,
  `faltas` int(5) DEFAULT '0',
  `fecha_registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `bloqueado` enum('bloqueado','desbloqueado') NOT NULL DEFAULT 'desbloqueado',
  `entro_salio` enum('entro','salio') NOT NULL DEFAULT 'salio',
  `estado` enum('activo','eliminado','esperando','descartado') NOT NULL DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`id_huella`, `id_personal`, `nombre`, `cedula`, `foto`, `cargo`, `faltas`, `fecha_registro`, `bloqueado`, `entro_salio`, `estado`) VALUES
(1, 1, 'MARCO BARAHONA', '4725202', '1.jpg', 1, 2, '2020-05-19 22:25:30', 'desbloqueado', 'entro', 'activo'),
(1000, 2, 'SARA TANCREDY', '12512521', '1000.jpg', 1, 0, '2020-05-19 22:27:18', 'desbloqueado', 'entro', 'activo'),
(1012, 3, 'RICHARD BARAHONA', '152551215', '1012.jpg', 1, 0, '2020-05-19 22:27:41', 'bloqueado', 'salio', 'activo'),
(1129, 4, 'SIMON COLINA', '9808015212', '1129.jpg', 2, 0, '2020-05-19 22:28:08', 'desbloqueado', 'entro', 'activo'),
(1344, 5, 'YODAINY COLMENARES', '15125211', '1344.jpg', 3, 2, '2020-05-19 22:28:35', 'desbloqueado', 'entro', 'activo'),
(1567, 6, 'YETSENIA PEREZ     ', NULL, 'default.jpg', NULL, 0, '2020-05-18 10:04:10', 'desbloqueado', 'entro', 'descartado'),
(5046, 7, 'YARAURY MARQUEZ', '787979879', 'default.jpg', 1, 0, '2020-05-20 09:44:00', 'desbloqueado', 'entro', 'activo'),
(5167, 8, 'CRISTINA VASQUEZ', '251251', '5167.jpg', 1, 1, '2020-05-21 15:17:58', 'desbloqueado', 'entro', 'activo'),
(5205508, 9, 'SERGIO NOGUERA', '315125', '5205508.jpg', 7, 0, '2020-05-21 09:20:47', 'desbloqueado', 'salio', 'activo'),
(5205570, 10, 'Sergio Kis', NULL, 'default.jpg', NULL, 0, '2020-05-18 10:04:13', 'desbloqueado', 'salio', 'esperando'),
(5225, 11, 'HEIDY DE ARMAS ', NULL, 'default.jpg', NULL, 0, '2020-05-18 10:04:15', 'desbloqueado', 'entro', 'esperando'),
(70002, 12, 'SANCHEZ AN', NULL, 'default.jpg', NULL, 0, '2020-05-18 10:04:16', 'desbloqueado', 'salio', 'esperando'),
(70018, 13, 'FLOR GUANCHEZ ', NULL, 'default.jpg', NULL, 0, '2020-05-18 10:04:17', 'desbloqueado', 'salio', 'esperando'),
(7012, 14, 'YELITZA GUILLEN YE', NULL, 'default.jpg', NULL, 0, '2020-05-18 10:04:17', 'desbloqueado', 'salio', 'esperando'),
(7015, 15, 'ANTONIETA GONZALES', NULL, 'default.jpg', NULL, 0, '2020-05-18 10:11:46', 'desbloqueado', 'salio', 'esperando'),
(7016, 16, 'NAUDY NOMEACUERDO', NULL, 'default.jpg', NULL, 0, '2020-05-18 10:11:47', 'desbloqueado', 'salio', 'esperando'),
(7017, 17, 'DANIEL LINARZ', NULL, 'default.jpg', NULL, 0, '2020-05-18 10:11:48', 'desbloqueado', 'salio', 'esperando'),
(7013, 18, 'JORBI NOGALES', NULL, 'default.jpg', NULL, 0, '2020-05-18 10:11:54', 'desbloqueado', 'salio', 'esperando'),
(7014, 19, 'ANGEL CHAVEZ', NULL, 'default.jpg', NULL, 0, '2020-05-18 10:11:57', 'desbloqueado', 'salio', 'esperando'),
(7018, 20, 'WIKIWIKI', NULL, 'default.jpg', NULL, 0, '2020-05-21 11:25:11', 'desbloqueado', 'salio', 'esperando'),
(7019, 21, 'SUMAGRO', NULL, 'default.jpg', NULL, 0, '2020-05-21 11:25:11', 'desbloqueado', 'salio', 'esperando'),
(7020, 22, 'FILIPINAS', NULL, 'default.jpg', NULL, 0, '2020-05-21 11:27:44', 'desbloqueado', 'salio', 'esperando'),
(7021, 23, 'SUMAGRO2', NULL, 'default.jpg', NULL, 0, '2020-05-21 11:28:36', 'desbloqueado', 'salio', 'esperando');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_bloqueos`
--

CREATE TABLE `personal_bloqueos` (
  `id_bloqueo` int(255) NOT NULL,
  `id_personal` int(255) NOT NULL,
  `razon` varchar(50) NOT NULL,
  `fecha` datetime NOT NULL,
  `fecha_desbloqueo` datetime NOT NULL,
  `admin_bloqueo` int(255) NOT NULL,
  `statusBloqueo` enum('activo','desactivado') NOT NULL DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vitacora`
--

CREATE TABLE `vitacora` (
  `id` int(255) NOT NULL,
  `admin` varchar(55) NOT NULL,
  `movimiento` enum('registro_personal','registro_admins','eliminar_personal','eliminar_admin','editar_personal','editar_admin','registro_cargo','editar_cargo','eliminar_cargo','registro_faltas','eliminar_faltas','eliminar_entrada','bloquear_personal','desbloquear_personal','descartar_personal','editar_faltas') NOT NULL,
  `testigo` int(55) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `vitacora`
--

INSERT INTO `vitacora` (`id`, `admin`, `movimiento`, `testigo`, `fecha`) VALUES
(1, 'jorbinogales@gmail.com', 'editar_cargo', 0, '2020-05-18 09:43:12'),
(2, 'jorbinogales@gmail.com', 'registro_cargo', 0, '2020-05-18 09:47:54'),
(3, 'jorbinogales@gmail.com', 'registro_personal', 0, '2020-05-18 10:08:22'),
(4, 'jorbinogales@gmail.com', 'eliminar_cargo', 0, '2020-05-19 21:56:33'),
(5, 'jorbinogales@gmail.com', 'eliminar_cargo', 0, '2020-05-19 21:59:49'),
(6, 'jorbinogales@gmail.com', 'eliminar_cargo', 0, '2020-05-19 22:02:28'),
(7, 'jorbinogales@gmail.com', 'eliminar_cargo', 0, '2020-05-19 22:02:50'),
(8, 'jorbinogales@gmail.com', 'eliminar_cargo', 0, '2020-05-19 22:03:01'),
(9, 'jorbinogales@gmail.com', 'eliminar_cargo', 0, '2020-05-19 22:04:19'),
(13, 'jorbinogales@gmail.com', 'eliminar_personal', 0, '2020-05-19 22:10:39'),
(14, 'jorbinogales@gmail.com', 'eliminar_personal', 0, '2020-05-19 22:21:36'),
(15, 'jorbinogales@gmail.com', 'eliminar_personal', 0, '2020-05-19 22:22:54'),
(16, 'jorbinogales@gmail.com', 'eliminar_personal', 0, '2020-05-19 22:23:20'),
(17, 'jorbinogales@gmail.com', 'eliminar_personal', 0, '2020-05-19 22:23:35'),
(18, 'jorbinogales@gmail.com', 'eliminar_personal', 0, '2020-05-19 22:23:38'),
(19, 'jorbinogales@gmail.com', 'eliminar_personal', 0, '2020-05-19 22:23:45'),
(20, 'jorbinogales@gmail.com', 'eliminar_personal', 0, '2020-05-19 22:23:57'),
(21, 'jorbinogales@gmail.com', 'eliminar_personal', 0, '2020-05-19 22:24:00'),
(22, 'jorbinogales@gmail.com', 'registro_personal', 0, '2020-05-19 22:25:31'),
(23, 'jorbinogales@gmail.com', 'registro_personal', 0, '2020-05-19 22:27:18'),
(24, 'jorbinogales@gmail.com', 'registro_personal', 0, '2020-05-19 22:27:42'),
(25, 'jorbinogales@gmail.com', 'registro_personal', 0, '2020-05-19 22:28:08'),
(26, 'jorbinogales@gmail.com', 'registro_personal', 0, '2020-05-19 22:28:35'),
(27, 'jorbinogales@gmail.com', 'editar_cargo', 0, '2020-05-19 22:28:53'),
(28, 'jorbinogales@gmail.com', 'eliminar_personal', 0, '2020-05-19 22:44:08'),
(29, 'jorbinogales@gmail.com', 'eliminar_cargo', 0, '2020-05-19 22:44:26'),
(30, 'jorbinogales@gmail.com', 'eliminar_cargo', 0, '2020-05-19 22:55:38'),
(33, 'jorbinogales@gmail.com', 'bloquear_personal', 0, '2020-05-19 23:13:37'),
(36, 'jorbinogales@gmail.com', 'desbloquear_personal', 0, '2020-05-19 23:38:11'),
(37, 'jorbinogales@gmail.com', 'bloquear_personal', 0, '2020-05-19 23:39:31'),
(38, 'jorbinogales@gmail.com', 'bloquear_personal', 0, '2020-05-19 23:42:06'),
(39, 'jorbinogales@gmail.com', 'bloquear_personal', 0, '2020-05-19 23:42:16'),
(40, 'jorbinogales@gmail.com', 'bloquear_personal', 0, '2020-05-19 23:42:23'),
(41, 'jorbinogales@gmail.com', 'desbloquear_personal', 0, '2020-05-19 23:42:37'),
(42, 'jorbinogales@gmail.com', 'bloquear_personal', 0, '2020-05-19 23:42:49'),
(43, 'jorbinogales@gmail.com', 'desbloquear_personal', 0, '2020-05-19 23:43:15'),
(44, 'jorbinogales@gmail.com', 'desbloquear_personal', 0, '2020-05-19 23:43:19'),
(45, 'jorbinogales@gmail.com', 'desbloquear_personal', 0, '2020-05-20 01:00:32'),
(46, 'jorbinogales@gmail.com', 'desbloquear_personal', 0, '2020-05-20 01:00:36'),
(47, 'jorbinogales@gmail.com', 'bloquear_personal', 0, '2020-05-20 09:26:38'),
(48, 'jorbinogales@gmail.com', 'bloquear_personal', 0, '2020-05-20 09:28:00'),
(49, 'jorbinogales@gmail.com', 'registro_personal', 0, '2020-05-20 09:44:00'),
(50, 'jorbinogales@gmail.com', 'desbloquear_personal', 0, '2020-05-20 15:28:38'),
(51, 'jorbinogales@gmail.com', 'bloquear_personal', 0, '2020-05-20 16:34:55'),
(52, 'jorbinogales@gmail.com', 'desbloquear_personal', 0, '2020-05-20 16:37:58'),
(53, 'jorbinogales@gmail.com', 'desbloquear_personal', 0, '2020-05-20 16:38:03'),
(54, 'jorbinogales@gmail.com', 'bloquear_personal', 0, '2020-05-20 16:38:07'),
(55, 'jorbinogales@gmail.com', 'desbloquear_personal', 0, '2020-05-20 16:38:12'),
(56, 'jorbinogales@gmail.com', 'bloquear_personal', 0, '2020-05-20 17:09:31'),
(57, 'jorbinogales@gmail.com', 'registro_cargo', 0, '2020-05-20 17:09:47'),
(58, 'jorbinogales@gmail.com', 'registro_personal', 0, '2020-05-20 17:10:56'),
(59, 'jorbinogales@gmail.com', 'editar_cargo', 0, '2020-05-20 18:57:25'),
(60, 'jorbinogales@gmail.com', 'bloquear_personal', 0, '2020-05-20 19:26:23'),
(61, 'jorbinogales@gmail.com', 'registro_personal', 0, '2020-05-21 09:17:07'),
(62, 'jorbinogales@gmail.com', 'registro_personal', 0, '2020-05-21 09:18:32'),
(63, 'jorbinogales@gmail.com', 'registro_personal', 0, '2020-05-21 09:20:48'),
(64, 'jorbinogales@gmail.com', 'registro_cargo', 0, '2020-05-21 09:21:24'),
(65, 'jorbinogales@gmail.com', 'desbloquear_personal', 0, '2020-05-21 09:30:53'),
(66, 'jorbinogales@gmail.com', 'bloquear_personal', 0, '2020-05-21 09:33:29'),
(67, 'jorbinogales@gmail.com', 'desbloquear_personal', 0, '2020-05-21 11:39:11'),
(68, 'jorbinogales@gmail.com', 'desbloquear_personal', 0, '2020-05-21 11:39:16'),
(77, 'jorbinogales@gmail.com', 'registro_personal', 0, '2020-05-21 15:17:59'),
(84, 'jorbinogales@gmail.com', 'registro_faltas', 0, '2020-05-21 15:34:58'),
(85, 'jorbinogales@gmail.com', 'bloquear_personal', 0, '2020-05-22 10:30:32');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`Id_admin`),
  ADD KEY `nombre` (`nombre`),
  ADD KEY `password` (`password`),
  ADD KEY `correo` (`correo`),
  ADD KEY `privilegio` (`privilegio`),
  ADD KEY `fecha_registro` (`fecha_registro`),
  ADD KEY `estado` (`statusAdmin`);

--
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id_cargo`);

--
-- Indices de la tabla `faltas`
--
ALTER TABLE `faltas`
  ADD PRIMARY KEY (`id_falta`),
  ADD KEY `id_personal` (`id_personal`),
  ADD KEY `razon` (`razon`),
  ADD KEY `fecha_falta` (`fecha_falta`);

--
-- Indices de la tabla `historico_huella`
--
ALTER TABLE `historico_huella`
  ADD PRIMARY KEY (`id_historico`),
  ADD KEY `id_huella` (`id_huella`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`id_personal`) USING BTREE,
  ADD KEY `nombre` (`nombre`),
  ADD KEY `cedula` (`cedula`),
  ADD KEY `fatas` (`faltas`),
  ADD KEY `fecha_registro` (`fecha_registro`),
  ADD KEY `bloqueado` (`bloqueado`),
  ADD KEY `status` (`entro_salio`),
  ADD KEY `status_2` (`estado`),
  ADD KEY `id_captahuella` (`id_huella`) USING BTREE,
  ADD KEY `CARGO` (`cargo`);

--
-- Indices de la tabla `personal_bloqueos`
--
ALTER TABLE `personal_bloqueos`
  ADD PRIMARY KEY (`id_bloqueo`),
  ADD KEY `cedula` (`id_personal`),
  ADD KEY `razon` (`razon`),
  ADD KEY `fecha` (`fecha`),
  ADD KEY `admin` (`admin_bloqueo`);

--
-- Indices de la tabla `vitacora`
--
ALTER TABLE `vitacora`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admins`
--
ALTER TABLE `admins`
  MODIFY `Id_admin` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id_cargo` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `faltas`
--
ALTER TABLE `faltas`
  MODIFY `id_falta` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `historico_huella`
--
ALTER TABLE `historico_huella`
  MODIFY `id_historico` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `id_personal` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `personal_bloqueos`
--
ALTER TABLE `personal_bloqueos`
  MODIFY `id_bloqueo` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `vitacora`
--
ALTER TABLE `vitacora`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `faltas`
--
ALTER TABLE `faltas`
  ADD CONSTRAINT `faltas_ibfk_1` FOREIGN KEY (`id_personal`) REFERENCES `personal` (`id_huella`);

--
-- Filtros para la tabla `historico_huella`
--
ALTER TABLE `historico_huella`
  ADD CONSTRAINT `historico_huella_ibfk_1` FOREIGN KEY (`id_huella`) REFERENCES `personal` (`id_huella`);

--
-- Filtros para la tabla `personal`
--
ALTER TABLE `personal`
  ADD CONSTRAINT `personal_ibfk_1` FOREIGN KEY (`cargo`) REFERENCES `cargo` (`id_cargo`);

--
-- Filtros para la tabla `personal_bloqueos`
--
ALTER TABLE `personal_bloqueos`
  ADD CONSTRAINT `personal_bloqueos_ibfk_1` FOREIGN KEY (`id_bloqueo`) REFERENCES `personal` (`id_personal`),
  ADD CONSTRAINT `personal_bloqueos_ibfk_2` FOREIGN KEY (`admin_bloqueo`) REFERENCES `admins` (`Id_admin`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
