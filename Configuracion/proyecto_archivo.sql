-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-08-2024 a las 07:07:03
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
-- Base de datos: `proyecto_archivo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivos`
--

CREATE TABLE `archivos` (
  `id` bigint(20) NOT NULL,
  `usuario_id` bigint(20) DEFAULT NULL,
  `nombre_archivo` text NOT NULL,
  `creado_el` timestamp NOT NULL DEFAULT current_timestamp(),
  `modificado_el` timestamp NOT NULL DEFAULT current_timestamp(),
  `modificado_por` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `archivos`
--

INSERT INTO `archivos` (`id`, `usuario_id`, `nombre_archivo`, `creado_el`, `modificado_el`, `modificado_por`) VALUES
(1, 1, 'nuevo_nombre', '2024-08-15 17:59:06', '2024-08-15 18:41:21', 2);

--
-- Disparadores `archivos`
--
DELIMITER $$
CREATE TRIGGER `actualizar_modificacion_archivo` BEFORE UPDATE ON `archivos` FOR EACH ROW BEGIN
  SET NEW.modificado_el = CURRENT_TIMESTAMP;
  -- Asegúrate de pasar el ID del usuario que está haciendo la modificación.
  -- Este ID debe ser establecido en el contexto de la aplicación que realiza el UPDATE.
  SET NEW.modificado_por = IFNULL(NEW.modificado_por, OLD.modificado_por);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) NOT NULL,
  `nombre` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'LECTOR'),
(2, 'ADMINISTRADOR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` bigint(20) NOT NULL,
  `usuario` text NOT NULL,
  `contrasena` text NOT NULL,
  `nombres` text NOT NULL,
  `email` text NOT NULL,
  `sucursal` enum('Neiva','Abner Lozano','Tunja','Florencia','Medifaca','Pitalito') NOT NULL,
  `rol_id` bigint(20) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL,
  `creado_por` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `actualizado_por` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `contrasena`, `nombres`, `email`, `sucursal`, `rol_id`, `estado`, `creado_por`, `created_at`, `actualizado_por`, `updated_at`) VALUES
(1, 'JDGAHONAR', '1234567890', 'JUAN DAVID GAHONA RAMIREZ', 'JDGAHONAR@MEDILASER.COM.CO', 'Neiva', 2, 'Activo', 'JDGAHONAR', '2024-08-18 03:02:46', 'JDGAHONAR', '2024-08-18 14:40:02'),
(2, 'JSCABRERAS', 'Sebas0946*', 'JUAN SEBASTIAN CABRERA SALAZAR', 'jscabreras@medilaser.com.co', 'Neiva', 2, 'Activo', 'JSCABRERAS', '2024-08-18 18:57:09', 'JSCABRERAS', '2024-08-18 18:57:09'),
(7, 'dasdsa', 'edee29f882543b956620b26d0ee0e7e950399b1c4222f5de05e06425b4c995e9', 'dasdasdas', 'dadasdas', 'Neiva', 1, 'Activo', 'JSCABRERAS', '2024-08-19 05:04:53', '', '2024-08-19 05:04:53');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `archivos`
--
ALTER TABLE `archivos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `modificado_por` (`modificado_por`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`) USING HASH,
  ADD UNIQUE KEY `email` (`email`) USING HASH,
  ADD KEY `rol_id` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `archivos`
--
ALTER TABLE `archivos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
