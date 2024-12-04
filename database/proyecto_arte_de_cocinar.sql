-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-12-2024 a las 21:27:04
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
-- Base de datos: `proyecto_arte_de_cocinar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anuncios_art_co_v1`
--

CREATE TABLE `anuncios_art_co_v1` (
  `anuncio_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `descripcion_anuncio` longtext NOT NULL,
  `vigencia` date NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `anuncios_art_co_v1`
--

INSERT INTO `anuncios_art_co_v1` (`anuncio_id`, `user_id`, `descripcion_anuncio`, `vigencia`, `created_at`) VALUES
(1, 7, 'Esto es una prueba', '2024-12-04', '2024-12-03 20:20:19'),
(2, 7, 'Esto es una prueba', '2024-12-04', '2024-12-03 20:21:32'),
(3, 7, 'Esto es una prueba', '2024-12-04', '2024-12-03 20:22:04'),
(4, 7, 'Esto es una prueba', '2024-12-04', '2024-12-03 20:23:49'),
(5, 7, 'Esto es una prueba', '2024-12-04', '2024-12-03 20:24:25'),
(6, 7, 'Esto es una prueba', '2024-12-04', '2024-12-03 20:24:25'),
(7, 7, 'Esto es una prueba', '2024-12-04', '2024-12-03 20:24:31'),
(8, 7, 'Esto es una prueba', '2024-12-04', '2024-12-03 20:24:55'),
(9, 7, 'Esto es una prueba', '2024-12-04', '2024-12-03 20:25:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_art_co_v1`
--

CREATE TABLE `categoria_art_co_v1` (
  `categoria_id` int(11) NOT NULL,
  `name_category` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria_art_co_v1`
--

INSERT INTO `categoria_art_co_v1` (`categoria_id`, `name_category`) VALUES
(1, 'Ensaladas'),
(2, 'Bebidas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa_art_co_v1`
--

CREATE TABLE `empresa_art_co_v1` (
  `empresa_id` int(11) NOT NULL,
  `nameEmpresa` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresa_art_co_v1`
--

INSERT INTO `empresa_art_co_v1` (`empresa_id`, `nameEmpresa`) VALUES
(1, 'ARTE DE COCINAR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa_details`
--

CREATE TABLE `empresa_details` (
  `idempresa_details` int(11) NOT NULL,
  `empresa_id` int(11) NOT NULL,
  `CIF_empresa` varchar(45) NOT NULL,
  `direccion_empresa` longtext NOT NULL,
  `numero_empresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingredientes_art_co_v1`
--

CREATE TABLE `ingredientes_art_co_v1` (
  `ingredientes_id` int(11) NOT NULL,
  `name_ingrediente` varchar(255) NOT NULL,
  `stock_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingredientes_stock`
--

CREATE TABLE `ingredientes_stock` (
  `stock_id` int(11) NOT NULL,
  `cantidad_stock` int(11) NOT NULL,
  `expires_day_stock` date NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_art_co_v1`
--

CREATE TABLE `pedidos_art_co_v1` (
  `pedido_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fecha_pedido` datetime NOT NULL,
  `total_pedido` double NOT NULL,
  `iva_pedido` int(11) DEFAULT 21,
  `total_iva` double DEFAULT NULL,
  `estado_pedido` int(11) DEFAULT 1 COMMENT '1 Pendiente / 2 En Proceso / 3 Cancelado / 4 Finalizado',
  `stripe_id` longtext DEFAULT NULL,
  `estado_preparacion` int(11) DEFAULT 1 COMMENT '1 = Recibido / 2 = En Preparación / 3 = Enviado / 4 = Entregado',
  `tipo_entrega` tinyint(4) DEFAULT 1 COMMENT '1 Recogida / 2 A domicilio'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos_art_co_v1`
--

INSERT INTO `pedidos_art_co_v1` (`pedido_id`, `user_id`, `fecha_pedido`, `total_pedido`, `iva_pedido`, `total_iva`, `estado_pedido`, `stripe_id`, `estado_preparacion`, `tipo_entrega`) VALUES
(1, 7, '2024-10-20 19:19:37', 7.26, 21, NULL, 1, NULL, 1, 1),
(2, 7, '2024-10-20 19:21:36', 7.26, 21, NULL, 1, NULL, 1, 1),
(3, 7, '2024-10-20 19:22:48', 7.26, 21, NULL, 1, NULL, 1, 1),
(4, 7, '2024-10-20 19:23:03', 7.26, 21, NULL, 1, NULL, 1, 1),
(5, 7, '2024-10-20 19:23:30', 7.26, 21, NULL, 1, NULL, 1, 1),
(6, 7, '2024-10-20 19:24:10', 7.26, 21, NULL, 1, NULL, 1, 1),
(7, 7, '2024-10-20 19:24:16', 7.26, 21, NULL, 1, NULL, 1, 1),
(8, 7, '2024-10-20 19:24:47', 7.26, 21, NULL, 1, NULL, 1, 1),
(9, 7, '2024-10-20 19:46:50', 7.26, 21, NULL, 1, NULL, 1, 1),
(10, 7, '2024-10-20 19:47:02', 7.26, 21, NULL, 1, NULL, 1, 1),
(11, 7, '2024-10-20 19:47:57', 7.26, 21, NULL, 1, NULL, 1, 1),
(12, 7, '2024-10-20 19:49:08', 7.26, 21, NULL, 1, NULL, 1, 1),
(13, 7, '2024-10-20 19:50:49', 3.025, 21, NULL, 1, NULL, 1, 1),
(14, 7, '2024-10-20 19:51:29', 3.025, 21, NULL, 1, NULL, 1, 1),
(15, 7, '2024-10-20 19:52:13', 3.025, 21, NULL, 1, NULL, 1, 1),
(16, 7, '2024-10-20 19:52:39', 3.025, 21, NULL, 1, NULL, 1, 1),
(17, 7, '2024-10-20 19:54:11', 3.025, 21, NULL, 1, NULL, 1, 1),
(18, 7, '2024-10-20 19:55:12', 3.025, 21, NULL, 1, NULL, 1, 1),
(19, 7, '2024-10-20 19:55:36', 3.025, 21, NULL, 1, NULL, 1, 1),
(20, 7, '2024-10-20 19:56:58', 3.025, 21, NULL, 1, NULL, 1, 1),
(21, 7, '2024-10-20 19:57:13', 3.025, 21, NULL, 1, NULL, 1, 1),
(22, 7, '2024-10-20 19:58:23', 3.025, 21, NULL, 1, NULL, 1, 1),
(23, 7, '2024-10-20 19:59:33', 4.235, 21, NULL, 1, NULL, 1, 1),
(24, 7, '2024-10-20 20:01:05', 4.235, 21, NULL, 1, NULL, 1, 1),
(25, 7, '2024-10-20 20:28:40', 3.025, 21, NULL, 1, 'pi_3QC3roRw3Ybmso9w12rJPzJj', 1, 1),
(26, 7, '2024-10-20 20:30:27', 3.025, 21, NULL, 4, 'pi_3QC3tXRw3Ybmso9w0bn0tff0', 4, 1),
(27, 7, '2024-10-20 20:55:10', 6.05, 21, NULL, 1, 'pi_3QC4HSRw3Ybmso9w03Vm753v', 1, 1),
(28, 7, '2024-10-20 20:55:24', 6.05, 21, NULL, 1, 'pi_3QC4HfRw3Ybmso9w1fHpsXET', 1, 1),
(29, 7, '2024-10-20 21:09:11', 6.05, 21, NULL, 1, 'pi_3QC4V0Rw3Ybmso9w1CxrBgz1', 1, 1),
(30, 7, '2024-10-20 21:09:35', 6.05, 21, NULL, 1, 'pi_3QC4VORw3Ybmso9w05GmWCFO', 1, 1),
(31, 7, '2024-10-20 21:10:01', 6.05, 21, NULL, 1, 'pi_3QC4VoRw3Ybmso9w1WFEzwqM', 1, 1),
(32, 7, '2024-10-20 21:10:14', 6.05, 21, NULL, 1, 'pi_3QC4W1Rw3Ybmso9w14ZIxINp', 1, 1),
(33, 7, '2024-10-20 21:10:40', 6.05, 21, NULL, 4, 'pi_3QC4WRRw3Ybmso9w0EfAe6g2', 1, 1),
(34, 7, '2024-11-03 19:05:11', 13.31, 2, NULL, 1, 'pi_3QH8AmRw3Ybmso9w0olNmuQy', 1, 1),
(35, 7, '2024-11-03 19:05:25', 13.31, 2, NULL, 4, 'pi_3QH8B0Rw3Ybmso9w18Iicl1s', 1, 1),
(36, 7, '2024-11-03 19:07:53', 13.31, 2, NULL, 4, 'pi_3QH8DNRw3Ybmso9w0zAYeWdY', 1, 1),
(37, 7, '2024-11-03 19:08:28', 13.31, 2, NULL, 4, 'pi_3QH8DwRw3Ybmso9w0NKxL5bB', 1, 1),
(38, 7, '2024-11-03 19:10:22', 13.31, 2, NULL, 4, 'pi_3QH8FmRw3Ybmso9w1oEnGX7U', 1, 1),
(39, 7, '2024-11-03 19:12:04', 13.31, 2, NULL, 4, 'pi_3QH8HQRw3Ybmso9w1MCelnXy', 1, 1),
(40, 7, '2024-11-03 19:12:28', 13.31, 2, NULL, 1, 'pi_3QH8HpRw3Ybmso9w0n8DUH8l', 1, 1),
(41, 7, '2024-11-03 19:14:36', 13.31, 2, NULL, 1, 'pi_3QH8JtRw3Ybmso9w0o5RA8ZN', 1, 1),
(42, 7, '2024-11-03 19:17:39', 13.31, 2, NULL, 1, 'pi_3QH8MpRw3Ybmso9w1sFjp3C9', 1, 1),
(43, 7, '2024-11-03 19:20:20', 13.31, 2, NULL, 1, 'pi_3QH8PQRw3Ybmso9w1xitmWgG', 1, 1),
(44, 7, '2024-11-03 19:24:20', 13.31, 2, NULL, 1, 'pi_3QH8TJRw3Ybmso9w0pxOFKj9', 1, 1),
(45, 7, '2024-11-03 19:26:49', 13.31, 2, NULL, 4, 'pi_3QH8ViRw3Ybmso9w0hg3uJC7', 1, 1),
(46, 7, '2024-11-03 19:31:16', 13.31, 2, NULL, 1, 'pi_3QH8a1Rw3Ybmso9w0iy2nriQ', 1, 1),
(47, 7, '2024-11-03 19:31:54', 13.31, 2, NULL, 4, 'pi_3QH8adRw3Ybmso9w0sQEko8E', 1, 1),
(48, 7, '2024-11-03 19:32:12', 13.31, 2, NULL, 1, 'pi_3QH8avRw3Ybmso9w0udbwX3I', 1, 1),
(49, 7, '2024-11-03 19:32:49', 13.31, 2, NULL, 1, 'pi_3QH8bWRw3Ybmso9w0yqiWfDg', 1, 1),
(50, 7, '2024-11-03 19:33:51', 13.31, 2, NULL, 3, 'pi_3QH8cWRw3Ybmso9w067cqZFi', 1, 1),
(51, 7, '2024-11-03 19:38:38', 13.31, 2, NULL, 1, 'pi_3QH8h9Rw3Ybmso9w1P0pqUWY', 1, 1),
(52, 7, '2024-11-03 19:38:47', 13.31, 2, NULL, 1, 'pi_3QH8hIRw3Ybmso9w1uASIi2a', 1, 1),
(53, 7, '2024-11-03 19:42:33', 13.31, 2, NULL, 1, 'pi_3QH8kvRw3Ybmso9w1XLyu2pa', 1, 1),
(54, 7, '2024-11-03 19:42:42', 13.31, 2, NULL, 1, 'pi_3QH8l5Rw3Ybmso9w1o6YHA0W', 1, 1),
(55, 7, '2024-11-03 19:43:22', 13.31, 2, NULL, 1, 'pi_3QH8liRw3Ybmso9w1d2ls47C', 1, 1),
(56, 7, '2024-11-03 19:45:47', 13.31, 2, NULL, 1, 'pi_3QH8o4Rw3Ybmso9w0X74m4rG', 1, 1),
(57, 7, '2024-11-03 19:46:13', 7.26, 21, NULL, 1, 'pi_3QH8oURw3Ybmso9w0KhXTpmO', 1, 1),
(58, 7, '2024-11-03 19:46:47', 7.26, 21, NULL, 1, 'pi_3QH8p2Rw3Ybmso9w1iPHB6vR', 1, 1),
(59, 7, '2024-11-03 19:48:22', 7.26, 21, NULL, 1, 'pi_3QH8qYRw3Ybmso9w1fIU5hhO', 1, 1),
(60, 7, '2024-11-03 19:49:22', 7.26, 21, NULL, 1, 'pi_3QH8rXRw3Ybmso9w0NsGcbEm', 1, 1),
(61, 7, '2024-11-03 19:52:07', 7.26, 21, NULL, 1, 'pi_3QH8uCRw3Ybmso9w0dbvVeUW', 1, 1),
(62, 7, '2024-11-03 19:52:47', 7.26, 21, NULL, 1, 'pi_3QH8uqRw3Ybmso9w1AFiHQbW', 1, 1),
(63, 7, '2024-11-03 19:53:15', 7.26, 21, NULL, 1, 'pi_3QH8vIRw3Ybmso9w1xZ1ef9B', 1, 1),
(64, 7, '2024-11-03 19:56:29', 7.26, 21, NULL, 1, 'pi_3QH8yQRw3Ybmso9w0X2WTTgI', 1, 1),
(65, 7, '2024-11-03 19:57:01', 7.26, 21, NULL, 1, 'pi_3QH8ywRw3Ybmso9w1y0BOkQj', 1, 1),
(66, 7, '2024-11-03 19:59:41', 7.26, 21, NULL, 1, 'pi_3QH91VRw3Ybmso9w0RN2PZZ6', 1, 1),
(67, 7, '2024-11-03 20:04:04', 7.26, 21, NULL, 1, 'pi_3QH95lRw3Ybmso9w0rAvPB7S', 1, 1),
(68, 7, '2024-11-03 20:04:14', 7.26, 21, NULL, 1, 'pi_3QH95vRw3Ybmso9w1YxBJjA4', 1, 1),
(69, 7, '2024-11-03 20:04:19', 7.26, 21, NULL, 1, 'pi_3QH95zRw3Ybmso9w0xlLUCO6', 1, 1),
(70, 7, '2024-11-03 20:06:28', 7.26, 21, NULL, 4, 'pi_3QH984Rw3Ybmso9w18P5ILPz', 1, 1),
(71, 7, '2024-11-03 20:08:46', 11.495, 2, NULL, 4, 'pi_3QH9AJRw3Ybmso9w0FmnJC1u', 1, 1),
(72, 7, '2024-11-03 20:15:31', 11.495, 2, NULL, 4, 'pi_3QH9GqRw3Ybmso9w0jqqCsUu', 1, 1),
(73, 7, '2024-11-03 20:17:59', 11.495, 2, NULL, 4, 'pi_3QH9JERw3Ybmso9w1H6fkieB', 1, 1),
(74, 7, '2024-11-03 20:23:22', 11.495, 2, NULL, 4, 'pi_3QH9ORRw3Ybmso9w168jzRHu', 1, 1),
(75, 7, '2024-11-03 20:28:07', 11.495, 2, NULL, 4, 'pi_3QH9T2Rw3Ybmso9w157RT0Wi', 1, 1),
(76, 7, '2024-11-03 20:30:11', 7.26, 21, NULL, 4, 'pi_3QH9V2Rw3Ybmso9w1HDfFpNw', 1, 1),
(77, 7, '2024-11-03 20:31:37', 3.025, 21, NULL, 4, 'pi_3QH9WQRw3Ybmso9w1xKRmMzd', 1, 1),
(78, 7, '2024-11-03 20:33:07', 3.025, 21, NULL, 4, 'pi_3QH9XsRw3Ybmso9w0w3W9nsa', 1, 1),
(79, 7, '2024-11-03 20:38:57', 4.235, 21, NULL, 4, 'pi_3QH9dWRw3Ybmso9w0f56j7w4', 1, 1),
(80, 7, '2024-11-25 10:09:05', 6.05, 21, NULL, 1, 'pi_3QOyI2Rw3Ybmso9w00e6biut', 1, 1),
(81, 10, '2024-11-25 11:35:21', 26.015, 21, NULL, 4, 'pi_3QOzdVRw3Ybmso9w0MBusdd9', 1, 1),
(82, 7, '2024-12-03 19:49:11', 10.285, 21, NULL, 1, 'pi_3QS19pRw3Ybmso9w0EVqpeFy', 1, 1),
(83, 7, '2024-12-03 19:49:28', 10.285, 21, NULL, 1, 'pi_3QS1A4Rw3Ybmso9w0HkgbPe8', 1, 1),
(84, 7, '2024-12-03 19:57:59', 10.285, 21, NULL, 4, 'pi_3QS1IKRw3Ybmso9w0CDG6QWx', 4, 2),
(85, 7, '2024-12-03 20:07:40', 3.025, 0, 0.525, 4, 'pi_3QS1RgRw3Ybmso9w09P88Www', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_art_co_v1`
--

CREATE TABLE `productos_art_co_v1` (
  `product_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `name_product` varchar(255) NOT NULL,
  `precio_product` double NOT NULL,
  `descripcion_product` longtext NOT NULL,
  `product_image` longtext NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos_art_co_v1`
--

INSERT INTO `productos_art_co_v1` (`product_id`, `categoria_id`, `name_product`, `precio_product`, `descripcion_product`, `product_image`, `stock`) VALUES
(1, 2, 'Coca Cola', 2.5, 'Bebida refrescante Coca cola 500ml', 'https://www.coca-cola.com/content/dam/onexp/sv/es/brands/coca-cola/7840058006509.png', 94),
(2, 1, 'Ensalada', 3.5, '123', 'http://127.0.0.1/proyecto_arte_de_cocinar/public/assets/img/products/670ac50c545590.26433565.jpg', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_has_ingredientes`
--

CREATE TABLE `productos_has_ingredientes` (
  `products_id` int(11) NOT NULL,
  `ingredientes_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products_has_pedidos`
--

CREATE TABLE `products_has_pedidos` (
  `product_id` int(11) NOT NULL,
  `pedidos_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `products_has_pedidos`
--

INSERT INTO `products_has_pedidos` (`product_id`, `pedidos_id`, `cantidad`, `precio`) VALUES
(1, 8, 1, 2.5),
(1, 9, 1, 2.5),
(1, 10, 1, 2.5),
(1, 11, 1, 2.5),
(1, 12, 1, 2.5),
(1, 13, 1, 2.5),
(1, 14, 1, 2.5),
(1, 15, 1, 2.5),
(1, 16, 1, 2.5),
(1, 17, 1, 2.5),
(1, 18, 1, 2.5),
(1, 19, 1, 2.5),
(1, 20, 1, 2.5),
(1, 21, 1, 2.5),
(1, 22, 1, 2.5),
(1, 25, 1, 2.5),
(1, 26, 1, 2.5),
(1, 27, 2, 2.5),
(1, 28, 2, 2.5),
(1, 29, 2, 2.5),
(1, 30, 2, 2.5),
(1, 31, 2, 2.5),
(1, 32, 2, 2.5),
(1, 33, 2, 2.5),
(1, 34, 3, 2.5),
(1, 35, 3, 2.5),
(1, 36, 3, 2.5),
(1, 37, 3, 2.5),
(1, 38, 3, 2.5),
(1, 39, 3, 2.5),
(1, 40, 3, 2.5),
(1, 41, 3, 2.5),
(1, 42, 3, 2.5),
(1, 43, 3, 2.5),
(1, 44, 3, 2.5),
(1, 45, 3, 2.5),
(1, 46, 3, 2.5),
(1, 47, 3, 2.5),
(1, 48, 3, 2.5),
(1, 49, 3, 2.5),
(1, 50, 3, 2.5),
(1, 51, 3, 2.5),
(1, 52, 3, 2.5),
(1, 53, 3, 2.5),
(1, 54, 3, 2.5),
(1, 55, 3, 2.5),
(1, 56, 3, 2.5),
(1, 57, 1, 2.5),
(1, 58, 1, 2.5),
(1, 59, 1, 2.5),
(1, 60, 1, 2.5),
(1, 61, 1, 2.5),
(1, 62, 1, 2.5),
(1, 63, 1, 2.5),
(1, 64, 1, 2.5),
(1, 65, 1, 2.5),
(1, 66, 1, 2.5),
(1, 67, 1, 2.5),
(1, 68, 1, 2.5),
(1, 69, 1, 2.5),
(1, 70, 1, 2.5),
(1, 71, 1, 2.5),
(1, 72, 1, 2.5),
(1, 73, 1, 2.5),
(1, 74, 1, 2.5),
(1, 75, 1, 2.5),
(1, 76, 1, 2.5),
(1, 77, 1, 2.5),
(1, 78, 1, 2.5),
(1, 80, 2, 2.5),
(1, 81, 3, 2.5),
(1, 82, 2, 2.5),
(1, 83, 2, 2.5),
(1, 84, 2, 2.5),
(1, 85, 1, 2.5),
(2, 8, 1, 3.5),
(2, 9, 1, 3.5),
(2, 10, 1, 3.5),
(2, 11, 1, 3.5),
(2, 12, 1, 3.5),
(2, 23, 1, 3.5),
(2, 24, 1, 3.5),
(2, 34, 1, 3.5),
(2, 35, 1, 3.5),
(2, 36, 1, 3.5),
(2, 37, 1, 3.5),
(2, 38, 1, 3.5),
(2, 39, 1, 3.5),
(2, 40, 1, 3.5),
(2, 41, 1, 3.5),
(2, 42, 1, 3.5),
(2, 43, 1, 3.5),
(2, 44, 1, 3.5),
(2, 45, 1, 3.5),
(2, 46, 1, 3.5),
(2, 47, 1, 3.5),
(2, 48, 1, 3.5),
(2, 49, 1, 3.5),
(2, 50, 1, 3.5),
(2, 51, 1, 3.5),
(2, 52, 1, 3.5),
(2, 53, 1, 3.5),
(2, 54, 1, 3.5),
(2, 55, 1, 3.5),
(2, 56, 1, 3.5),
(2, 57, 1, 3.5),
(2, 58, 1, 3.5),
(2, 59, 1, 3.5),
(2, 60, 1, 3.5),
(2, 61, 1, 3.5),
(2, 62, 1, 3.5),
(2, 63, 1, 3.5),
(2, 64, 1, 3.5),
(2, 65, 1, 3.5),
(2, 66, 1, 3.5),
(2, 67, 1, 3.5),
(2, 68, 1, 3.5),
(2, 69, 1, 3.5),
(2, 70, 1, 3.5),
(2, 71, 2, 3.5),
(2, 72, 2, 3.5),
(2, 73, 2, 3.5),
(2, 74, 2, 3.5),
(2, 75, 2, 3.5),
(2, 76, 1, 3.5),
(2, 79, 1, 3.5),
(2, 81, 4, 3.5),
(2, 82, 1, 3.5),
(2, 83, 1, 3.5),
(2, 84, 1, 3.5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_art_co_v1`
--

CREATE TABLE `roles_art_co_v1` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles_art_co_v1`
--

INSERT INTO `roles_art_co_v1` (`role_id`, `role_name`) VALUES
(1, 'Admin'),
(2, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_art_co_v1`
--

CREATE TABLE `users_art_co_v1` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `name_user` varchar(100) NOT NULL,
  `lastname_user` varchar(100) NOT NULL,
  `email_user` varchar(100) NOT NULL,
  `reset_token` longtext DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL,
  `password_user` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users_art_co_v1`
--

INSERT INTO `users_art_co_v1` (`user_id`, `role_id`, `name_user`, `lastname_user`, `email_user`, `reset_token`, `token_expiry`, `password_user`, `created_at`) VALUES
(3, 1, 'Jorge!!!!!!!', 'Perez', 'jorgepc1999@gmail.com', NULL, NULL, '1234123123', '2024-09-23 07:40:34'),
(7, 1, 'Sebastian!!', 'Lopez!!', 'sebastian11yt@gmail.com', '618c21bbd1931caee276ab81760fd43337e9b76b6540f1928b52dc948097eb36', '2024-12-03 21:56:07', '$2y$10$Ic0bhMmL1WZOBVr2Y6V8A.nyq4liI0kHTsJ4iqwPJUXKAwRcBGR5i', '2024-10-01 18:58:08'),
(10, 2, 'pepe', 'pep', 'sebas.rosero.lopez@gmail.com', NULL, NULL, '$2y$10$AXUFsV8md5nCOMD7nkAlRuzgb7k9rdl0OwRp2I/aY.QjSSv.vtrh.', '2024-10-01 19:17:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_details_art_co_v1`
--

CREATE TABLE `users_details_art_co_v1` (
  `userdetail_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `direccion` longtext NOT NULL,
  `telefono` varchar(25) NOT NULL,
  `imagen` longtext DEFAULT NULL,
  `politics` tinyint(4) DEFAULT NULL,
  `ofertas` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users_details_art_co_v1`
--

INSERT INTO `users_details_art_co_v1` (`userdetail_id`, `user_id`, `direccion`, `telefono`, `imagen`, `politics`, `ofertas`) VALUES
(1, 7, 'Calle pintor', '6952589314', 'http://127.0.0.1/proyecto_arte_de_cocinar/public/assets/img/profile_pics/66fd95969f41e4.13728514.jpg', 0, 0),
(2, 10, 'calle xx', '4546546546', '', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_art_co_v1`
--

CREATE TABLE `ventas_art_co_v1` (
  `venta_id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `empresa_id` int(11) DEFAULT 1,
  `estado_venta` tinyint(4) NOT NULL COMMENT '0 = false\n1 = True',
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas_art_co_v1`
--

INSERT INTO `ventas_art_co_v1` (`venta_id`, `pedido_id`, `empresa_id`, `estado_venta`, `created_at`) VALUES
(2, 39, 1, 1, '2024-11-03 18:12:13'),
(3, 45, 1, 1, '2024-11-03 18:29:51'),
(4, 47, 1, 1, '2024-11-03 18:32:02'),
(5, 50, 1, 0, '2024-11-03 18:34:08'),
(6, 71, 1, 0, '2024-11-03 19:09:02'),
(7, 70, 1, 1, '2024-11-03 19:12:37'),
(8, 71, 1, 1, '2024-11-03 19:14:19'),
(9, 72, 1, 1, '2024-11-03 19:15:47'),
(10, 73, 1, 1, '2024-11-03 19:18:11'),
(11, 74, 1, 1, '2024-11-03 19:23:36'),
(12, 75, 1, 1, '2024-11-03 19:28:21'),
(13, 76, 1, 1, '2024-11-03 19:30:24'),
(14, 77, 1, 1, '2024-11-03 19:31:49'),
(15, 78, 1, 1, '2024-11-03 19:33:22'),
(16, 79, 1, 1, '2024-11-03 19:39:10'),
(17, 81, 1, 1, '2024-11-25 10:35:36'),
(18, 84, 1, 1, '2024-12-03 18:58:27'),
(19, 85, 1, 1, '2024-12-03 19:07:56');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `anuncios_art_co_v1`
--
ALTER TABLE `anuncios_art_co_v1`
  ADD PRIMARY KEY (`anuncio_id`),
  ADD KEY `fk_anuncios_art_co_v1_users_art_co_v11_idx` (`user_id`);

--
-- Indices de la tabla `categoria_art_co_v1`
--
ALTER TABLE `categoria_art_co_v1`
  ADD PRIMARY KEY (`categoria_id`);

--
-- Indices de la tabla `empresa_art_co_v1`
--
ALTER TABLE `empresa_art_co_v1`
  ADD PRIMARY KEY (`empresa_id`);

--
-- Indices de la tabla `empresa_details`
--
ALTER TABLE `empresa_details`
  ADD PRIMARY KEY (`idempresa_details`),
  ADD KEY `fk_empresa_details_empresa_art_co_v11_idx` (`empresa_id`);

--
-- Indices de la tabla `ingredientes_art_co_v1`
--
ALTER TABLE `ingredientes_art_co_v1`
  ADD PRIMARY KEY (`ingredientes_id`),
  ADD KEY `fk_ingredientes_art_co_v1_ingredientes_stock1_idx` (`stock_id`);

--
-- Indices de la tabla `ingredientes_stock`
--
ALTER TABLE `ingredientes_stock`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indices de la tabla `pedidos_art_co_v1`
--
ALTER TABLE `pedidos_art_co_v1`
  ADD PRIMARY KEY (`pedido_id`),
  ADD KEY `fk_pedidos_art_co_v1_users_art_co_v11_idx` (`user_id`);

--
-- Indices de la tabla `productos_art_co_v1`
--
ALTER TABLE `productos_art_co_v1`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_productos_art_co_v1_categoria_art_co_v11_idx` (`categoria_id`);

--
-- Indices de la tabla `productos_has_ingredientes`
--
ALTER TABLE `productos_has_ingredientes`
  ADD PRIMARY KEY (`products_id`,`ingredientes_id`),
  ADD KEY `fk_productos_art_co_v1_has_ingredientes_art_co_v1_ingredien_idx` (`ingredientes_id`),
  ADD KEY `fk_productos_art_co_v1_has_ingredientes_art_co_v1_productos_idx` (`products_id`);

--
-- Indices de la tabla `products_has_pedidos`
--
ALTER TABLE `products_has_pedidos`
  ADD PRIMARY KEY (`product_id`,`pedidos_id`),
  ADD KEY `fk_productos_art_co_v1_has_pedidos_art_co_v1_pedidos_art_co_idx` (`pedidos_id`),
  ADD KEY `fk_productos_art_co_v1_has_pedidos_art_co_v1_productos_art__idx` (`product_id`);

--
-- Indices de la tabla `roles_art_co_v1`
--
ALTER TABLE `roles_art_co_v1`
  ADD PRIMARY KEY (`role_id`);

--
-- Indices de la tabla `users_art_co_v1`
--
ALTER TABLE `users_art_co_v1`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `fk_users_art_co_v1_roles_art_co_v11_idx` (`role_id`);

--
-- Indices de la tabla `users_details_art_co_v1`
--
ALTER TABLE `users_details_art_co_v1`
  ADD PRIMARY KEY (`userdetail_id`),
  ADD KEY `fk_users_details_art_co_v1_users_art_co_v11_idx` (`user_id`);

--
-- Indices de la tabla `ventas_art_co_v1`
--
ALTER TABLE `ventas_art_co_v1`
  ADD PRIMARY KEY (`venta_id`),
  ADD KEY `fk_ventas_art_co_v1_pedidos_art_co_v11_idx` (`pedido_id`),
  ADD KEY `fk_ventas_art_co_v1_empresa_art_co_v11_idx` (`empresa_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `anuncios_art_co_v1`
--
ALTER TABLE `anuncios_art_co_v1`
  MODIFY `anuncio_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `categoria_art_co_v1`
--
ALTER TABLE `categoria_art_co_v1`
  MODIFY `categoria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `empresa_art_co_v1`
--
ALTER TABLE `empresa_art_co_v1`
  MODIFY `empresa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `empresa_details`
--
ALTER TABLE `empresa_details`
  MODIFY `idempresa_details` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ingredientes_art_co_v1`
--
ALTER TABLE `ingredientes_art_co_v1`
  MODIFY `ingredientes_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ingredientes_stock`
--
ALTER TABLE `ingredientes_stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos_art_co_v1`
--
ALTER TABLE `pedidos_art_co_v1`
  MODIFY `pedido_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT de la tabla `productos_art_co_v1`
--
ALTER TABLE `productos_art_co_v1`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `roles_art_co_v1`
--
ALTER TABLE `roles_art_co_v1`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `users_art_co_v1`
--
ALTER TABLE `users_art_co_v1`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `users_details_art_co_v1`
--
ALTER TABLE `users_details_art_co_v1`
  MODIFY `userdetail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ventas_art_co_v1`
--
ALTER TABLE `ventas_art_co_v1`
  MODIFY `venta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `anuncios_art_co_v1`
--
ALTER TABLE `anuncios_art_co_v1`
  ADD CONSTRAINT `fk_anuncios_art_co_v1_users_art_co_v11` FOREIGN KEY (`user_id`) REFERENCES `users_art_co_v1` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `empresa_details`
--
ALTER TABLE `empresa_details`
  ADD CONSTRAINT `fk_empresa_details_empresa_art_co_v11` FOREIGN KEY (`empresa_id`) REFERENCES `empresa_art_co_v1` (`empresa_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ingredientes_art_co_v1`
--
ALTER TABLE `ingredientes_art_co_v1`
  ADD CONSTRAINT `fk_ingredientes_art_co_v1_ingredientes_stock1` FOREIGN KEY (`stock_id`) REFERENCES `ingredientes_stock` (`stock_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pedidos_art_co_v1`
--
ALTER TABLE `pedidos_art_co_v1`
  ADD CONSTRAINT `fk_pedidos_art_co_v1_users_art_co_v11` FOREIGN KEY (`user_id`) REFERENCES `users_art_co_v1` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `productos_art_co_v1`
--
ALTER TABLE `productos_art_co_v1`
  ADD CONSTRAINT `fk_productos_art_co_v1_categoria_art_co_v11` FOREIGN KEY (`categoria_id`) REFERENCES `categoria_art_co_v1` (`categoria_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `productos_has_ingredientes`
--
ALTER TABLE `productos_has_ingredientes`
  ADD CONSTRAINT `fk_productos_art_co_v1_has_ingredientes_art_co_v1_ingrediente1` FOREIGN KEY (`ingredientes_id`) REFERENCES `ingredientes_art_co_v1` (`ingredientes_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_productos_art_co_v1_has_ingredientes_art_co_v1_productos_a1` FOREIGN KEY (`products_id`) REFERENCES `productos_art_co_v1` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `products_has_pedidos`
--
ALTER TABLE `products_has_pedidos`
  ADD CONSTRAINT `fk_productos_art_co_v1_has_pedidos_art_co_v1_pedidos_art_co_v11` FOREIGN KEY (`pedidos_id`) REFERENCES `pedidos_art_co_v1` (`pedido_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_productos_art_co_v1_has_pedidos_art_co_v1_productos_art_co1` FOREIGN KEY (`product_id`) REFERENCES `productos_art_co_v1` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `users_art_co_v1`
--
ALTER TABLE `users_art_co_v1`
  ADD CONSTRAINT `fk_users_art_co_v1_roles_art_co_v11` FOREIGN KEY (`role_id`) REFERENCES `roles_art_co_v1` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `users_details_art_co_v1`
--
ALTER TABLE `users_details_art_co_v1`
  ADD CONSTRAINT `fk_users_details_art_co_v1_users_art_co_v11` FOREIGN KEY (`user_id`) REFERENCES `users_art_co_v1` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ventas_art_co_v1`
--
ALTER TABLE `ventas_art_co_v1`
  ADD CONSTRAINT `fk_ventas_art_co_v1_empresa_art_co_v11` FOREIGN KEY (`empresa_id`) REFERENCES `empresa_art_co_v1` (`empresa_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ventas_art_co_v1_pedidos_art_co_v11` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos_art_co_v1` (`pedido_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
