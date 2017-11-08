-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-11-2017 a las 17:31:56
-- Versión del servidor: 10.1.28-MariaDB
-- Versión de PHP: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `core`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `agregarCita` (IN `XPACIENTE` VARCHAR(50), IN `XDESDE` VARCHAR(25), IN `XHASTA` VARCHAR(25), IN `XCELULAR` VARCHAR(100), IN `XDOCTOR` INT, IN `XTRATAMIENTO` VARCHAR(200))  BEGIN
	INSERT INTO agendas(title, desde, hasta, celular, idDoctor, tratamiento) VALUES (XPACIENTE, XDESDE, XHASTA, XCELULAR, XDOCTOR, XTRATAMIENTO);
	SELECT ROW_COUNT() AS ESTADO;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `agregarDetalleProveedor` (IN `XID_PROVEEDOR` INT, IN `XDETALLE` VARCHAR(120), IN `XMONTO` DECIMAL(5,1))  BEGIN
		INSERT INTO proveedors_detalles(idProveedor, detalle, monto) VALUES (XID_PROVEEDOR, XDETALLE, XMONTO);
		SELECT ROW_COUNT() AS ESTADO;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `agregarPresupuestoGeneral` (IN `ID_PRESUPUESTO` INT, IN `XFECHA_HORA` DATETIME, IN `XID_PACIENTE` INT, IN `XID_DOCTOR` INT, IN `XDESCUENTO` INT)  BEGIN
		INSERT INTO presupuestos(id, fechahora, idPaciente, idMedico, descuento)
			VALUES (ID_PRESUPUESTO, XFECHA_HORA, XID_PACIENTE, XID_DOCTOR, XDESCUENTO);

		SELECT ROW_COUNT() AS ESTADO;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `agregarPresupuestosDetalles` (IN `XID_PRESUPUESTO` INT, IN `XPIEZA` INT, `XSECCION` INT, IN `XSECUNO` INT, IN `XSECDOS` INT, IN `XOPCION` INT)  BEGIN
		INSERT INTO presupuestos_detalle (idPresupuesto, pieza, seccion, secUno, secDos, opcion)
		VALUES(XID_PRESUPUESTO, XPIEZA, XSECCION, XSECUNO, XSECDOS, XOPCION);

		SELECT ROW_COUNT() AS ESTADO;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `clonarTratamientosPorEmpresas` (IN `XID_EMPRESA` INT, IN `XID_TRATAMIENTO` INT, IN `XMONTO` DECIMAL)  BEGIN
	
    INSERT INTO precios (idEmpresa, idTratamiento, monto) values (XID_EMPRESA, XID_TRATAMIENTO, XMONTO);
    SELECT ROW_COUNT() AS ESTADO;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deletePrecioByEmpresaId` (IN `XID_EMPRESA` INT)  BEGIN
	DELETE FROM Precios WHERE idEmpresa = XID_EMPRESA;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deletePrecioByTratamientoId` (IN `XID_TRATAMIENTO` INT)  BEGIN
	DELETE FROM Precios WHERE idTratamiento = XID_TRATAMIENTO;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deletePresupuestoById` (IN `XID_PRESUPUESTO` INT)  BEGIN

		DELETE FROM presupuestos_detalle WHERE idPresupuesto = XID_PRESUPUESTO;

		DELETE FROM presupuestos WHERE id = XID_PRESUPUESTO;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `eliminarDetalleProveedor` (IN `XID_DPROVEEDOR` INT)  BEGIN
		DELETE FROM proveedors_detalles WHERE id = XID_DPROVEEDOR;
		SELECT ROW_COUNT() AS ESTADO;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllIngresos` ()  BEGIN

		SELECT ingresos.id as id, medicos.id as idDoctor, CONCAT(medicos.nombres, ' ', medicos.apellidos) as doctor, 
					 pacientes.id as hc, CONCAT(pacientes.nombres, ' ', pacientes.apellidos) as pacientes,					 
					 ingresos.descripcion as descripcion, ingresos.monto as monto, date(ingresos.created_at) as fecha,
					 medicos.margen_ganancia as mg
		FROM `ingresos` 
			INNER JOIN pacientes on pacientes.id = ingresos.idPaciente
			INNER JOIN medicos on medicos.id = ingresos.idMedico;

	END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getDetallePresupuesto` (IN `XID_PRESUPUESTO` INT)  BEGIN
		SELECT pieza, seccion, secUno, secDos, opcion FROM presupuestos
		INNER JOIN presupuestos_detalle on presupuestos_detalle.idPresupuesto = presupuestos.id
		WHERE presupuestos.id = XID_PRESUPUESTO;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getDetalleProveedor` (IN `XID_PROVEEDOR` INT)  BEGIN
	SELECT id, detalle, monto FROM proveedors_detalles WHERE idProveedor = XID_PROVEEDOR;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getLastNroPresupuesto` ()  BEGIN
	DECLARE NRO_PRESUPUESTO INT;
	SELECT IFNULL(id, 0) INTO NRO_PRESUPUESTO FROM presupuestos ORDER BY id DESC LIMIT 1;
    SELECT NRO_PRESUPUESTO;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getMontoByEmpresaTratamiento` (IN `XID_EMPRESA` INT, IN `XID_TRATAMIENTO` INT)  BEGIN
	DECLARE XMONTO DECIMAL;
	SELECT monto INTO XMONTO FROM precios WHERE idEmpresa = XID_EMPRESA and idTratamiento = XID_TRATAMIENTO;
    SELECT XMONTO as MONTO;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getPreciosByIdEmpresa` (IN `XID_EMPRESA` INT)  BEGIN
	SELECT precios.idTratamiento AS id, tratamientos.detalle AS nombre, precios.monto AS monto FROM precios 
    INNER JOIN tratamientos on precios.idTratamiento = tratamientos.id
    WHERE precios.idEmpresa = XID_EMPRESA;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getSearchIngresoAll` (IN `INI_DATE` DATE, IN `FIN_DATE` DATE)  BEGIN
	
	SELECT ingresos.id as id, medicos.id as idDoctor, CONCAT(medicos.nombres, ' ', medicos.apellidos) as doctor, 
					 pacientes.id as hc, CONCAT(pacientes.nombres, ' ', pacientes.apellidos) as pacientes,					 
					 ingresos.descripcion as descripcion, ingresos.monto as monto, date(ingresos.created_at) as fecha,
					 medicos.margen_ganancia as mg
		FROM `ingresos` 
			INNER JOIN pacientes on pacientes.id = ingresos.idPaciente
			INNER JOIN medicos on medicos.id = ingresos.idMedico
		WHERE 
				date(ingresos.created_at) >= INI_DATE AND date(ingresos.created_at) <= FIN_DATE;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getSearchIngresoById` (IN `INI_DATE` DATE, IN `FIN_DATE` DATE, IN `X_IDDOCTOR` INT)  BEGIN
	
	SELECT ingresos.id as id, medicos.id as idDoctor, CONCAT(medicos.nombres, ' ', medicos.apellidos) as doctor, 
					 pacientes.id as hc, CONCAT(pacientes.nombres, ' ', pacientes.apellidos) as pacientes,					 
					 ingresos.descripcion as descripcion, ingresos.monto as monto, date(ingresos.created_at) as fecha,
					 medicos.margen_ganancia as mg
		FROM `ingresos` 
			INNER JOIN pacientes on pacientes.id = ingresos.idPaciente
			INNER JOIN medicos on medicos.id = ingresos.idMedico
		WHERE 
				date(ingresos.created_at) >= INI_DATE AND date(ingresos.created_at) <= FIN_DATE AND medicos.id = X_IDDOCTOR;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `obtenerCitas` (IN `XID_USER` INT)  BEGIN
		SELECT CONCAT(title, '. Cel: ', celular , '. Trat: ', tratamiento) as title, id, desde as start, hasta as end 
			FROM agendas
		WHERE idDoctor = XID_USER;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `obtenerTodosMedicos` ()  BEGIN
	SELECT id, CONCAT(nombres, ' ', apellidos) as name FROM medicos;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `obtenerUltimoIdEmpresa` ()  BEGIN
	DECLARE ID_EMPRESA INT;
    
	SELECT id INTO ID_EMPRESA FROM empresas ORDER BY id DESC LIMIT 1;
    
    SELECT ID_EMPRESA;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `obtenerUltimoIdTratamiento` ()  BEGIN
	DECLARE ID_TRATAMIENTO INT;
    
	SELECT id INTO ID_TRATAMIENTO FROM tratamientos ORDER BY id DESC LIMIT 1;
    
    SELECT ID_TRATAMIENTO;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updatePrecios` (IN `XIDEMPRESA` INT, IN `XIDTRATAMIENTO` INT, IN `XMONTO` DECIMAL(10,0), IN `XTOKEN` VARCHAR(255) CHARSET utf8)  BEGIN
    UPDATE precios SET precios.monto=XMONTO where precios.idEmpresa = XIDEMPRESA and precios.idTratamiento = XIDTRATAMIENTO;
    SELECT ROW_COUNT() AS ESTADO;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agendas`
--

CREATE TABLE `agendas` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `celular` varchar(100) DEFAULT NULL,
  `desde` varchar(25) NOT NULL,
  `hasta` varchar(25) NOT NULL,
  `idDoctor` int(11) DEFAULT NULL,
  `tratamiento` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `agendas`
--

INSERT INTO `agendas` (`id`, `title`, `celular`, `desde`, `hasta`, `idDoctor`, `tratamiento`) VALUES
(1, 'Yago Tavara Galvez', '920010643', '2017-09-20T18:00:00', '2017-09-20T19:00:00', 1, 'profilaxis dental + fluor barniz'),
(2, 'Rodrigo Farid Carbonel Mera', '976904832', '2017-09-20T19:00:00', '2017-09-20T20:00:00', 1, 'sellantes'),
(3, 'María del Carmen  Candela Villalba', '976331371', '2017-09-20T10:30:00', '2017-09-20T12:00:00', 1, 'impresión prótesis completa inferior'),
(4, 'Magda Monica Lila Alvan Ochoa', '9657966376', '2017-09-20T09:30:00', '2017-09-20T10:30:00', 1, '.'),
(5, 'Jorge Luis Rojas Lopez', '976606811', '2017-10-02T07:00:00', '2017-10-02T07:00:00', 2, 'abc'),
(6, 'Rodrigo Arturo Rojas Vigo', '', '2017-10-13T07:00:00', '2017-10-13T07:30:00', 1, 'abc'),
(7, 'abc', '98765432', '2017-10-07T07:00:00', '2017-10-07T08:30:00', 1, 'abcdef');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `ruc` varchar(12) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`id`, `nombre`, `ruc`, `created_at`, `updated_at`) VALUES
(1, 'CORE', '20601744750', '2017-07-17', '2017-07-17'),
(2, 'PAMF - EPS SEDACAJ', '20113733641', '2017-07-21', '2017-07-21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos`
--

CREATE TABLE `ingresos` (
  `id` int(11) NOT NULL,
  `idPaciente` int(11) NOT NULL,
  `idMedico` int(11) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `monto` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ingresos`
--

INSERT INTO `ingresos` (`id`, `idPaciente`, `idMedico`, `descripcion`, `monto`, `created_at`, `updated_at`) VALUES
(1, 1, 2, NULL, '120.00', '2017-11-03 20:37:34', '2017-11-10 20:37:28'),
(2, 98, 1, NULL, '123.00', '2017-11-03 20:28:50', '2017-11-03 20:28:50'),
(3, 10, 2, NULL, '150.00', '2017-11-04 03:19:57', '2017-11-04 03:19:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicos`
--

CREATE TABLE `medicos` (
  `id` int(11) NOT NULL,
  `nombres` varchar(90) NOT NULL,
  `apellidos` varchar(90) NOT NULL,
  `dni` varchar(8) NOT NULL,
  `email` varchar(90) DEFAULT NULL,
  `direccion` varchar(90) NOT NULL,
  `fechanacimiento` date NOT NULL,
  `genero` varchar(25) NOT NULL,
  `estado` varchar(25) NOT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `celular` varchar(50) DEFAULT NULL,
  `celular_aux` varchar(50) DEFAULT NULL,
  `margen_ganancia` decimal(10,0) DEFAULT NULL,
  `updated_at` date NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `medicos`
--

INSERT INTO `medicos` (`id`, `nombres`, `apellidos`, `dni`, `email`, `direccion`, `fechanacimiento`, `genero`, `estado`, `telefono`, `celular`, `celular_aux`, `margen_ganancia`, `updated_at`, `created_at`) VALUES
(1, 'Arturo Rafael', 'Quilcate Gonzales', '47555917', 'dr.quilcate92@outlook.com', 'Jr. Silva Santisteban 501', '1992-12-23', 'Masculino', 'Soltero', NULL, '966707974', NULL, '37', '0000-00-00', '0000-00-00'),
(2, 'Dina Fresia Sandy Melissa', 'Sandoval Vallejos', '73821877', 'fresiv.wu@hotmail.com', 'Jr. Jose Gálvez 983', '1993-06-08', 'Femenino', 'Soltero', NULL, '959365285', NULL, '37', '2017-09-12', '2017-09-12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `id` int(11) NOT NULL,
  `nombres` varchar(90) NOT NULL,
  `apellidos` varchar(90) NOT NULL,
  `dni` varchar(8) DEFAULT NULL,
  `email` varchar(90) DEFAULT NULL,
  `direccion` varchar(90) NOT NULL,
  `fechanacimiento` date NOT NULL,
  `genero` varchar(25) NOT NULL,
  `estado` varchar(25) NOT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `fax` varchar(50) DEFAULT NULL,
  `celular` varchar(50) DEFAULT NULL,
  `celular_aux` varchar(50) DEFAULT NULL,
  `empresa_id` int(11) NOT NULL,
  `seguro_ind` int(11) NOT NULL,
  `updated_at` date NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`id`, `nombres`, `apellidos`, `dni`, `email`, `direccion`, `fechanacimiento`, `genero`, `estado`, `telefono`, `fax`, `celular`, `celular_aux`, `empresa_id`, `seguro_ind`, `updated_at`, `created_at`) VALUES
(1, 'Luis Martín', 'Vallejos Bardales', '45900500', 'martin.vallej@gmail.com', 'Jr. Miguel grau 656', '1989-07-19', 'Masculino', 'Soltero', '361611', NULL, '921855468', NULL, 1, 0, '2017-03-20', '2017-03-20'),
(2, 'Rodrigo Arturo', 'Rojas Vigo', '78857948', '', 'Pje. Luis Rebaza Neira 186', '2014-11-22', 'Masculino', 'Soltero', '', NULL, '', NULL, 1, 0, '2017-03-22', '2017-03-22'),
(3, 'Jorge Luis', 'Rojas Lopez', '73183032', 'jorgeluisrojaslopez7@gmail.com', 'Jr. Ucayali 444', '2005-08-17', 'Masculino', 'Soltero', '', NULL, '976606811', NULL, 1, 0, '2017-03-23', '2017-03-22'),
(4, 'Marcela', 'Paredes Puelles', '26618808', '', 'Jr. Silva Santisteban 459', '1965-10-01', 'Masculino', 'Soltero', '', NULL, '979101956', NULL, 1, 0, '2017-03-23', '2017-03-23'),
(5, 'Gabriela ', 'Rojas Gonzales', '73644937', 'gabi25_1@hotmail.com', 'Jr. Silva Santisteban 501', '1996-01-25', 'Masculino', 'Soltero', '344987', NULL, '992549002', NULL, 1, 0, '2017-03-25', '2017-03-24'),
(6, 'Claudia Aracely ', 'Vallejos Bardales', '71081182', 'cavb.97.20@hotmail.com', 'Av. Miguel Grau 656', '1997-12-20', 'Masculino', 'Soltero', '361611', NULL, '974660406', NULL, 1, 0, '2017-03-25', '2017-03-25'),
(7, 'Betty Maribel', 'Murrugarra Abanto', '26603439', '', 'Jr.Santa Teresa 280', '1963-08-22', 'Masculino', 'Soltero', '076364589', NULL, '', NULL, 1, 0, '2017-03-27', '2017-03-25'),
(8, 'Joaquin Enrique', 'Vallejos Valdiviva', '71718194', 'joenva20@hotmail.com', '27 de noviembre 340', '2004-03-20', 'Masculino', 'Soltero', '351997', NULL, '944842612', NULL, 1, 0, '2017-03-25', '2017-03-25'),
(9, 'Mónica Belen', 'Vallejos Valdiviva', '71718193', 'mvallejosvaldivia@gmail.com', 'Jr. 27 de Noviembre 340 - Chota', '1999-07-08', 'Masculino', 'Soltero', '076351997', NULL, '979951987', NULL, 1, 0, '2017-03-25', '2017-03-25'),
(10, 'Oscar', 'Muñoz Alcalde', '26690102', '', 'Jr. Silva Santisteban', '1966-11-20', 'Masculino', 'Soltero', '', NULL, '986151942', NULL, 1, 0, '2017-03-27', '2017-03-26'),
(11, 'Karol Melissa ', 'Novoa Murrugarra', '46996094', 'melissanovoa18@hotmail.com', 'Jr. Santa Teresa 280', '1991-04-18', 'Masculino', 'Soltero', '076 364589', NULL, '945723582', NULL, 1, 0, '2017-03-27', '2017-03-27'),
(12, 'Tania Carolina', 'Salas Venturo', '46074854', 'tsalasventuro@gmail.com', 'Jr. Hualgayoc 383', '1990-09-06', 'Masculino', 'Soltero', '', NULL, '940190350', NULL, 1, 0, '2017-06-19', '2017-03-28'),
(13, 'Robin Alfredo ', 'Vigo Rojas ', '43091418', 'rvigo@solucionesporacticas.org.pe', 'Jr. Hualgayoc 383', '1985-07-16', 'Masculino', 'Soltero', '076261433', NULL, '987850979', NULL, 1, 0, '2017-03-28', '2017-03-28'),
(14, 'Lhía Macarenna', 'Sandoval Rabanal', '', '', 'Av. Mario Urteaga 405', '2014-05-23', 'Masculino', 'Soltero', '', NULL, '945637763', NULL, 1, 0, '2017-03-29', '2017-03-29'),
(15, 'Wilson Andrés ', 'Novoa Murrugarra ', '73393073', 'sk8andres_1992@hotmail.com', 'Jr. Santa Teresa 280', '1992-10-28', 'Masculino', 'Soltero', '364589', NULL, '', NULL, 1, 0, '2017-03-29', '2017-03-29'),
(16, 'Elena', 'Cabellos Chávez', '70840355', 'nicc_93_12@hotmail.com', 'Av. Atahualpa 306', '1993-05-05', 'Masculino', 'Soltero', '076 367598', NULL, '986007570', NULL, 1, 0, '2017-03-30', '2017-03-30'),
(17, 'Orillo Terrones', 'Briner Enrique', '71205731', '', 'Jr. Ayacucho 452', '1994-09-05', 'Masculino', 'Soltero', '076 362423', NULL, '957824863', NULL, 1, 0, '2017-03-30', '2017-03-30'),
(18, 'Mariana Del Sol', 'Pajares Basauri', '63148476', '', 'Jr. Jose Olaya 248', '2012-02-24', 'Masculino', 'Soltero', '368050', NULL, '920019887', NULL, 1, 0, '2017-04-04', '2017-04-04'),
(19, 'Gian Piere', 'Vallejos Bardales', '71081201', 'gian.vallejos92@gmail.com', 'Av. Miguel Grau 656', '1992-10-26', 'Masculino', 'Soltero', '361611', NULL, '982780954', NULL, 1, 0, '2017-04-07', '2017-04-07'),
(20, 'Estefani Victoria', 'Vargas Marin', '72752357', 'vargasmarinvictoria@gmail.com', 'Jr. Revolucion 123', '1994-04-02', 'Masculino', 'Soltero', '', NULL, '', NULL, 1, 0, '2017-04-07', '2017-04-07'),
(21, 'Claudia Lisset ', 'Diaz Narro', '73991669', 'claudiald@hotmail.com', 'Jr. 28 de octubre 155 ', '1993-12-12', 'Masculino', 'Soltero', '358073', NULL, '993791374', NULL, 1, 0, '2017-04-07', '2017-04-07'),
(22, 'María del Carmen ', 'Candela Villalba', '26686690', 'alednacairam@hotmail.com', 'Fundo tres Molinos', '1954-10-15', 'Masculino', 'Soltero', '', NULL, '976331371', NULL, 1, 0, '2017-04-09', '2017-04-09'),
(23, 'Magda Monica Lila', 'Alvan Ochoa', '05413212', '', 'Jr. Cumbe Mayo 260', '1977-10-06', 'Masculino', 'Soltero', '', NULL, '9657966376', NULL, 1, 0, '2017-04-10', '2017-04-10'),
(24, 'Karol Fabiana ', 'Rudas Portilla', '61444472', '', 'Jr.Piura # 515', '2008-09-09', 'Masculino', 'Soltero', '', NULL, '936768809', NULL, 1, 0, '2017-04-12', '2017-04-12'),
(25, 'Mario Alexander', 'Vargas Chavez', '71468042', 'mario15-94@hotmail.com', 'Jr. Silva Santisteban 801', '1994-04-15', 'Masculino', 'Soltero', '314616', NULL, '994998159', NULL, 1, 0, '2017-04-18', '2017-04-18'),
(26, 'Santos Victor', 'Leonardo Sanchez', '26945625', '', 'Jr. Estrecho 413', '1954-04-27', 'Masculino', 'Soltero', '', NULL, '976003069', NULL, 1, 0, '2017-04-22', '2017-04-22'),
(27, 'Geny Jobani', 'Vargas Roncal', '60390400', '', 'Caserio Cau Cau', '1998-08-16', 'Masculino', 'Soltero', '', NULL, '927277382', NULL, 1, 0, '2017-05-01', '2017-04-26'),
(28, 'José Andres ', 'Murrugarra Abanto', '26600716', '', 'Manzanilla - Centro Poblado', '1947-11-30', 'Masculino', 'Soltero', '361860', NULL, '', NULL, 1, 0, '2017-04-28', '2017-04-28'),
(29, 'Dario', 'Diaz Cerquin', '26700533', '', 'Caserio Bajo Otuzco', '1971-12-23', 'Masculino', 'Soltero', '', NULL, '945979255', NULL, 1, 0, '2017-05-04', '2017-05-04'),
(30, 'Gian Piere', 'Vallejos', '71081201', 'gian@gmail.com', 'Av. Miguel Grau 656', '2017-05-04', 'Masculino', 'Soltero', '', NULL, '', NULL, 2, 0, '2017-05-17', '2017-05-04'),
(31, 'Jorge Antonio', 'Custodio Benzunce', '26626538', 'jorgecb_17@yahoo.es', 'Av. Mario Urtega 209', '1966-01-17', 'Masculino', 'Soltero', '', NULL, '963996398', NULL, 1, 0, '2017-05-09', '2017-05-09'),
(32, 'Gladys Eugenia', 'Camacho Pajares', '26611316', '', 'Jr. Manco Capac 440 - BaÃ±os del Inca', '1966-10-15', 'Masculino', 'Soltero', '', NULL, '976434131', NULL, 1, 0, '2017-05-13', '2017-05-13'),
(33, 'Frank Alex', 'Castañeda Vargas', '27917277', '', 'Jr. Alfonso Ugarte 837', '1973-05-10', 'Masculino', 'Soltero', '', NULL, '', NULL, 1, 0, '2017-05-14', '2017-05-14'),
(34, 'Angie Valezkha', 'Briones Mendoza', '60544679', '', 'Psje. Antonio Bezela 121', '2007-09-11', 'Masculino', 'Soltero', '260067', NULL, '950479919', NULL, 1, 0, '2017-06-17', '2017-05-18'),
(35, 'Enrique Gian Bernardo', 'Briones Mendoza', '63500390', 'cavemeal@hotmail.com', 'Psje. Antonio De Zela 121', '2012-12-23', 'Masculino', 'Soltero', '260067', NULL, '950479919', NULL, 1, 0, '2017-05-23', '2017-05-23'),
(36, 'Yolanda', 'Becerra García ', '', '', 'Jr. Silva Santisteban 364', '1983-07-22', 'Masculino', 'Soltero', '', NULL, '969001960', NULL, 1, 0, '2017-05-26', '2017-05-26'),
(37, 'Kent Jeyson', 'Carrasco Cabanillas', '71592889', 'kcarrascoc14@unc.edu.pe', 'Carr. Carretera BamBamarca-44 INT.A br. HUambocancha ', '1997-05-11', 'Masculino', 'Soltero', '', NULL, '976868850', NULL, 1, 0, '2017-05-27', '2017-05-27'),
(38, 'Mikol Zaira', 'Salazar Chávez', '72696900', '', 'Jr. San pablo 95', '1998-11-10', 'Masculino', 'Soltero', '362451', NULL, '976321708', NULL, 1, 0, '2017-05-28', '2017-05-28'),
(39, 'Antony Jhonattant', 'Comettant Cruzado', '42947040', '', 'Jr. amalia puga 436', '1985-04-22', 'Masculino', 'Soltero', '283296', NULL, '976539322', NULL, 1, 0, '2017-05-28', '2017-05-28'),
(40, 'Romel', 'Medina Saldaña', '26687353', 'vcablescaj@hotmail.com', 'Jr. Cinco Esquinas 309 Br. San Sebastian ', '1956-04-01', 'Masculino', 'Soltero', '', NULL, '976636087', NULL, 1, 0, '2017-05-31', '2017-05-31'),
(41, 'Carlos Henri ', 'Rojas Zegarra', '09780836', 'carlosrojasebalista@hotmail.com', 'Jr. Santa ANITA 251', '1975-07-29', 'Masculino', 'Soltero', '', NULL, '976843243', NULL, 1, 0, '2017-06-01', '2017-06-01'),
(42, 'Merly Yessica', 'Alcas Tavara', '41740536', 'mergyy@hotmail.com', 'Jr. Los Narajos 110 - Urb El ingenio', '1982-12-23', 'Masculino', 'Soltero', '', NULL, '974842877', NULL, 1, 0, '2017-06-01', '2017-06-01'),
(43, 'Anita Isabel', 'Zavala Cuenca', '26622681', 'aniza_13@hotmail.com', 'Jr. Silva Santisteban 1112', '1966-08-13', 'Masculino', 'Soltero', '', NULL, '976609085', NULL, 1, 0, '2017-06-02', '2017-06-02'),
(44, 'Mathias Rancel', 'Chingay Ocas', '77544858', '', 'CP Bajo Otuzco', '2012-01-10', 'Masculino', 'Soltero', '', NULL, '976415814', NULL, 1, 0, '2017-06-06', '2017-06-06'),
(45, 'Horacio', 'Rojas Mori', '26626686', '', 'Jr. Casurco 266', '2017-06-07', 'Masculino', 'Soltero', '364961', NULL, '976838992', NULL, 1, 0, '2017-07-07', '2017-06-07'),
(46, 'Grimaldo Guzman', 'Mendoza Campos', '46453763', 'grimen13@hotmail.com', 'Jr. Cumbre Mayo 209 Urb. Ramon Castilla', '1990-07-27', 'Masculino', 'Soltero', '', NULL, '982390987', NULL, 1, 0, '2017-06-10', '2017-06-10'),
(47, 'Gustavo Matias', 'Medina Torres', '', '', 'Jr. Sullana 130', '2003-05-08', 'Masculino', 'Soltero', '312409', NULL, '994506137', NULL, 1, 0, '2017-06-16', '2017-06-16'),
(48, 'Eulalia', 'Saldaña Cabanillas', '28062674', '', 'Jr. Los Nogales 275 - Villa Universitaria', '1959-10-10', 'Masculino', 'Soltero', '312469', NULL, '', NULL, 1, 0, '2017-06-19', '2017-06-19'),
(49, 'Dayana Yakirah', 'Salazar Chavez', '46702652', 'stars11_1@hotmail.com', 'Jr. San pablo 495 San Sebastian', '1990-12-11', 'Masculino', 'Soltero', '362451', NULL, '942207032', NULL, 1, 0, '2017-06-21', '2017-06-21'),
(50, 'Maricela Viviana', 'Hoyos Cordoba', '26641992', 'mvivianahocor@hotmail.com', 'Jr. Silva Santisteban 341', '1972-04-26', 'Masculino', 'Soltero', '363360', NULL, '962703937', NULL, 1, 0, '2017-06-21', '2017-06-21'),
(51, 'Christopher Adrian', 'Rodriguez Diaz', '63509350', 'sagitario01_86@hotmail.com', 'Jr. Carlos Malpica 153', '2012-05-07', 'Masculino', 'Soltero', '962678126', NULL, '986786085', NULL, 1, 0, '2017-07-05', '2017-06-22'),
(52, 'Fabricio Joaquin', 'Muñoz Vigo', '78702579', '', 'Jr. Manco Capac 440 BaÃ±os del Inca', '2014-08-03', 'Masculino', 'Soltero', '076348085', NULL, '982198534', NULL, 1, 0, '2017-06-24', '2017-06-24'),
(53, 'Walter Abel', 'Bardales Bodero', '26676298', 'boderow@yahoo.com', 'Jr. Los alamos 146 Urb. El Ingenio', '2017-06-29', 'Masculino', 'Soltero', '076506052', NULL, '9739769264', NULL, 2, 0, '2017-06-29', '2017-06-29'),
(54, 'Segundo Alberto', 'Perez Ventura', '26733030', 'albertito7777777@hotmail.com', 'Jr. Silva Santisteban 364', '1978-04-27', 'Masculino', 'Soltero', '', NULL, '945921530', NULL, 1, 0, '2017-07-06', '2017-07-06'),
(55, 'Jonel', 'Salcedo Sarmiento', '40518924', 'jss.salcedo1012@gmail.com', 'Jr. Revilla Perez 239', '1978-12-10', 'Masculino', 'Soltero', '369172', NULL, '976965619', NULL, 2, 0, '2017-07-07', '2017-07-07'),
(56, 'Segundo Rafaelito', 'Perez Baez', '41879209', 'deli_29@hotmail.com', 'Jr. Eten 230', '1983-04-13', 'Masculino', 'Soltero', '', NULL, '949978899', NULL, 1, 0, '2017-07-08', '2017-07-08'),
(57, 'Fermina', 'Quispe de Peña', '26690390', '', 'Jr. Angamos 333', '1933-11-24', 'Masculino', 'Soltero', '313574', NULL, '976774776', NULL, 1, 0, '2017-07-09', '2017-07-09'),
(58, 'Darlini', 'Diaz Colunche', '47048742', 'flor_c_r2006@hotmail.com', 'Jr. Carlos Malpica 153', '1991-02-25', 'Femenino', 'Soltero', NULL, NULL, '962678126', NULL, 1, 0, '2017-09-25', '2017-07-11'),
(59, 'Antero', 'Vargas Salazar', '26716114', '', 'Jr. Silva Santisteban 801', '1958-01-04', 'Masculino', 'Soltero', '314616', NULL, '976602086', NULL, 1, 0, '2017-07-12', '2017-07-12'),
(60, 'Claudia Alessandra', 'Sempertegui Ruiz', '73204851', 'a20173302@pucp.edu.pe', 'Jr. Humbolt C11 - Ubr. San Luis', '2000-07-11', 'Masculino', 'Soltero', '361039', NULL, '989831410', NULL, 1, 0, '2017-07-12', '2017-07-12'),
(61, 'Claudia ', 'Muñoz Barboza', '44525991', 'klau25.m@gmail.com', 'Jr. Silva Santisteban 521', '1987-05-30', 'Masculino', 'Soltero', '', NULL, '965387186', NULL, 1, 0, '2017-07-19', '2017-07-19'),
(62, 'María', 'Saldaña Tafur', '44685424', '', 'Jr. Santa Anita 1090', '1987-11-30', 'Masculino', 'Soltero', '', NULL, '973059415', NULL, 1, 0, '2017-07-19', '2017-07-19'),
(63, 'María Sabina', 'Chuquiruna Soto', '44667952', '', 'Av. AviaciÃ³n 291', '1987-02-04', 'Masculino', 'Soltero', '', NULL, '973011954', NULL, 1, 0, '2017-07-19', '2017-07-19'),
(64, 'Sonia Soledad', 'Correa Rodriguez', '26611262', 'soniasoledad_04@hotmail.com', 'Jr. Guillermo Urrelo 912', '1965-06-26', 'Masculino', 'Soltero', '', NULL, '942470554', NULL, 1, 0, '2017-07-20', '2017-07-20'),
(65, 'Víctor Alfredo', 'Reyes Miguel', '47074818', 'alfred0_120', 'Jr. Ayacucho 250', '1991-05-28', 'Masculino', 'Soltero', '', NULL, '935583705', NULL, 1, 0, '2017-07-22', '2017-07-22'),
(66, 'Luis Fernando', 'Del Campo Diaz', '74605881', 'fernando.delcampo@outlook.com', 'Av. 28 de julio 116 Int 102 ', '1994-06-08', 'Masculino', 'Soltero', '', NULL, '941832121', NULL, 1, 0, '2017-07-25', '2017-07-25'),
(67, 'Karla Ysabel', 'Tello Zavala', '72874042', 'karla_tzz@hotmail.com', 'Jr. Silva Santisteban 1112', '1998-09-21', 'Femenino', 'Soltero', '076280259', NULL, '969514514', NULL, 1, 0, '2017-07-26', '2017-07-26'),
(68, 'Segundo Sebastian', 'Chacon Ocas', '40495255', '', 'Jr. Inca Roca 358', '1978-01-25', 'Masculino', 'Soltero', '076261827', NULL, '976223830', NULL, 1, 0, '2017-07-27', '2017-07-27'),
(69, 'Mirtha Lizeth', 'Villar Giles ', '46823774', 'mirtha.giles.0509@gmail.com', 'Urb. Hurtado Miller Mz 6 Lt 14 BaÃ±os del Inca ', '1991-08-05', 'Femenino', 'Soltero', '', NULL, '997391940', NULL, 1, 0, '2017-08-01', '2017-08-01'),
(70, 'Eligia ', 'Vigo Mendoza', '26613045', 'eligia.vigo@gmail.com', 'Jr. Guadalupe 460', '1955-11-26', 'Femenino', 'Casado', '076366885', NULL, '976441367', NULL, 2, 0, '2017-08-03', '2017-08-03'),
(71, 'Pereda Pairazamani', 'Emily Ariana', '62610598', 'milton45_15@hotmail.com', 'Jr.Eten 250 Barrio San Sebastian ', '2010-03-18', 'Masculino', 'Soltero', '942102273', NULL, '949054210', NULL, 1, 0, '2017-08-03', '2017-08-03'),
(72, 'Ana Elizabeth ', 'Bazan Diaz', '26731803', 'anitabazand@hotmail.com', 'JR. amalia PUga 337', '1977-07-29', 'Femenino', 'Soltero', '261455', NULL, '976364009', NULL, 1, 0, '2017-08-07', '2017-08-07'),
(73, 'María Angela', 'Rojas Vargas', '26625006', 'maria.rojas@secadaj.com.pe', 'Av. Peru 1517', '1963-05-31', 'Femenino', 'Viudo', '', NULL, '976359641', NULL, 2, 0, '2017-08-09', '2017-08-09'),
(74, 'Cesar Augusto', 'Diaz Vigo', '26611393', 'dica1958@hotmail.com', 'Fundo 3 Molinos BaÃ±os Del Inca ', '1957-05-23', 'Masculino', 'Soltero', '', NULL, '976331376', NULL, 1, 0, '2017-08-12', '2017-08-12'),
(75, 'Hector Abraham', 'Pumaccajia Echia', '', 'judithnidia31@hotmail.com', '', '2014-02-27', 'Masculino', 'Soltero', '', NULL, '970775886', NULL, 1, 0, '2017-08-12', '2017-08-12'),
(76, 'Roberto', 'LLanos Linares', '26617552', '', 'Av. Hoyos Rubio 1188 Ubr. Horacio Zevallos', '1966-03-08', 'Masculino', 'Casado', '', NULL, '949419090', NULL, 2, 0, '2017-08-19', '2017-08-19'),
(77, 'Paul Franco', 'Mercado MarÃ­n', '40465677', 'paulmercado2011@hotmail.com', 'Jr. Soledad 361', '1979-07-18', 'Masculino', 'Soltero', '363678', NULL, '951663735', NULL, 1, 0, '2017-08-21', '2017-08-21'),
(78, 'Dora', 'Del Castillo Zamora', '26637571', '', 'Jr. 5 Esquinas E-29', '1952-04-29', 'Femenino', 'Casado', '', NULL, '970924753', NULL, 1, 0, '2017-08-24', '2017-08-24'),
(79, 'kathy Julissa', 'Llanos Gallardo', '72437884', '', 'El porongo C26', '2004-08-16', 'Femenino', 'Soltero', '949419090', NULL, '976004285', NULL, 2, 0, '2017-08-30', '2017-08-30'),
(80, 'Emma ', 'Valdivia Campos', '27420412', 'emmavaldiviacampos@gmail.com', '27 de noviembre 340', '1972-08-15', 'Femenino', 'Divorciado', '076351947', NULL, '984669161', NULL, 1, 0, '2017-08-30', '2017-08-30'),
(81, 'Raul Antonio', 'Centurión Galdos', '07616469', NULL, 'Av.', '2017-12-31', 'Masculino', 'Soltero', '358001', NULL, '976076969', '954170791', 1, 1, '2017-09-26', '2017-09-12'),
(82, 'Maxima Isabel', 'Mayta Diaz', '11111111', NULL, 'Av.', '2017-12-31', 'Femenino', 'Soltero', NULL, NULL, NULL, NULL, 1, 0, '2017-09-12', '2017-09-12'),
(83, 'Luis Humberto', 'Ravines Oblitas', '26605201', NULL, 'Jr. Los Gladiolos 114 - Pj. Maria Parado de Bellido', '1955-07-19', 'Masculino', 'Soltero', '976862021', NULL, NULL, NULL, 2, 1, '2017-09-18', '2017-09-12'),
(84, 'Ynocencio Joel', 'Huaman abanto', '41620646', NULL, 'Av. el maestro 342A', '1980-07-08', 'Masculino', 'Soltero', '076 620170', NULL, '992906420', NULL, 1, 0, '2017-09-12', '2017-09-12'),
(86, 'Rodrigo Farid', 'Carbonel Mera', '74015199', 'jimmy_carbonel@hotmail.com', 'Pro cinco esquinas 1546 DPTO.402 lot. STA. Mercedes', '2010-02-09', 'Masculino', 'Soltero', NULL, NULL, '976904832', '976835031', 1, 0, '2017-09-13', '2017-09-13'),
(87, 'Mayra Elizabeth', 'Tello Zavala', '72884359', 'mayita_tz@hotmail.com', 'Jr. Silva Santisteban 1112', '1992-02-24', 'Femenino', 'Soltero', '280523', NULL, '974812903', NULL, 1, 0, '2017-09-15', '2017-09-15'),
(88, 'Silvana', 'Vargas Villena', NULL, NULL, 'Jr. Sanchez Hoyos 547', '2006-12-19', 'Femenino', 'Soltero', NULL, NULL, '938266435', NULL, 1, 0, '2017-09-18', '2017-09-18'),
(89, 'Diana', 'Vigo Rojas', '45880521', 'emdy.conytec@gmail,com', 'Jr. Loreto 391', '1989-02-04', 'Femenino', 'Soltero', '951769914', NULL, NULL, NULL, 1, 0, '2017-09-18', '2017-09-18'),
(90, 'Yago', 'Tavara Galvez', NULL, NULL, 'Jr. 28 de Julio #287', '2012-03-27', 'Masculino', 'Soltero', NULL, NULL, '920010643', '986238683', 1, 0, '2017-09-19', '2017-09-19'),
(91, 'Gael Octavio', 'Tavara Galvez', NULL, NULL, 'Jr. 28 de Julio #287', '2014-03-06', 'Masculino', 'Soltero', NULL, NULL, '920010643', '986238683', 1, 0, '2017-09-20', '2017-09-20'),
(92, 'Luis Alberto', 'García Mendoza', '41613181', 'psycoamigo@hotmail.com', 'Jr. petarteros 180 - Barrio San Sebastian', '1980-04-24', 'Masculino', 'Soltero', NULL, NULL, '976978366', NULL, 1, 0, '2017-09-22', '2017-09-22'),
(93, 'Maria Ines', 'Huaripata Chingay De Fernandez', '26721106', 'luzmarinafernandezhuaripata@gmail.com', 'CP. Otuzco', '1977-05-14', 'Femenino', 'Casado', NULL, NULL, '971311685', NULL, 2, 1, '2017-09-26', '2017-09-26'),
(94, 'Zinthia', 'Díaz  Vega', '43079593', 'cidive@hotmail.com', 'Jr. Dos de Mayo # 730', '1985-07-03', 'Femenino', 'Soltero', NULL, NULL, '976000668', NULL, 1, 0, '2017-09-27', '2017-09-27'),
(95, 'Carlos Ivan', 'Cubas Vasquez', '42666278', NULL, 'Urb. inca Manco Capac Mz LL-IV Lt.12 LIMA', '1981-10-02', 'Masculino', 'Soltero', NULL, NULL, '976394202', NULL, 1, 0, '2017-09-27', '2017-09-27'),
(96, 'Yerica', 'Mera Rivera', '40252474', 'yemeri_7@hotmail.com', 'Jr. cinco esquinas 1546 Dpto 402', '1977-02-16', 'Femenino', 'Casado', NULL, NULL, '976835031', NULL, 1, 0, '2017-09-28', '2017-09-28'),
(97, 'Emilia', 'Mejía Mendoza', '27047677', NULL, 'Jr. Miguel Grau 473', '1962-02-01', 'Femenino', 'Soltero', '976669100', NULL, '976669100', NULL, 1, 0, '2017-09-28', '2017-09-28'),
(98, 'Cecilia', 'Silva Mejía', '44051713', 'acecy@gmail.com', 'Jr. Miguel Grau 473', '1987-02-01', 'Femenino', 'Casado', '976888995', NULL, '976888995', NULL, 1, 0, '2017-09-28', '2017-09-28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precios`
--

CREATE TABLE `precios` (
  `id` int(11) NOT NULL,
  `idEmpresa` int(11) NOT NULL,
  `idTratamiento` int(11) NOT NULL,
  `monto` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `precios`
--

INSERT INTO `precios` (`id`, `idEmpresa`, `idTratamiento`, `monto`) VALUES
(1, 1, 2, '40'),
(2, 2, 2, '35'),
(3, 1, 3, '40'),
(4, 2, 3, '35'),
(5, 1, 4, '40'),
(6, 2, 4, '35'),
(7, 1, 5, '40'),
(8, 2, 5, '35'),
(9, 1, 6, '40'),
(10, 2, 6, '40'),
(11, 1, 7, '40'),
(12, 2, 7, '35'),
(13, 1, 8, '100'),
(14, 2, 8, '100'),
(15, 1, 9, '350'),
(16, 2, 9, '350'),
(17, 1, 10, '70'),
(18, 2, 10, '70'),
(19, 1, 11, '450'),
(20, 2, 11, '400'),
(21, 1, 12, '35'),
(22, 2, 12, '30'),
(23, 1, 13, '70'),
(24, 2, 13, '35'),
(25, 1, 14, '200'),
(26, 2, 14, '150'),
(27, 1, 15, '170'),
(28, 2, 15, '150'),
(29, 1, 16, '220'),
(30, 2, 16, '200'),
(31, 1, 17, '270'),
(32, 2, 17, '250'),
(33, 1, 18, '400'),
(34, 2, 18, '400'),
(35, 1, 19, '300'),
(36, 2, 19, '300'),
(37, 1, 20, '100'),
(38, 2, 20, '80'),
(39, 1, 21, '150'),
(40, 2, 21, '120'),
(41, 1, 22, '90'),
(42, 2, 22, '90'),
(43, 1, 23, '150'),
(44, 2, 23, '120'),
(45, 1, 26, '150'),
(46, 2, 26, '120'),
(47, 1, 27, '220'),
(48, 2, 27, '220'),
(49, 1, 28, '90'),
(50, 2, 28, '90'),
(51, 1, 29, '55'),
(52, 2, 29, '50'),
(53, 1, 30, '70'),
(54, 2, 30, '65'),
(55, 1, 31, '20'),
(56, 2, 31, '15'),
(57, 1, 32, '50'),
(58, 2, 32, '25'),
(59, 1, 33, '45'),
(60, 2, 33, '35'),
(61, 1, 34, '75'),
(62, 2, 34, '60'),
(63, 1, 35, '40'),
(64, 2, 35, '40'),
(65, 1, 36, '60'),
(66, 2, 36, '60'),
(67, 1, 37, '80'),
(68, 2, 37, '80'),
(69, 1, 38, '30'),
(70, 2, 38, '30'),
(71, 1, 39, '120'),
(72, 2, 39, '120'),
(73, 1, 40, '50'),
(74, 2, 40, '50'),
(75, 1, 41, '60'),
(76, 2, 41, '60'),
(77, 1, 42, '60'),
(78, 2, 42, '60'),
(79, 1, 43, '200'),
(80, 2, 43, '200'),
(81, 1, 45, '300'),
(82, 2, 45, '300'),
(83, 1, 49, '60'),
(84, 2, 49, '60'),
(85, 1, 50, '75'),
(86, 2, 50, '75'),
(87, 1, 51, '90'),
(88, 2, 51, '90'),
(89, 1, 52, '50'),
(90, 2, 52, '50'),
(91, 1, 53, '500'),
(92, 2, 53, '450'),
(93, 1, 54, '600'),
(94, 2, 54, '600'),
(95, 1, 55, '700'),
(96, 2, 55, '700'),
(97, 1, 56, '700'),
(98, 2, 56, '660'),
(99, 1, 57, '800'),
(100, 2, 57, '800'),
(101, 1, 58, '900'),
(102, 2, 58, '900'),
(103, 1, 59, '180'),
(104, 2, 59, '180'),
(105, 1, 60, '25'),
(106, 2, 60, '25'),
(107, 1, 61, '150'),
(108, 2, 61, '100'),
(109, 1, 62, '50'),
(110, 2, 62, '50'),
(111, 1, 63, '20'),
(112, 2, 63, '15'),
(113, 1, 64, '30'),
(114, 2, 64, '0'),
(115, 1, 65, '170'),
(116, 2, 65, '170'),
(117, 1, 66, '270'),
(118, 2, 66, '270'),
(119, 1, 67, '30'),
(120, 2, 67, '30'),
(121, 1, 68, '20'),
(122, 2, 68, '20'),
(123, 1, 69, '10'),
(124, 2, 69, '10'),
(125, 1, 70, '300'),
(126, 2, 70, '300'),
(127, 1, 71, '750'),
(128, 2, 71, '700'),
(129, 1, 72, '450'),
(130, 2, 72, '450'),
(131, 1, 73, '50'),
(132, 2, 73, '50'),
(133, 1, 74, '0'),
(134, 2, 74, '0'),
(135, 1, 75, '0'),
(136, 2, 75, '0'),
(137, 1, 76, '600'),
(138, 2, 76, '0'),
(139, 1, 77, '150'),
(140, 2, 77, '0'),
(141, 1, 78, '0'),
(142, 2, 78, '0'),
(143, 1, 79, '0'),
(144, 2, 79, '0'),
(145, 1, 80, '0'),
(146, 2, 80, '0'),
(147, 1, 81, '0'),
(148, 2, 81, '0'),
(149, 1, 82, '50'),
(150, 2, 82, '50'),
(151, 1, 83, '50'),
(152, 2, 83, '50'),
(153, 1, 84, '15'),
(154, 2, 84, '10'),
(155, 1, 85, '30'),
(156, 2, 85, '30'),
(157, 1, 86, '30'),
(158, 2, 86, '30'),
(159, 1, 87, '350'),
(160, 2, 87, '330'),
(161, 1, 88, '400'),
(162, 2, 88, '400'),
(163, 1, 89, '450'),
(164, 2, 89, '450'),
(165, 1, 90, '700'),
(166, 2, 90, '700'),
(167, 1, 91, '600'),
(168, 2, 91, '600'),
(169, 1, 92, '500'),
(170, 2, 92, '450'),
(171, 1, 93, '250'),
(172, 2, 93, '250'),
(173, 1, 94, '70'),
(174, 2, 94, '70'),
(175, 1, 95, '30'),
(176, 2, 95, '30'),
(177, 1, 96, '10'),
(178, 2, 96, '10'),
(179, 1, 97, '30'),
(180, 2, 97, '30'),
(181, 1, 98, '35'),
(182, 2, 98, '35'),
(183, 1, 99, '180'),
(184, 2, 99, '180'),
(185, 1, 100, '70'),
(186, 2, 100, '70'),
(187, 1, 101, '35'),
(188, 2, 101, '25'),
(189, 1, 102, '55'),
(190, 2, 102, '40'),
(191, 1, 103, '20'),
(192, 2, 103, '20'),
(193, 1, 104, '800'),
(198, 1, 107, '70'),
(199, 2, 107, '70'),
(200, 1, 108, '70'),
(201, 2, 108, '70'),
(202, 1, 109, '50'),
(203, 2, 109, '50'),
(204, 1, 110, '300'),
(205, 2, 110, '300');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuestos`
--

CREATE TABLE `presupuestos` (
  `id` int(11) NOT NULL,
  `fechahora` datetime NOT NULL,
  `idPaciente` int(11) NOT NULL,
  `idMedico` int(11) NOT NULL,
  `descuento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `presupuestos`
--

INSERT INTO `presupuestos` (`id`, `fechahora`, `idPaciente`, `idMedico`, `descuento`) VALUES
(1, '2017-04-06 18:34:09', 3, 1, 0),
(2, '2017-04-06 18:38:54', 8, 1, 1),
(3, '2017-04-06 18:41:57', 9, 1, 1),
(4, '2017-04-06 18:45:07', 7, 1, 0),
(5, '2017-04-06 18:53:30', 11, 1, 0),
(6, '2017-04-06 18:57:29', 13, 1, 0),
(7, '2017-04-06 19:03:39', 12, 1, 0),
(8, '2017-04-06 19:12:49', 15, 1, 0),
(9, '2017-04-06 19:22:22', 16, 1, 0),
(10, '2017-04-06 19:29:26', 17, 1, 0),
(11, '2017-04-06 19:33:07', 18, 1, 0),
(12, '2017-04-06 19:22:37', 19, 1, 1),
(13, '2017-04-06 19:38:16', 20, 1, 0),
(14, '2017-04-06 20:27:41', 21, 1, 0),
(15, '2017-04-10 17:11:18', 23, 1, 0),
(16, '2017-04-11 19:41:44', 24, 1, 0),
(17, '2017-04-18 11:22:47', 25, 1, 0),
(18, '2017-04-22 12:33:53', 26, 1, 0),
(19, '2017-04-27 18:22:13', 28, 1, 0),
(20, '2017-05-09 12:50:50', 31, 1, 0),
(21, '2017-05-12 19:14:36', 32, 1, 0),
(22, '2017-05-12 19:20:32', 32, 1, 0),
(23, '2017-05-17 19:09:09', 34, 1, 1),
(24, '2017-05-23 19:42:35', 35, 1, 0),
(25, '2017-05-27 12:25:50', 37, 1, 0),
(26, '2017-05-27 21:31:14', 38, 1, 0),
(27, '2017-05-27 21:46:46', 39, 1, 0),
(28, '2017-05-31 11:13:43', 40, 1, 0),
(29, '2017-06-01 12:35:32', 41, 1, 0),
(30, '2017-06-01 12:47:49', 41, 1, 0),
(31, '2017-06-01 17:04:39', 42, 1, 0),
(32, '2017-06-01 19:12:41', 40, 1, 0),
(33, '2017-06-05 18:06:59', 44, 1, 0),
(34, '2017-06-06 18:04:50', 45, 1, 0),
(35, '2017-06-09 22:24:52', 46, 1, 0),
(36, '2017-06-15 19:26:11', 47, 1, 0),
(37, '2017-06-19 17:46:05', 48, 1, 0),
(38, '2017-06-20 20:07:37', 49, 1, 0),
(39, '2017-06-21 16:03:58', 50, 1, 0),
(40, '2017-06-21 19:35:38', 51, 1, 0),
(41, '2017-06-23 17:59:17', 52, 1, 0),
(42, '2017-06-28 18:36:05', 53, 1, 0),
(43, '2017-06-28 19:43:39', 48, 1, 0),
(44, '2017-07-05 20:05:55', 36, 1, 0),
(45, '2017-07-05 20:11:44', 54, 1, 0),
(46, '2017-07-06 18:06:01', 55, 1, 0),
(47, '2017-07-07 20:16:58', 56, 1, 0),
(48, '2017-07-09 12:28:07', 57, 1, 0),
(49, '2017-07-10 17:03:08', 58, 1, 0),
(50, '2017-07-11 17:02:44', 22, 1, 0),
(51, '2017-07-12 11:55:19', 60, 1, 0),
(52, '2017-07-12 18:52:39', 53, 1, 0),
(53, '2017-07-18 17:13:44', 61, 1, 0),
(54, '2017-07-20 09:39:43', 64, 1, 0),
(55, '2017-07-22 17:23:26', 65, 1, 0),
(56, '2017-07-24 16:49:23', 59, 1, 0),
(57, '2017-07-24 17:41:13', 59, 1, 0),
(58, '2017-07-24 19:57:17', 65, 1, 0),
(59, '2017-07-25 16:35:03', 66, 1, 0),
(60, '2017-07-25 17:49:49', 67, 1, 0),
(61, '2017-07-26 18:50:01', 68, 1, 0),
(62, '2017-08-01 11:03:50', 69, 1, 0),
(63, '2017-08-02 21:00:35', 70, 1, 0),
(64, '2017-08-03 10:57:49', 71, 1, 0),
(65, '2017-08-08 18:08:32', 73, 1, 0),
(66, '2017-08-08 18:16:07', 73, 1, 0),
(67, '2017-08-11 20:25:38', 74, 1, 0),
(68, '2017-08-14 16:37:49', 75, 1, 0),
(69, '2017-08-19 12:34:53', 76, 1, 0),
(70, '2017-08-21 17:20:04', 77, 1, 0),
(71, '2017-08-23 19:25:26', 78, 1, 0),
(72, '2017-08-24 17:07:22', 1, 1, 0),
(73, '2017-08-28 18:36:48', 58, 1, 0),
(74, '2017-08-30 10:18:26', 79, 1, 0),
(75, '2017-08-30 10:23:00', 79, 1, 0),
(76, '2017-08-30 20:05:14', 80, 1, 0),
(77, '2017-09-11 19:57:21', 81, 1, 0),
(78, '2017-09-08 11:46:46', 82, 1, 0),
(79, '2017-09-08 11:51:19', 83, 1, 0),
(80, '2017-09-12 18:49:49', 84, 1, 0),
(81, '2017-09-12 19:08:02', 84, 1, 0),
(82, '2017-09-12 19:09:37', 84, 1, 0),
(83, '2017-09-12 20:09:29', 86, 1, 0),
(84, '2017-09-15 20:02:45', 87, 1, 0),
(85, '2017-09-18 12:27:23', 88, 1, 0),
(86, '2017-09-19 18:19:37', 90, 1, 0),
(87, '2017-09-20 16:38:19', 91, 1, 0),
(88, '2017-09-22 12:21:06', 92, 1, 0),
(89, '2017-09-26 13:28:11', 93, 1, 0),
(90, '2017-09-27 10:18:27', 94, 2, 0),
(91, '2017-09-27 16:56:40', 95, 1, 0),
(92, '2017-09-27 20:03:19', 96, 1, 0),
(93, '2017-09-28 12:01:31', 97, 1, 0),
(94, '2017-09-28 12:08:29', 98, 2, 0),
(95, '2017-10-13 18:48:42', 2, 1, 0),
(96, '2017-10-13 18:49:33', 2, 1, 0),
(97, '2017-10-13 18:49:45', 2, 1, 0),
(98, '2017-10-13 18:49:58', 2, 1, 0),
(99, '2017-10-13 18:51:39', 2, 1, 0),
(100, '2017-10-13 18:52:36', 2, 1, 0),
(101, '2017-10-13 18:52:53', 1, 1, 2),
(102, '2017-10-17 18:11:59', 2, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuestos_detalle`
--

CREATE TABLE `presupuestos_detalle` (
  `id` int(11) NOT NULL,
  `idPresupuesto` int(11) NOT NULL,
  `pieza` int(11) NOT NULL,
  `seccion` int(11) NOT NULL,
  `secUno` int(11) NOT NULL,
  `secDos` int(11) NOT NULL,
  `opcion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `presupuestos_detalle`
--

INSERT INTO `presupuestos_detalle` (`id`, `idPresupuesto`, `pieza`, `seccion`, `secUno`, `secDos`, `opcion`) VALUES
(252, 1, 12, 5, 0, 0, 1),
(253, 1, 14, 29, 0, 0, 1),
(254, 1, 16, 29, 0, 0, 1),
(255, 1, 15, 29, 0, 0, 1),
(256, 1, 24, 29, 0, 0, 1),
(257, 1, 25, 29, 0, 0, 1),
(258, 1, 26, 29, 0, 0, 1),
(259, 1, 46, 7, 0, 0, 1),
(260, 1, 45, 29, 0, 0, 1),
(261, 1, 44, 29, 0, 0, 1),
(262, 1, 34, 29, 0, 0, 1),
(263, 1, 35, 29, 0, 0, 1),
(264, 1, 36, 29, 0, 0, 1),
(265, 1, 81, 30, 0, 0, 1),
(266, 1, 71, 32, 0, 0, 1),
(267, 2, 17, 29, 0, 0, 1),
(268, 2, 16, 29, 0, 0, 1),
(269, 2, 15, 29, 0, 0, 1),
(270, 2, 14, 29, 0, 0, 1),
(271, 2, 24, 29, 0, 0, 1),
(272, 2, 25, 29, 0, 0, 1),
(273, 2, 26, 29, 0, 0, 1),
(274, 2, 27, 29, 0, 0, 1),
(275, 2, 44, 29, 0, 0, 1),
(276, 2, 45, 29, 0, 0, 1),
(277, 2, 46, 29, 0, 0, 1),
(278, 2, 47, 29, 0, 0, 1),
(279, 2, 34, 29, 0, 0, 1),
(280, 2, 35, 29, 0, 0, 1),
(281, 2, 36, 29, 0, 0, 1),
(282, 2, 37, 29, 0, 0, 1),
(283, 2, 35, 3, 0, 0, 1),
(284, 2, 41, 30, 0, 0, 1),
(285, 2, 31, 31, 0, 0, 1),
(286, 3, 14, 29, 0, 0, 1),
(287, 3, 15, 29, 0, 0, 1),
(288, 3, 16, 29, 0, 0, 1),
(289, 3, 17, 29, 0, 0, 1),
(290, 3, 24, 29, 0, 0, 1),
(291, 3, 25, 29, 0, 0, 1),
(292, 3, 26, 29, 0, 0, 1),
(293, 3, 27, 29, 0, 0, 1),
(294, 3, 44, 29, 0, 0, 1),
(295, 3, 45, 29, 0, 0, 1),
(296, 3, 46, 7, 5, 0, 1),
(297, 3, 47, 29, 0, 0, 1),
(298, 3, 34, 29, 0, 0, 1),
(299, 3, 35, 29, 0, 0, 1),
(300, 3, 36, 5, 7, 0, 1),
(301, 3, 37, 29, 0, 0, 1),
(302, 3, 41, 30, 0, 0, 1),
(303, 3, 31, 31, 0, 0, 1),
(304, 4, 18, 3, 7, 0, 1),
(305, 4, 47, 3, 7, 0, 1),
(306, 4, 21, 7, 0, 0, 1),
(307, 4, 28, 4, 0, 0, 1),
(308, 4, 37, 7, 0, 0, 1),
(309, 4, 38, 7, 0, 0, 1),
(310, 4, 22, 43, 0, 0, 1),
(311, 4, 23, 43, 0, 0, 1),
(312, 4, 11, 43, 0, 0, 1),
(313, 4, 12, 43, 0, 0, 1),
(314, 4, 13, 43, 0, 0, 1),
(315, 4, 33, 43, 0, 0, 1),
(316, 4, 32, 43, 0, 0, 1),
(317, 4, 31, 43, 0, 0, 1),
(318, 4, 41, 43, 0, 0, 1),
(319, 4, 42, 43, 0, 0, 1),
(320, 4, 43, 43, 0, 0, 1),
(321, 4, 12, 34, 0, 0, 1),
(322, 4, 41, 59, 0, 0, 1),
(323, 5, 17, 7, 0, 0, 1),
(324, 5, 26, 7, 3, 0, 1),
(325, 5, 47, 7, 0, 0, 1),
(326, 5, 45, 7, 0, 0, 1),
(327, 5, 44, 7, 0, 0, 1),
(328, 5, 34, 7, 0, 0, 1),
(329, 5, 35, 7, 0, 0, 1),
(330, 5, 36, 7, 2, 5, 1),
(331, 5, 37, 7, 0, 0, 1),
(332, 5, 38, 7, 0, 0, 1),
(333, 5, 41, 34, 0, 0, 1),
(334, 5, 41, 30, 0, 0, 1),
(335, 5, 41, 31, 0, 0, 1),
(336, 6, 18, 7, 0, 0, 1),
(337, 6, 17, 5, 0, 0, 1),
(338, 6, 16, 7, 5, 0, 1),
(339, 6, 25, 7, 3, 0, 1),
(340, 6, 27, 7, 0, 0, 1),
(341, 6, 28, 7, 0, 0, 1),
(342, 6, 36, 7, 0, 0, 1),
(343, 6, 37, 7, 0, 0, 1),
(344, 6, 48, 4, 0, 0, 1),
(345, 6, 47, 7, 5, 0, 1),
(346, 6, 11, 43, 0, 0, 1),
(347, 6, 12, 43, 0, 0, 1),
(348, 6, 13, 43, 0, 0, 1),
(349, 6, 21, 43, 0, 0, 1),
(350, 6, 22, 43, 0, 0, 1),
(351, 6, 23, 43, 0, 0, 1),
(352, 6, 43, 43, 0, 0, 1),
(353, 6, 42, 43, 0, 0, 1),
(354, 6, 41, 43, 0, 0, 1),
(355, 6, 31, 43, 0, 0, 1),
(356, 6, 32, 43, 0, 0, 1),
(357, 6, 33, 43, 0, 0, 1),
(358, 6, 41, 33, 0, 0, 1),
(359, 6, 41, 30, 0, 0, 1),
(360, 6, 41, 32, 0, 0, 1),
(361, 6, 41, 59, 0, 0, 1),
(362, 6, 46, 57, 0, 0, 1),
(363, 6, 48, 57, 0, 0, 1),
(364, 7, 18, 7, 0, 0, 1),
(365, 7, 21, 7, 4, 5, 1),
(366, 7, 47, 7, 0, 0, 1),
(367, 7, 46, 7, 5, 0, 1),
(368, 7, 34, 7, 0, 0, 1),
(369, 7, 36, 7, 5, 0, 1),
(370, 7, 37, 7, 0, 0, 1),
(371, 7, 22, 43, 0, 0, 1),
(372, 7, 23, 43, 0, 0, 1),
(373, 7, 11, 43, 0, 0, 1),
(374, 7, 12, 43, 0, 0, 1),
(375, 7, 13, 43, 0, 0, 1),
(376, 7, 43, 43, 0, 0, 1),
(377, 7, 42, 43, 0, 0, 1),
(378, 7, 41, 43, 0, 0, 1),
(379, 7, 31, 43, 0, 0, 1),
(380, 7, 32, 43, 0, 0, 1),
(381, 7, 33, 43, 0, 0, 1),
(382, 7, 41, 59, 0, 0, 1),
(383, 7, 31, 30, 0, 0, 1),
(384, 7, 41, 32, 0, 0, 1),
(385, 8, 15, 7, 0, 0, 1),
(386, 8, 26, 7, 0, 0, 1),
(387, 8, 48, 7, 0, 0, 1),
(388, 8, 47, 7, 0, 0, 1),
(389, 8, 46, 7, 3, 0, 1),
(390, 8, 45, 7, 0, 0, 1),
(391, 8, 36, 7, 0, 0, 1),
(392, 8, 37, 7, 0, 0, 1),
(393, 8, 35, 7, 3, 5, 1),
(394, 8, 35, 16, 0, 0, 1),
(395, 8, 41, 30, 0, 0, 1),
(396, 8, 41, 33, 0, 0, 1),
(397, 8, 41, 32, 0, 0, 1),
(398, 8, 35, 57, 0, 0, 1),
(399, 9, 16, 7, 0, 0, 1),
(400, 9, 26, 7, 0, 0, 1),
(401, 9, 27, 7, 0, 0, 1),
(402, 9, 28, 7, 0, 0, 1),
(403, 9, 47, 7, 0, 0, 1),
(404, 9, 46, 7, 5, 0, 1),
(405, 9, 35, 7, 0, 0, 1),
(406, 9, 36, 57, 0, 0, 1),
(407, 9, 36, 17, 0, 0, 1),
(408, 9, 41, 33, 0, 0, 1),
(409, 9, 31, 30, 0, 0, 1),
(410, 9, 31, 31, 0, 0, 1),
(411, 9, 41, 58, 0, 0, 1),
(412, 9, 36, 23, 0, 0, 1),
(413, 9, 36, 9, 0, 0, 1),
(414, 10, 18, 7, 0, 0, 1),
(415, 10, 17, 7, 0, 0, 1),
(416, 10, 26, 7, 5, 0, 1),
(417, 10, 27, 7, 0, 0, 1),
(418, 10, 46, 5, 7, 0, 1),
(419, 10, 36, 7, 0, 0, 1),
(420, 10, 37, 7, 0, 0, 1),
(421, 10, 41, 30, 0, 0, 1),
(422, 10, 31, 31, 0, 0, 1),
(423, 10, 47, 7, 0, 0, 1),
(424, 11, 55, 29, 0, 0, 1),
(425, 11, 85, 29, 0, 0, 1),
(426, 11, 75, 29, 0, 0, 1),
(427, 11, 74, 7, 0, 0, 1),
(428, 11, 84, 7, 0, 0, 1),
(429, 11, 54, 7, 0, 0, 1),
(430, 11, 64, 7, 0, 0, 1),
(431, 11, 65, 7, 0, 0, 1),
(432, 11, 81, 12, 0, 0, 1),
(433, 11, 41, 32, 0, 0, 1),
(434, 11, 31, 58, 0, 0, 1),
(435, 12, 17, 7, 0, 0, 1),
(436, 12, 16, 7, 5, 0, 1),
(437, 12, 26, 7, 0, 0, 1),
(438, 12, 31, 3, 0, 0, 1),
(439, 12, 34, 5, 0, 0, 1),
(440, 12, 35, 7, 0, 0, 1),
(441, 12, 41, 30, 0, 0, 1),
(442, 12, 41, 33, 0, 0, 1),
(443, 12, 11, 63, 0, 0, 1),
(444, 12, 41, 66, 0, 0, 1),
(445, 12, 28, 57, 0, 0, 1),
(446, 12, 81, 31, 0, 0, 1),
(447, 13, 81, 33, 0, 0, 1),
(448, 13, 81, 30, 0, 0, 1),
(449, 13, 71, 31, 0, 0, 1),
(450, 13, 11, 45, 0, 0, 1),
(451, 13, 14, 7, 0, 0, 1),
(452, 13, 16, 7, 0, 0, 1),
(453, 13, 18, 7, 0, 0, 1),
(454, 13, 24, 7, 0, 0, 1),
(455, 13, 26, 7, 5, 0, 1),
(456, 13, 27, 7, 0, 0, 1),
(457, 13, 37, 7, 0, 0, 1),
(458, 13, 36, 5, 7, 0, 1),
(459, 13, 35, 7, 0, 0, 1),
(460, 13, 45, 7, 5, 0, 1),
(461, 13, 47, 7, 0, 0, 1),
(462, 13, 21, 58, 0, 0, 1),
(463, 14, 81, 33, 0, 0, 1),
(464, 14, 81, 30, 0, 0, 1),
(465, 14, 71, 32, 0, 0, 1),
(466, 14, 17, 7, 0, 0, 1),
(467, 14, 47, 7, 0, 0, 1),
(468, 14, 46, 7, 0, 0, 1),
(469, 14, 36, 7, 5, 0, 1),
(470, 14, 37, 7, 0, 0, 1),
(471, 14, 31, 58, 0, 0, 1),
(472, 15, 11, 58, 0, 0, 1),
(473, 15, 21, 34, 0, 0, 1),
(474, 15, 21, 30, 0, 0, 1),
(475, 15, 21, 31, 0, 0, 1),
(476, 15, 16, 6, 0, 0, 1),
(477, 15, 15, 6, 0, 0, 1),
(478, 15, 14, 6, 0, 0, 1),
(479, 15, 24, 6, 0, 0, 1),
(480, 15, 26, 6, 0, 0, 1),
(481, 15, 35, 6, 0, 0, 1),
(482, 15, 34, 6, 0, 0, 1),
(483, 15, 44, 6, 0, 0, 1),
(484, 15, 12, 4, 3, 0, 1),
(485, 15, 15, 7, 0, 0, 1),
(486, 15, 24, 42, 0, 0, 1),
(487, 15, 24, 23, 0, 0, 1),
(488, 15, 24, 9, 0, 0, 1),
(489, 15, 25, 9, 0, 0, 1),
(490, 15, 26, 9, 0, 0, 1),
(491, 15, 26, 7, 5, 0, 1),
(492, 15, 37, 7, 5, 0, 1),
(493, 15, 36, 7, 5, 0, 1),
(494, 15, 35, 7, 0, 0, 1),
(495, 15, 47, 24, 0, 0, 1),
(496, 15, 48, 7, 0, 0, 1),
(497, 15, 24, 57, 0, 0, 1),
(498, 15, 47, 57, 0, 0, 1),
(499, 16, 21, 30, 0, 0, 1),
(500, 16, 11, 31, 0, 0, 1),
(501, 16, 53, 78, 0, 0, 1),
(502, 16, 74, 78, 0, 0, 1),
(503, 16, 84, 78, 0, 0, 1),
(504, 16, 16, 7, 0, 0, 1),
(505, 16, 26, 7, 0, 0, 1),
(506, 16, 36, 7, 0, 0, 1),
(507, 16, 54, 5, 0, 0, 1),
(508, 16, 84, 12, 0, 0, 1),
(509, 16, 74, 12, 0, 0, 1),
(510, 16, 31, 58, 0, 0, 1),
(511, 17, 18, 39, 0, 0, 1),
(512, 17, 18, 14, 0, 0, 1),
(513, 17, 17, 7, 0, 0, 1),
(514, 17, 16, 7, 5, 0, 1),
(515, 17, 15, 7, 0, 0, 1),
(516, 17, 14, 7, 0, 0, 1),
(517, 17, 13, 7, 0, 0, 1),
(518, 17, 22, 7, 0, 0, 1),
(519, 17, 23, 7, 0, 0, 1),
(520, 17, 24, 7, 0, 0, 1),
(521, 17, 25, 7, 0, 0, 1),
(522, 17, 26, 57, 0, 0, 1),
(523, 17, 26, 17, 0, 0, 1),
(524, 17, 27, 7, 0, 0, 1),
(525, 17, 28, 13, 0, 0, 1),
(526, 17, 47, 7, 5, 0, 1),
(527, 17, 45, 7, 0, 0, 1),
(528, 17, 44, 7, 0, 0, 1),
(529, 17, 34, 7, 0, 0, 1),
(530, 17, 36, 57, 0, 0, 1),
(531, 17, 36, 17, 0, 0, 1),
(532, 17, 37, 7, 5, 0, 1),
(533, 17, 26, 9, 0, 0, 1),
(534, 17, 36, 9, 0, 0, 1),
(535, 17, 26, 23, 0, 0, 1),
(536, 17, 36, 23, 0, 0, 1),
(537, 17, 0, 34, 0, 0, 1),
(538, 17, 0, 30, 0, 0, 1),
(539, 17, 0, 31, 0, 0, 1),
(540, 18, 0, 30, 0, 0, 1),
(541, 18, 0, 33, 0, 0, 1),
(542, 18, 0, 31, 0, 0, 1),
(543, 18, 0, 60, 0, 0, 1),
(544, 18, 16, 7, 0, 0, 1),
(545, 18, 15, 7, 0, 0, 1),
(546, 18, 14, 6, 0, 0, 1),
(547, 18, 13, 6, 0, 0, 1),
(548, 18, 24, 6, 0, 0, 1),
(549, 18, 25, 6, 0, 0, 1),
(550, 18, 26, 7, 0, 0, 1),
(551, 18, 38, 80, 0, 0, 1),
(552, 18, 38, 7, 0, 0, 1),
(553, 18, 36, 7, 5, 0, 1),
(554, 18, 32, 6, 0, 0, 1),
(555, 18, 46, 7, 0, 0, 1),
(556, 19, 0, 30, 0, 0, 1),
(557, 19, 0, 33, 0, 0, 1),
(558, 19, 12, 6, 0, 0, 1),
(559, 19, 14, 6, 0, 0, 1),
(560, 19, 16, 6, 0, 0, 1),
(561, 19, 31, 6, 0, 0, 1),
(562, 19, 32, 6, 0, 0, 1),
(563, 19, 36, 6, 0, 0, 1),
(564, 19, 41, 6, 0, 0, 1),
(565, 19, 42, 6, 0, 0, 1),
(566, 19, 47, 6, 0, 0, 1),
(567, 20, 0, 30, 0, 0, 1),
(568, 20, 0, 31, 0, 0, 1),
(569, 20, 0, 35, 0, 0, 1),
(570, 20, 11, 5, 0, 0, 1),
(571, 20, 12, 5, 0, 0, 1),
(572, 20, 14, 7, 0, 0, 1),
(573, 20, 15, 7, 0, 0, 1),
(574, 20, 15, 9, 0, 0, 2),
(575, 20, 16, 9, 0, 0, 2),
(576, 20, 16, 12, 0, 0, 1),
(577, 20, 17, 7, 0, 0, 1),
(578, 20, 17, 9, 0, 0, 2),
(579, 20, 24, 7, 0, 0, 1),
(580, 20, 25, 7, 0, 0, 1),
(581, 20, 25, 9, 0, 0, 2),
(582, 20, 26, 9, 0, 0, 2),
(583, 20, 27, 7, 0, 0, 1),
(584, 20, 27, 9, 0, 0, 2),
(585, 20, 34, 7, 0, 0, 1),
(586, 20, 36, 5, 0, 0, 1),
(587, 20, 45, 9, 0, 0, 2),
(588, 20, 46, 9, 0, 0, 2),
(589, 20, 47, 7, 3, 0, 1),
(590, 20, 47, 9, 0, 0, 2),
(591, 20, 48, 7, 0, 0, 1),
(592, 21, 0, 30, 0, 0, 1),
(593, 21, 0, 33, 0, 0, 1),
(594, 21, 11, 9, 0, 0, 2),
(595, 21, 14, 7, 0, 0, 1),
(596, 21, 16, 7, 0, 0, 1),
(597, 21, 21, 4, 0, 0, 1),
(598, 21, 21, 57, 0, 0, 1),
(599, 21, 21, 9, 0, 0, 2),
(600, 21, 22, 4, 2, 0, 1),
(601, 21, 24, 7, 0, 0, 1),
(602, 21, 25, 7, 0, 0, 1),
(603, 21, 27, 7, 0, 0, 1),
(604, 21, 28, 7, 0, 0, 1),
(605, 21, 34, 7, 0, 0, 1),
(606, 21, 37, 7, 0, 0, 1),
(607, 21, 45, 7, 0, 0, 1),
(608, 21, 46, 7, 5, 0, 1),
(609, 22, 0, 30, 0, 0, 1),
(610, 22, 0, 33, 0, 0, 1),
(611, 22, 11, 15, 0, 0, 1),
(612, 22, 11, 9, 0, 0, 2),
(613, 22, 14, 7, 0, 0, 1),
(614, 22, 16, 7, 0, 0, 1),
(615, 22, 21, 4, 0, 0, 1),
(616, 22, 21, 57, 0, 0, 1),
(617, 22, 21, 9, 0, 0, 2),
(618, 22, 22, 4, 0, 0, 1),
(619, 22, 24, 7, 0, 0, 1),
(620, 22, 25, 7, 0, 0, 1),
(621, 22, 27, 7, 0, 0, 1),
(622, 22, 28, 7, 0, 0, 1),
(623, 22, 34, 7, 0, 0, 1),
(624, 22, 37, 7, 0, 0, 1),
(625, 22, 45, 7, 0, 0, 1),
(626, 22, 46, 7, 5, 0, 1),
(627, 23, 0, 32, 0, 0, 1),
(628, 23, 0, 61, 0, 0, 1),
(629, 23, 0, 30, 0, 0, 1),
(630, 23, 16, 7, 0, 0, 1),
(631, 23, 26, 29, 0, 0, 1),
(632, 23, 36, 5, 0, 0, 1),
(633, 23, 36, 29, 0, 0, 1),
(634, 23, 46, 5, 0, 0, 1),
(635, 23, 46, 29, 0, 0, 1),
(636, 23, 55, 29, 0, 0, 1),
(637, 23, 55, 5, 0, 0, 1),
(638, 23, 65, 29, 0, 0, 1),
(639, 23, 65, 5, 0, 0, 1),
(640, 23, 75, 5, 0, 0, 1),
(641, 23, 75, 29, 0, 0, 1),
(642, 23, 84, 7, 0, 0, 1),
(643, 23, 85, 5, 0, 0, 1),
(644, 23, 85, 29, 0, 0, 1),
(645, 24, 0, 30, 0, 0, 1),
(646, 24, 0, 12, 0, 0, 1),
(647, 24, 0, 37, 0, 0, 1),
(648, 24, 0, 39, 0, 0, 1),
(649, 24, 0, 32, 0, 0, 1),
(650, 24, 21, 12, 0, 0, 1),
(651, 24, 54, 29, 0, 0, 1),
(652, 24, 55, 29, 0, 0, 1),
(653, 24, 64, 29, 0, 0, 1),
(654, 24, 65, 29, 0, 0, 1),
(655, 24, 74, 29, 0, 0, 1),
(656, 24, 75, 29, 0, 0, 1),
(657, 24, 84, 7, 0, 0, 1),
(658, 24, 84, 78, 0, 0, 1),
(659, 24, 85, 29, 0, 0, 1),
(660, 25, 0, 33, 0, 0, 1),
(661, 25, 0, 31, 0, 0, 1),
(662, 25, 0, 30, 0, 0, 1),
(663, 25, 14, 7, 0, 0, 1),
(664, 25, 15, 7, 0, 0, 1),
(665, 25, 16, 7, 0, 0, 1),
(666, 25, 17, 7, 0, 0, 1),
(667, 25, 24, 7, 0, 0, 1),
(668, 25, 25, 7, 0, 0, 1),
(669, 25, 26, 7, 0, 0, 1),
(670, 25, 27, 7, 0, 0, 1),
(671, 25, 36, 7, 5, 0, 1),
(672, 25, 37, 7, 0, 0, 1),
(673, 25, 46, 57, 0, 0, 1),
(674, 25, 46, 12, 0, 0, 1),
(675, 25, 47, 7, 0, 0, 1),
(676, 26, 0, 58, 0, 0, 1),
(677, 26, 0, 31, 0, 0, 1),
(678, 26, 0, 33, 0, 0, 1),
(679, 26, 0, 30, 0, 0, 1),
(680, 26, 14, 29, 0, 0, 1),
(681, 26, 15, 29, 0, 0, 1),
(682, 26, 16, 29, 0, 0, 1),
(683, 26, 17, 29, 0, 0, 1),
(684, 26, 24, 29, 0, 0, 1),
(685, 26, 25, 29, 0, 0, 1),
(686, 26, 26, 29, 0, 0, 1),
(687, 26, 27, 29, 0, 0, 1),
(688, 26, 34, 29, 0, 0, 1),
(689, 26, 35, 29, 0, 0, 1),
(690, 26, 36, 29, 0, 0, 1),
(691, 26, 37, 29, 0, 0, 1),
(692, 26, 44, 29, 0, 0, 1),
(693, 26, 45, 29, 0, 0, 1),
(694, 26, 46, 29, 0, 0, 1),
(695, 27, 0, 30, 0, 0, 1),
(696, 27, 0, 31, 0, 0, 1),
(697, 27, 0, 35, 0, 0, 1),
(698, 27, 0, 58, 0, 0, 1),
(699, 27, 18, 7, 0, 0, 1),
(700, 27, 27, 7, 0, 0, 1),
(701, 27, 28, 14, 0, 0, 1),
(702, 27, 28, 57, 0, 0, 1),
(703, 27, 35, 7, 0, 0, 1),
(704, 27, 36, 9, 0, 0, 2),
(705, 27, 36, 42, 0, 0, 2),
(706, 27, 36, 23, 0, 0, 2),
(707, 27, 36, 57, 0, 0, 1),
(708, 27, 37, 7, 0, 0, 1),
(709, 27, 45, 7, 0, 0, 1),
(710, 27, 46, 7, 0, 0, 1),
(711, 27, 47, 7, 0, 0, 1),
(712, 27, 48, 57, 0, 0, 1),
(713, 28, 0, 33, 0, 0, 1),
(714, 28, 0, 31, 0, 0, 1),
(715, 28, 0, 58, 0, 0, 1),
(716, 28, 0, 30, 0, 0, 1),
(717, 28, 16, 7, 0, 0, 1),
(718, 28, 16, 6, 0, 0, 1),
(719, 28, 17, 7, 0, 0, 1),
(720, 28, 25, 6, 0, 0, 1),
(721, 28, 31, 6, 0, 0, 1),
(722, 28, 32, 6, 0, 0, 1),
(723, 28, 36, 57, 0, 0, 1),
(724, 28, 37, 7, 0, 0, 1),
(725, 28, 41, 6, 0, 0, 1),
(726, 28, 42, 6, 0, 0, 1),
(727, 29, 0, 58, 0, 0, 1),
(728, 29, 0, 35, 0, 0, 1),
(729, 29, 0, 47, 0, 0, 1),
(730, 29, 0, 30, 0, 0, 1),
(731, 29, 13, 3, 0, 0, 1),
(732, 29, 14, 3, 7, 0, 1),
(733, 29, 14, 79, 0, 0, 1),
(734, 29, 17, 57, 0, 0, 1),
(735, 29, 17, 12, 0, 0, 1),
(736, 29, 18, 47, 0, 0, 1),
(737, 29, 25, 3, 7, 0, 1),
(738, 29, 27, 7, 0, 0, 1),
(739, 29, 28, 7, 0, 0, 1),
(740, 29, 34, 7, 0, 0, 1),
(741, 29, 35, 4, 7, 3, 1),
(742, 29, 45, 7, 4, 0, 1),
(743, 29, 45, 79, 0, 0, 1),
(744, 29, 48, 14, 0, 0, 1),
(745, 29, 48, 57, 0, 0, 1),
(746, 30, 11, 9, 0, 0, 2),
(747, 30, 12, 9, 0, 0, 2),
(748, 31, 0, 58, 0, 0, 1),
(749, 31, 0, 31, 0, 0, 1),
(750, 31, 0, 34, 0, 0, 1),
(751, 31, 0, 30, 0, 0, 1),
(752, 31, 14, 7, 0, 0, 1),
(753, 31, 14, 6, 0, 0, 1),
(754, 31, 15, 6, 0, 0, 1),
(755, 31, 16, 7, 0, 0, 1),
(756, 31, 16, 6, 0, 0, 1),
(757, 31, 17, 7, 0, 0, 1),
(758, 31, 18, 7, 0, 0, 1),
(759, 31, 26, 7, 0, 0, 1),
(760, 31, 26, 6, 0, 0, 1),
(761, 31, 27, 6, 0, 0, 1),
(762, 31, 27, 7, 0, 0, 1),
(763, 31, 36, 17, 0, 0, 1),
(764, 31, 36, 23, 0, 0, 1),
(765, 31, 36, 9, 0, 0, 1),
(766, 31, 36, 57, 0, 0, 1),
(767, 31, 37, 7, 0, 0, 1),
(768, 31, 44, 7, 0, 0, 1),
(769, 31, 47, 7, 0, 0, 1),
(770, 32, 0, 47, 0, 0, 1),
(771, 32, 16, 6, 0, 0, 1),
(772, 32, 16, 7, 0, 0, 1),
(773, 32, 17, 7, 0, 0, 1),
(774, 32, 25, 6, 0, 0, 1),
(775, 32, 31, 6, 0, 0, 1),
(776, 32, 32, 6, 0, 0, 1),
(777, 32, 36, 13, 0, 0, 1),
(778, 32, 37, 7, 4, 0, 1),
(779, 32, 41, 6, 0, 0, 1),
(780, 32, 42, 6, 0, 0, 1),
(781, 32, 43, 9, 0, 0, 1),
(782, 32, 43, 57, 0, 0, 1),
(783, 32, 45, 39, 0, 0, 1),
(784, 32, 45, 12, 0, 0, 1),
(785, 32, 46, 13, 0, 0, 1),
(786, 32, 48, 9, 0, 0, 1),
(787, 33, 0, 58, 0, 0, 1),
(788, 33, 0, 30, 0, 0, 1),
(789, 33, 0, 32, 0, 0, 1),
(790, 33, 51, 78, 0, 0, 1),
(791, 33, 61, 21, 0, 0, 1),
(792, 33, 65, 78, 0, 0, 1),
(793, 33, 65, 20, 0, 0, 1),
(794, 33, 74, 78, 0, 0, 1),
(795, 33, 74, 21, 0, 0, 1),
(796, 33, 75, 20, 0, 0, 1),
(797, 33, 84, 78, 0, 0, 1),
(798, 33, 84, 21, 0, 0, 1),
(799, 34, 0, 33, 0, 0, 1),
(800, 34, 0, 30, 0, 0, 1),
(801, 34, 0, 31, 0, 0, 1),
(802, 34, 0, 58, 0, 0, 1),
(803, 34, 13, 6, 0, 0, 1),
(804, 34, 16, 7, 5, 0, 1),
(805, 34, 25, 7, 3, 0, 1),
(806, 34, 25, 6, 0, 0, 1),
(807, 34, 26, 6, 0, 0, 1),
(808, 34, 26, 7, 0, 0, 1),
(809, 34, 34, 6, 0, 0, 1),
(810, 34, 34, 7, 4, 0, 1),
(811, 34, 35, 7, 0, 0, 1),
(812, 34, 35, 6, 0, 0, 1),
(813, 34, 38, 12, 0, 0, 1),
(814, 34, 42, 6, 0, 0, 1),
(815, 34, 43, 6, 0, 0, 1),
(816, 34, 45, 7, 0, 0, 1),
(817, 34, 48, 7, 0, 0, 1),
(818, 35, 0, 30, 0, 0, 1),
(819, 35, 0, 31, 0, 0, 1),
(820, 35, 0, 33, 0, 0, 1),
(821, 35, 14, 7, 0, 0, 1),
(822, 35, 15, 7, 4, 0, 1),
(823, 35, 17, 7, 5, 0, 1),
(824, 35, 24, 7, 0, 0, 1),
(825, 35, 25, 7, 0, 0, 1),
(826, 35, 26, 57, 0, 0, 1),
(827, 35, 26, 80, 0, 0, 1),
(828, 35, 26, 2, 5, 7, 1),
(829, 35, 27, 7, 0, 0, 1),
(830, 35, 34, 7, 0, 0, 1),
(831, 35, 35, 7, 0, 0, 1),
(832, 35, 36, 7, 5, 0, 1),
(833, 35, 44, 7, 0, 0, 1),
(834, 35, 45, 7, 0, 0, 1),
(835, 35, 46, 7, 5, 0, 1),
(836, 35, 47, 7, 5, 0, 1),
(837, 36, 0, 30, 0, 0, 1),
(838, 36, 0, 58, 0, 0, 1),
(839, 36, 0, 32, 0, 0, 1),
(840, 36, 54, 29, 0, 0, 1),
(841, 36, 55, 29, 0, 0, 1),
(842, 36, 64, 29, 0, 0, 1),
(843, 36, 65, 29, 0, 0, 1),
(844, 36, 74, 29, 0, 0, 1),
(845, 36, 75, 29, 0, 0, 1),
(846, 36, 84, 29, 0, 0, 1),
(847, 36, 85, 29, 0, 0, 1),
(848, 37, 0, 58, 0, 0, 1),
(849, 37, 0, 33, 0, 0, 1),
(850, 37, 0, 31, 0, 0, 1),
(851, 37, 0, 30, 0, 0, 1),
(852, 37, 12, 12, 0, 0, 1),
(853, 37, 13, 57, 0, 0, 1),
(854, 37, 16, 57, 0, 0, 1),
(855, 37, 18, 12, 0, 0, 1),
(856, 37, 24, 57, 0, 0, 1),
(857, 37, 26, 57, 0, 0, 1),
(858, 37, 34, 9, 0, 0, 1),
(859, 37, 45, 9, 0, 0, 1),
(860, 38, 0, 58, 0, 0, 1),
(861, 38, 0, 34, 0, 0, 1),
(862, 38, 0, 31, 0, 0, 1),
(863, 38, 0, 30, 0, 0, 1),
(864, 38, 14, 29, 0, 0, 2),
(865, 38, 15, 29, 0, 0, 2),
(866, 38, 16, 7, 0, 0, 1),
(867, 38, 17, 7, 0, 0, 1),
(868, 38, 18, 7, 0, 0, 1),
(869, 38, 24, 29, 0, 0, 2),
(870, 38, 26, 7, 0, 0, 1),
(871, 38, 27, 7, 0, 0, 1),
(872, 38, 34, 29, 0, 0, 2),
(873, 38, 35, 29, 0, 0, 2),
(874, 38, 36, 7, 5, 0, 1),
(875, 38, 37, 7, 0, 0, 1),
(876, 38, 44, 29, 0, 0, 2),
(877, 38, 45, 29, 0, 0, 2),
(878, 38, 46, 57, 0, 0, 1),
(879, 38, 46, 80, 0, 0, 1),
(880, 38, 46, 24, 0, 0, 1),
(881, 38, 47, 7, 0, 0, 1),
(882, 39, 0, 58, 0, 0, 1),
(883, 39, 0, 33, 0, 0, 1),
(884, 39, 0, 31, 0, 0, 1),
(885, 39, 11, 9, 0, 0, 2),
(886, 39, 12, 44, 0, 0, 1),
(887, 39, 13, 4, 2, 0, 1),
(888, 39, 13, 9, 0, 0, 2),
(889, 39, 14, 8, 0, 0, 2),
(890, 39, 14, 57, 0, 0, 1),
(891, 39, 15, 9, 0, 0, 2),
(892, 39, 16, 9, 0, 0, 2),
(893, 39, 16, 57, 0, 0, 1),
(894, 39, 17, 7, 0, 0, 1),
(895, 39, 17, 9, 0, 0, 2),
(896, 39, 22, 2, 4, 7, 1),
(897, 39, 23, 2, 4, 7, 1),
(898, 39, 26, 7, 3, 5, 1),
(899, 40, 0, 30, 0, 0, 1),
(900, 40, 0, 55, 0, 0, 1),
(901, 40, 0, 32, 0, 0, 1),
(902, 40, 51, 3, 0, 0, 1),
(903, 40, 54, 7, 0, 0, 1),
(904, 40, 55, 29, 0, 0, 1),
(905, 40, 61, 4, 0, 0, 1),
(906, 40, 64, 7, 0, 0, 1),
(907, 40, 65, 7, 0, 0, 1),
(908, 40, 74, 54, 0, 0, 1),
(909, 40, 74, 7, 3, 0, 1),
(910, 40, 74, 21, 0, 0, 1),
(911, 40, 75, 20, 0, 0, 1),
(912, 40, 75, 78, 0, 0, 1),
(913, 40, 75, 4, 7, 0, 1),
(914, 40, 84, 20, 0, 0, 1),
(915, 40, 84, 7, 0, 0, 1),
(916, 40, 85, 78, 0, 0, 1),
(917, 40, 85, 54, 0, 0, 1),
(918, 40, 85, 21, 0, 0, 1),
(919, 40, 85, 7, 3, 0, 1),
(920, 41, 0, 30, 0, 0, 1),
(921, 41, 0, 31, 0, 0, 1),
(922, 41, 0, 58, 0, 0, 1),
(923, 41, 64, 7, 0, 0, 1),
(924, 41, 74, 7, 0, 0, 1),
(925, 41, 85, 7, 0, 0, 1),
(926, 42, 0, 31, 0, 0, 1),
(927, 42, 0, 30, 0, 0, 1),
(928, 42, 0, 34, 0, 0, 1),
(929, 42, 0, 58, 0, 0, 1),
(930, 42, 12, 6, 0, 0, 1),
(931, 42, 15, 6, 0, 0, 1),
(932, 42, 26, 7, 4, 0, 1),
(933, 42, 26, 80, 0, 0, 1),
(934, 42, 26, 6, 0, 0, 1),
(935, 42, 26, 57, 0, 0, 1),
(936, 42, 35, 7, 0, 0, 1),
(937, 42, 36, 7, 0, 0, 1),
(938, 42, 44, 7, 0, 0, 1),
(939, 42, 46, 7, 3, 0, 1),
(940, 43, 0, 48, 0, 0, 1),
(941, 43, 0, 85, 0, 0, 1),
(942, 43, 14, 12, 0, 0, 1),
(943, 43, 16, 12, 0, 0, 1),
(944, 43, 25, 12, 0, 0, 1),
(945, 43, 26, 13, 0, 0, 1),
(946, 43, 34, 57, 0, 0, 1),
(947, 43, 34, 9, 0, 0, 1),
(948, 43, 45, 57, 0, 0, 1),
(949, 43, 45, 9, 0, 0, 1),
(950, 44, 0, 30, 0, 0, 1),
(951, 44, 0, 58, 0, 0, 1),
(952, 44, 0, 34, 0, 0, 1),
(953, 44, 0, 31, 0, 0, 1),
(954, 44, 14, 7, 0, 0, 1),
(955, 44, 15, 7, 0, 0, 1),
(956, 44, 16, 7, 0, 0, 1),
(957, 44, 17, 7, 0, 0, 1),
(958, 44, 18, 7, 0, 0, 1),
(959, 44, 24, 7, 0, 0, 1),
(960, 44, 25, 7, 0, 0, 1),
(961, 44, 26, 7, 0, 0, 1),
(962, 44, 27, 7, 0, 0, 1),
(963, 44, 28, 7, 0, 0, 1),
(964, 44, 36, 57, 0, 0, 1),
(965, 44, 36, 80, 0, 0, 1),
(966, 44, 36, 7, 0, 0, 1),
(967, 44, 38, 7, 0, 0, 1),
(968, 44, 45, 4, 0, 0, 1),
(969, 44, 46, 5, 3, 0, 1),
(970, 45, 0, 31, 0, 0, 1),
(971, 45, 0, 34, 0, 0, 1),
(972, 45, 0, 30, 0, 0, 1),
(973, 45, 16, 7, 5, 0, 1),
(974, 45, 17, 7, 0, 0, 1),
(975, 45, 25, 6, 0, 0, 1),
(976, 45, 25, 79, 0, 0, 1),
(977, 45, 25, 7, 3, 0, 1),
(978, 45, 26, 4, 7, 5, 1),
(979, 45, 36, 7, 0, 0, 1),
(980, 45, 37, 7, 0, 0, 1),
(981, 45, 46, 7, 5, 0, 1),
(982, 45, 47, 7, 2, 0, 1),
(983, 45, 48, 7, 0, 0, 1),
(984, 46, 0, 58, 0, 0, 1),
(985, 46, 0, 32, 0, 0, 1),
(986, 46, 0, 30, 0, 0, 1),
(987, 46, 0, 35, 0, 0, 1),
(988, 46, 14, 7, 0, 0, 1),
(989, 46, 15, 7, 0, 0, 1),
(990, 46, 16, 7, 5, 0, 1),
(991, 46, 17, 7, 0, 0, 1),
(992, 46, 24, 7, 0, 0, 1),
(993, 46, 25, 7, 0, 0, 1),
(994, 46, 26, 7, 5, 0, 1),
(995, 46, 27, 7, 0, 0, 1),
(996, 46, 37, 7, 0, 0, 1),
(997, 46, 47, 7, 0, 0, 1),
(998, 46, 48, 7, 0, 0, 1),
(999, 47, 0, 33, 0, 0, 1),
(1000, 47, 0, 30, 0, 0, 1),
(1001, 47, 0, 31, 0, 0, 1),
(1002, 47, 14, 7, 0, 0, 1),
(1003, 47, 24, 7, 0, 0, 1),
(1004, 47, 34, 7, 4, 0, 1),
(1005, 47, 36, 17, 0, 0, 1),
(1006, 47, 36, 24, 0, 0, 1),
(1007, 47, 36, 57, 0, 0, 1),
(1008, 47, 37, 12, 0, 0, 1),
(1009, 47, 38, 7, 0, 0, 1),
(1010, 47, 47, 7, 0, 0, 1),
(1011, 48, 0, 58, 0, 0, 1),
(1012, 48, 0, 30, 0, 0, 1),
(1013, 48, 0, 33, 0, 0, 1),
(1014, 48, 0, 61, 0, 0, 1),
(1015, 48, 16, 91, 0, 0, 1),
(1016, 48, 16, 57, 0, 0, 1),
(1017, 48, 23, 12, 0, 0, 1),
(1018, 48, 24, 91, 0, 0, 1),
(1019, 48, 34, 57, 0, 0, 1),
(1020, 49, 0, 30, 0, 0, 1),
(1021, 49, 0, 97, 0, 0, 1),
(1022, 49, 0, 31, 0, 0, 1),
(1023, 49, 0, 58, 0, 0, 1),
(1024, 49, 11, 9, 0, 0, 1),
(1025, 49, 12, 9, 0, 0, 1),
(1026, 49, 13, 57, 0, 0, 1),
(1027, 49, 13, 15, 0, 0, 1),
(1028, 49, 13, 9, 0, 0, 1),
(1029, 49, 14, 7, 0, 0, 1),
(1030, 49, 15, 7, 0, 0, 1),
(1031, 49, 17, 7, 0, 0, 1),
(1032, 49, 21, 57, 0, 0, 1),
(1033, 49, 21, 3, 0, 0, 1),
(1034, 49, 21, 15, 0, 0, 1),
(1035, 49, 21, 9, 0, 0, 1),
(1036, 49, 22, 3, 5, 0, 1),
(1037, 49, 24, 7, 0, 0, 1),
(1038, 49, 25, 7, 0, 0, 1),
(1039, 49, 26, 7, 0, 0, 1),
(1040, 49, 35, 7, 3, 0, 1),
(1041, 49, 37, 7, 4, 5, 1),
(1042, 49, 44, 7, 0, 0, 1),
(1043, 49, 45, 7, 0, 0, 1),
(1044, 49, 46, 7, 5, 0, 1),
(1045, 49, 48, 7, 0, 0, 1),
(1046, 50, 0, 33, 0, 0, 1),
(1047, 50, 0, 58, 0, 0, 1),
(1048, 50, 11, 98, 0, 0, 1),
(1049, 50, 13, 57, 0, 0, 1),
(1050, 50, 23, 57, 0, 0, 1),
(1051, 50, 41, 98, 0, 0, 1),
(1052, 50, 43, 57, 0, 0, 1),
(1053, 51, 0, 58, 0, 0, 1),
(1054, 51, 0, 71, 0, 0, 1),
(1055, 51, 0, 30, 0, 0, 1),
(1056, 51, 0, 31, 0, 0, 1),
(1057, 51, 0, 70, 0, 0, 1),
(1058, 51, 14, 7, 0, 0, 1),
(1059, 51, 15, 7, 0, 0, 1),
(1060, 51, 16, 7, 5, 0, 1),
(1061, 51, 17, 7, 0, 0, 1),
(1062, 51, 24, 7, 0, 0, 1),
(1063, 51, 25, 7, 0, 0, 1),
(1064, 51, 26, 7, 5, 0, 1),
(1065, 51, 27, 7, 0, 0, 1),
(1066, 51, 34, 7, 0, 0, 1),
(1067, 51, 35, 7, 0, 0, 1),
(1068, 51, 36, 79, 0, 0, 1),
(1069, 51, 36, 7, 4, 5, 1),
(1070, 51, 37, 7, 0, 0, 1),
(1071, 51, 44, 7, 0, 0, 1),
(1072, 51, 45, 7, 0, 0, 1),
(1073, 51, 46, 7, 5, 0, 1),
(1074, 51, 47, 7, 0, 0, 1),
(1075, 52, 16, 6, 0, 0, 1),
(1076, 52, 17, 6, 0, 0, 1),
(1077, 52, 26, 79, 0, 0, 1),
(1078, 52, 26, 6, 0, 0, 1),
(1079, 52, 36, 79, 0, 0, 1),
(1080, 52, 46, 79, 0, 0, 1),
(1081, 53, 0, 58, 0, 0, 1),
(1082, 53, 0, 30, 0, 0, 1),
(1083, 53, 0, 32, 0, 0, 1),
(1084, 53, 0, 33, 0, 0, 1),
(1085, 53, 14, 7, 0, 0, 1),
(1086, 53, 15, 7, 0, 0, 1),
(1087, 53, 17, 7, 0, 0, 1),
(1088, 53, 24, 7, 0, 0, 1),
(1089, 53, 25, 7, 0, 0, 1),
(1090, 53, 27, 7, 0, 0, 1),
(1091, 53, 34, 7, 0, 0, 1),
(1092, 53, 35, 7, 0, 0, 1),
(1093, 53, 37, 57, 0, 0, 1),
(1094, 53, 44, 7, 0, 0, 1),
(1095, 53, 45, 7, 0, 0, 1),
(1096, 54, 0, 30, 0, 0, 1),
(1097, 54, 0, 58, 0, 0, 1),
(1098, 54, 0, 60, 0, 0, 1),
(1099, 54, 0, 31, 0, 0, 1),
(1100, 54, 0, 33, 0, 0, 1),
(1101, 54, 11, 2, 5, 0, 1),
(1102, 54, 14, 6, 0, 0, 1),
(1103, 54, 15, 6, 0, 0, 1),
(1104, 54, 15, 7, 3, 0, 1),
(1105, 54, 21, 5, 2, 0, 1),
(1106, 54, 32, 6, 0, 0, 1),
(1107, 55, 0, 32, 0, 0, 1),
(1108, 55, 0, 33, 0, 0, 1),
(1109, 55, 0, 30, 0, 0, 1),
(1110, 55, 0, 58, 0, 0, 1),
(1111, 55, 11, 57, 0, 0, 1),
(1112, 55, 12, 57, 0, 0, 1),
(1113, 55, 14, 7, 0, 0, 1),
(1114, 55, 15, 7, 0, 0, 1),
(1115, 55, 16, 7, 5, 0, 1),
(1116, 55, 17, 7, 0, 0, 1),
(1117, 55, 24, 7, 0, 0, 1),
(1118, 55, 25, 7, 0, 0, 1),
(1119, 55, 26, 7, 0, 0, 1),
(1120, 55, 27, 7, 0, 0, 1),
(1121, 55, 34, 7, 0, 0, 1),
(1122, 55, 35, 7, 0, 0, 1),
(1123, 55, 36, 7, 5, 0, 1),
(1124, 55, 37, 7, 0, 0, 1),
(1125, 55, 44, 7, 0, 0, 1),
(1126, 55, 45, 7, 0, 0, 1),
(1127, 55, 46, 7, 5, 0, 1),
(1128, 56, 0, 58, 0, 0, 1),
(1129, 56, 0, 30, 0, 0, 1),
(1130, 56, 0, 33, 0, 0, 1),
(1131, 56, 0, 31, 0, 0, 1),
(1132, 56, 11, 6, 0, 0, 1),
(1133, 56, 12, 6, 0, 0, 1),
(1134, 56, 13, 5, 0, 0, 1),
(1135, 56, 14, 7, 0, 0, 1),
(1136, 56, 14, 6, 0, 0, 1),
(1137, 56, 16, 6, 0, 0, 1),
(1138, 56, 21, 6, 0, 0, 1),
(1139, 56, 22, 6, 0, 0, 1),
(1140, 56, 23, 5, 0, 0, 1),
(1141, 56, 24, 7, 0, 0, 1),
(1142, 56, 24, 6, 0, 0, 1),
(1143, 56, 25, 7, 0, 0, 1),
(1144, 56, 25, 6, 0, 0, 1),
(1145, 56, 31, 6, 0, 0, 1),
(1146, 56, 32, 6, 0, 0, 1),
(1147, 56, 34, 7, 0, 0, 1),
(1148, 56, 34, 6, 0, 0, 1),
(1149, 56, 35, 7, 0, 0, 1),
(1150, 56, 35, 6, 0, 0, 1),
(1151, 56, 41, 6, 0, 0, 1),
(1152, 56, 42, 6, 0, 0, 1),
(1153, 56, 43, 6, 0, 0, 1),
(1154, 56, 44, 6, 0, 0, 1),
(1155, 56, 46, 57, 0, 0, 1),
(1156, 56, 46, 17, 0, 0, 1),
(1157, 56, 46, 24, 0, 0, 1),
(1158, 57, 0, 30, 0, 0, 1),
(1159, 57, 0, 35, 0, 0, 1),
(1160, 57, 0, 58, 0, 0, 1),
(1161, 57, 0, 31, 0, 0, 1),
(1162, 57, 11, 6, 0, 0, 1),
(1163, 57, 12, 6, 0, 0, 1),
(1164, 57, 13, 7, 0, 0, 1),
(1165, 57, 14, 7, 0, 0, 1),
(1166, 57, 14, 6, 0, 0, 1),
(1167, 57, 16, 6, 0, 0, 1),
(1168, 57, 21, 6, 0, 0, 1),
(1169, 57, 22, 6, 0, 0, 1),
(1170, 57, 23, 7, 0, 0, 1),
(1171, 57, 24, 6, 0, 0, 1),
(1172, 57, 24, 7, 0, 0, 1),
(1173, 57, 25, 6, 0, 0, 1),
(1174, 57, 25, 7, 0, 0, 1),
(1175, 57, 31, 6, 0, 0, 1),
(1176, 57, 32, 6, 0, 0, 1),
(1177, 57, 34, 7, 0, 0, 1),
(1178, 57, 34, 6, 0, 0, 1),
(1179, 57, 35, 7, 0, 0, 1),
(1180, 57, 35, 6, 0, 0, 1),
(1181, 57, 41, 6, 0, 0, 1),
(1182, 57, 42, 6, 0, 0, 1),
(1183, 57, 43, 6, 0, 0, 1),
(1184, 57, 44, 6, 0, 0, 1),
(1185, 57, 46, 57, 0, 0, 1),
(1186, 57, 46, 42, 0, 0, 1),
(1187, 57, 46, 24, 0, 0, 1),
(1188, 57, 47, 12, 0, 0, 1),
(1189, 58, 0, 60, 0, 0, 1),
(1190, 58, 0, 61, 0, 0, 1),
(1191, 58, 11, 7, 5, 0, 1),
(1192, 58, 12, 7, 5, 0, 1),
(1193, 58, 21, 7, 5, 0, 1),
(1194, 58, 22, 7, 5, 0, 1),
(1195, 59, 0, 30, 0, 0, 1),
(1196, 59, 0, 32, 0, 0, 1),
(1197, 59, 0, 58, 0, 0, 1),
(1198, 59, 0, 35, 0, 0, 1),
(1199, 59, 14, 29, 0, 0, 1),
(1200, 59, 15, 29, 0, 0, 1),
(1201, 59, 17, 7, 0, 0, 1),
(1202, 59, 18, 7, 0, 0, 1),
(1203, 59, 27, 7, 0, 0, 1),
(1204, 59, 28, 7, 0, 0, 1),
(1205, 59, 34, 7, 0, 0, 1),
(1206, 59, 35, 29, 0, 0, 1),
(1207, 59, 37, 29, 0, 0, 1),
(1208, 59, 38, 29, 0, 0, 1),
(1209, 59, 44, 7, 0, 0, 1),
(1210, 59, 45, 29, 0, 0, 1),
(1211, 59, 46, 80, 0, 0, 1),
(1212, 59, 46, 7, 5, 0, 1),
(1213, 59, 47, 7, 0, 0, 1),
(1214, 59, 48, 7, 0, 0, 1),
(1215, 60, 0, 58, 0, 0, 1),
(1216, 60, 0, 30, 0, 0, 1),
(1217, 60, 0, 61, 0, 0, 1),
(1218, 60, 0, 33, 0, 0, 1),
(1219, 60, 0, 32, 0, 0, 1),
(1220, 60, 11, 5, 0, 0, 1),
(1221, 60, 14, 29, 0, 0, 1),
(1222, 60, 15, 29, 0, 0, 1),
(1223, 60, 16, 7, 0, 0, 1),
(1224, 60, 17, 7, 0, 0, 1),
(1225, 60, 24, 29, 0, 0, 1),
(1226, 60, 25, 29, 0, 0, 1),
(1227, 60, 26, 7, 5, 0, 1),
(1228, 60, 27, 7, 0, 0, 1),
(1229, 60, 34, 29, 0, 0, 1),
(1230, 60, 35, 29, 0, 0, 1),
(1231, 60, 36, 7, 5, 0, 1),
(1232, 60, 36, 80, 0, 0, 1),
(1233, 60, 37, 7, 0, 0, 1),
(1234, 60, 44, 7, 0, 0, 1),
(1235, 60, 45, 29, 0, 0, 1),
(1236, 60, 46, 7, 5, 0, 1),
(1237, 60, 47, 7, 0, 0, 1),
(1238, 61, 0, 58, 0, 0, 1),
(1239, 61, 0, 60, 0, 0, 1),
(1240, 61, 0, 34, 0, 0, 1),
(1241, 61, 0, 31, 0, 0, 1),
(1242, 61, 0, 30, 0, 0, 1),
(1243, 61, 14, 7, 0, 0, 1),
(1244, 61, 15, 7, 0, 0, 1),
(1245, 61, 17, 7, 5, 0, 1),
(1246, 61, 27, 7, 5, 0, 1),
(1247, 61, 28, 7, 0, 0, 1),
(1248, 61, 34, 7, 0, 0, 1),
(1249, 61, 35, 7, 0, 0, 1),
(1250, 61, 44, 7, 0, 0, 1),
(1251, 61, 45, 7, 0, 0, 1),
(1252, 61, 48, 57, 0, 0, 1),
(1253, 61, 48, 77, 0, 0, 1),
(1254, 61, 48, 13, 0, 0, 1),
(1255, 62, 0, 30, 0, 0, 1),
(1256, 62, 0, 58, 0, 0, 1),
(1257, 62, 0, 33, 0, 0, 1),
(1258, 62, 0, 32, 0, 0, 1),
(1259, 62, 11, 7, 0, 0, 1),
(1260, 62, 12, 7, 0, 0, 1),
(1261, 62, 13, 7, 0, 0, 1),
(1262, 62, 14, 7, 0, 0, 1),
(1263, 62, 15, 7, 0, 0, 1),
(1264, 62, 16, 7, 5, 0, 1),
(1265, 62, 17, 7, 5, 0, 1),
(1266, 62, 18, 7, 0, 0, 1),
(1267, 62, 21, 7, 0, 0, 1),
(1268, 62, 22, 7, 0, 0, 1),
(1269, 62, 23, 7, 0, 0, 1),
(1270, 62, 24, 7, 0, 0, 1),
(1271, 62, 27, 7, 0, 0, 1),
(1272, 62, 28, 7, 0, 0, 1),
(1273, 62, 34, 57, 0, 0, 1),
(1274, 62, 34, 23, 0, 0, 1),
(1275, 62, 34, 87, 0, 0, 1),
(1276, 62, 34, 24, 0, 0, 1),
(1277, 62, 35, 7, 0, 0, 1),
(1278, 62, 36, 7, 5, 0, 1),
(1279, 62, 37, 7, 0, 0, 1),
(1280, 62, 44, 7, 0, 0, 1),
(1281, 62, 45, 7, 0, 0, 1),
(1282, 62, 46, 7, 5, 0, 1),
(1283, 62, 47, 7, 0, 0, 1),
(1284, 63, 0, 58, 0, 0, 1),
(1285, 63, 0, 35, 0, 0, 1),
(1286, 63, 0, 32, 0, 0, 1),
(1287, 63, 11, 2, 3, 0, 1),
(1288, 63, 15, 7, 3, 0, 1),
(1289, 63, 21, 4, 0, 0, 1),
(1290, 63, 34, 3, 0, 0, 1),
(1291, 63, 37, 7, 0, 0, 1),
(1292, 63, 47, 7, 0, 0, 1),
(1293, 64, 0, 58, 0, 0, 1),
(1294, 64, 0, 30, 0, 0, 1),
(1295, 64, 0, 32, 0, 0, 1),
(1296, 64, 16, 29, 0, 0, 1),
(1297, 64, 22, 78, 0, 0, 1),
(1298, 64, 26, 29, 0, 0, 1),
(1299, 64, 36, 29, 0, 0, 1),
(1300, 64, 46, 29, 0, 0, 1),
(1301, 64, 52, 95, 0, 0, 1),
(1302, 64, 54, 3, 7, 0, 1),
(1303, 64, 55, 7, 0, 0, 1),
(1304, 64, 62, 95, 0, 0, 1),
(1305, 64, 64, 7, 3, 0, 1),
(1306, 64, 65, 3, 0, 0, 1),
(1307, 64, 74, 7, 0, 0, 1),
(1308, 64, 75, 7, 0, 0, 1),
(1309, 64, 84, 7, 0, 0, 1),
(1310, 64, 85, 7, 0, 0, 1),
(1311, 65, 0, 35, 0, 0, 1),
(1312, 65, 0, 61, 0, 0, 1),
(1313, 65, 0, 32, 0, 0, 1),
(1314, 65, 0, 58, 0, 0, 1),
(1315, 65, 11, 2, 0, 0, 1),
(1316, 65, 16, 6, 0, 0, 1),
(1317, 65, 21, 2, 0, 0, 1),
(1318, 65, 34, 3, 0, 0, 1),
(1319, 65, 35, 7, 4, 0, 1),
(1320, 65, 35, 6, 0, 0, 1),
(1321, 65, 44, 7, 0, 0, 1),
(1322, 65, 47, 57, 0, 0, 1),
(1323, 65, 47, 17, 0, 0, 1),
(1324, 65, 47, 23, 0, 0, 1),
(1325, 66, 0, 35, 0, 0, 1),
(1326, 66, 0, 58, 0, 0, 1),
(1327, 66, 0, 30, 0, 0, 1),
(1328, 66, 0, 32, 0, 0, 1),
(1329, 66, 11, 2, 0, 0, 1),
(1330, 66, 16, 6, 0, 0, 1),
(1331, 66, 21, 2, 0, 0, 1),
(1332, 66, 34, 3, 0, 0, 1),
(1333, 66, 35, 4, 7, 0, 1),
(1334, 66, 35, 6, 0, 0, 1),
(1335, 66, 44, 7, 0, 0, 1),
(1336, 66, 47, 57, 0, 0, 1),
(1337, 66, 47, 17, 0, 0, 1),
(1338, 66, 47, 23, 0, 0, 1),
(1339, 66, 47, 7, 0, 0, 1),
(1340, 67, 0, 58, 0, 0, 1),
(1341, 67, 0, 34, 0, 0, 1),
(1342, 67, 0, 30, 0, 0, 1),
(1343, 67, 0, 32, 0, 0, 1),
(1344, 67, 11, 4, 3, 5, 1),
(1345, 67, 14, 7, 4, 0, 1),
(1346, 67, 15, 16, 0, 0, 1),
(1347, 67, 15, 9, 0, 0, 1),
(1348, 67, 17, 7, 0, 0, 1),
(1349, 67, 17, 80, 0, 0, 1),
(1350, 67, 21, 7, 4, 0, 1),
(1351, 67, 22, 4, 5, 3, 1),
(1352, 67, 24, 7, 0, 0, 1),
(1353, 67, 34, 7, 0, 0, 1),
(1354, 67, 35, 7, 0, 0, 1),
(1355, 67, 36, 80, 0, 0, 1),
(1356, 67, 36, 7, 0, 0, 1),
(1357, 67, 37, 5, 0, 0, 1),
(1358, 67, 47, 7, 5, 0, 1),
(1359, 67, 48, 7, 0, 0, 1),
(1360, 68, 0, 58, 0, 0, 1),
(1361, 68, 0, 55, 0, 0, 1),
(1362, 68, 0, 30, 0, 0, 1),
(1363, 68, 0, 32, 0, 0, 1),
(1364, 68, 51, 12, 0, 0, 1),
(1365, 68, 51, 78, 0, 0, 1),
(1366, 68, 52, 5, 0, 0, 1),
(1367, 68, 53, 5, 0, 0, 1),
(1368, 68, 54, 7, 0, 0, 1),
(1369, 68, 55, 7, 0, 0, 1),
(1370, 68, 61, 12, 0, 0, 1),
(1371, 68, 62, 12, 0, 0, 1),
(1372, 68, 63, 5, 0, 0, 1),
(1373, 68, 64, 7, 0, 0, 1),
(1374, 68, 64, 21, 0, 0, 1),
(1375, 68, 64, 57, 0, 0, 1),
(1376, 68, 64, 79, 0, 0, 1),
(1377, 68, 65, 7, 0, 0, 1),
(1378, 68, 74, 7, 0, 0, 1),
(1379, 68, 74, 79, 0, 0, 1),
(1380, 68, 74, 20, 0, 0, 1),
(1381, 68, 74, 78, 0, 0, 1),
(1382, 68, 75, 7, 0, 0, 1),
(1383, 68, 84, 7, 0, 0, 1),
(1384, 68, 85, 7, 0, 0, 1),
(1385, 69, 0, 58, 0, 0, 1),
(1386, 69, 0, 35, 0, 0, 1),
(1387, 69, 0, 30, 0, 0, 1),
(1388, 69, 11, 57, 0, 0, 1),
(1389, 69, 12, 12, 0, 0, 1),
(1390, 69, 16, 7, 0, 0, 1),
(1391, 69, 17, 7, 0, 0, 1),
(1392, 69, 21, 12, 0, 0, 1),
(1393, 69, 26, 7, 0, 0, 1),
(1394, 69, 27, 7, 0, 0, 1),
(1395, 69, 34, 7, 5, 0, 1),
(1396, 69, 35, 7, 5, 0, 1),
(1397, 69, 37, 7, 0, 0, 1),
(1398, 69, 44, 7, 0, 0, 1),
(1399, 69, 45, 7, 0, 0, 1),
(1400, 69, 46, 7, 0, 0, 1),
(1401, 69, 47, 7, 0, 0, 1),
(1402, 70, 0, 58, 0, 0, 1),
(1403, 70, 0, 30, 0, 0, 1),
(1404, 70, 0, 32, 0, 0, 1),
(1405, 70, 0, 35, 0, 0, 1),
(1406, 70, 15, 7, 0, 0, 1),
(1407, 70, 16, 7, 5, 0, 1),
(1408, 70, 17, 7, 0, 0, 1),
(1409, 70, 18, 7, 0, 0, 1),
(1410, 70, 24, 7, 0, 0, 1),
(1411, 70, 25, 7, 0, 0, 1),
(1412, 70, 26, 7, 0, 0, 1),
(1413, 70, 27, 7, 0, 0, 1),
(1414, 70, 36, 5, 7, 0, 1),
(1415, 70, 36, 57, 0, 0, 1),
(1416, 70, 37, 7, 0, 0, 1),
(1417, 70, 38, 7, 0, 0, 1),
(1418, 70, 44, 6, 0, 0, 1),
(1419, 70, 46, 5, 0, 0, 1),
(1420, 70, 47, 7, 0, 0, 1),
(1421, 70, 48, 7, 0, 0, 1),
(1422, 71, 0, 58, 0, 0, 1),
(1423, 71, 15, 87, 0, 0, 1),
(1424, 71, 15, 23, 0, 0, 1),
(1425, 71, 15, 9, 0, 0, 1),
(1426, 72, 0, 30, 0, 0, 1),
(1427, 72, 0, 58, 0, 0, 1),
(1428, 72, 0, 33, 0, 0, 1),
(1429, 72, 0, 32, 0, 0, 1),
(1430, 72, 14, 6, 0, 0, 1),
(1431, 72, 17, 7, 5, 5, 1),
(1432, 72, 17, 6, 0, 0, 1),
(1433, 72, 24, 7, 0, 0, 1),
(1434, 72, 26, 7, 0, 0, 1),
(1435, 72, 36, 7, 5, 0, 1),
(1436, 72, 37, 7, 5, 0, 1),
(1437, 72, 38, 7, 0, 0, 1),
(1438, 72, 44, 6, 0, 0, 1),
(1439, 72, 45, 6, 0, 0, 1),
(1440, 72, 46, 7, 5, 0, 1),
(1441, 72, 46, 6, 0, 0, 1),
(1442, 72, 48, 7, 0, 0, 1),
(1443, 73, 11, 9, 0, 0, 1),
(1444, 73, 12, 9, 0, 0, 1),
(1445, 73, 13, 7, 0, 0, 1),
(1446, 73, 13, 15, 0, 0, 1),
(1447, 73, 13, 9, 0, 0, 1),
(1448, 73, 21, 7, 0, 0, 1),
(1449, 73, 21, 15, 0, 0, 1),
(1450, 73, 21, 9, 0, 0, 1),
(1451, 73, 22, 4, 0, 0, 1),
(1452, 74, 0, 30, 0, 0, 1),
(1453, 74, 0, 32, 0, 0, 1),
(1454, 74, 14, 29, 0, 0, 1),
(1455, 74, 15, 29, 0, 0, 1),
(1456, 74, 16, 7, 0, 0, 1),
(1457, 74, 24, 29, 0, 0, 1),
(1458, 74, 25, 29, 0, 0, 1),
(1459, 74, 26, 7, 0, 0, 1),
(1460, 74, 34, 29, 0, 0, 1),
(1461, 74, 35, 29, 0, 0, 1),
(1462, 74, 36, 7, 5, 0, 1),
(1463, 74, 44, 29, 0, 0, 1),
(1464, 74, 45, 29, 0, 0, 1),
(1465, 74, 46, 5, 0, 0, 1),
(1466, 75, 0, 30, 0, 0, 1),
(1467, 75, 0, 58, 0, 0, 1),
(1468, 75, 0, 32, 0, 0, 1),
(1469, 75, 14, 29, 0, 0, 1),
(1470, 75, 15, 29, 0, 0, 1),
(1471, 75, 16, 7, 0, 0, 1),
(1472, 75, 17, 29, 0, 0, 1),
(1473, 75, 24, 29, 0, 0, 1),
(1474, 75, 25, 29, 0, 0, 1),
(1475, 75, 26, 7, 0, 0, 1),
(1476, 75, 27, 29, 0, 0, 1),
(1477, 75, 34, 29, 0, 0, 1),
(1478, 75, 35, 29, 0, 0, 1),
(1479, 75, 36, 5, 7, 0, 1),
(1480, 75, 44, 29, 0, 0, 1),
(1481, 75, 45, 29, 0, 0, 1),
(1482, 75, 46, 5, 0, 0, 1),
(1483, 76, 0, 33, 0, 0, 1),
(1484, 76, 0, 60, 0, 0, 1),
(1485, 76, 0, 30, 0, 0, 1),
(1486, 76, 0, 31, 0, 0, 1),
(1487, 76, 17, 7, 4, 5, 1),
(1488, 76, 17, 79, 0, 0, 1),
(1489, 76, 26, 57, 0, 0, 1),
(1490, 76, 27, 7, 3, 5, 1),
(1491, 76, 27, 79, 0, 0, 1),
(1492, 76, 33, 4, 0, 0, 1),
(1493, 76, 43, 5, 0, 0, 1),
(1494, 76, 44, 7, 3, 0, 1),
(1495, 76, 46, 91, 0, 0, 1),
(1496, 77, 0, 58, 0, 0, 1),
(1497, 77, 0, 32, 0, 0, 1),
(1498, 77, 0, 30, 0, 0, 1),
(1499, 77, 0, 35, 0, 0, 1),
(1500, 77, 12, 3, 5, 0, 2),
(1501, 77, 15, 7, 0, 0, 2),
(1502, 77, 16, 7, 0, 0, 2),
(1503, 77, 17, 7, 0, 0, 2),
(1504, 77, 24, 7, 0, 0, 2),
(1505, 77, 25, 7, 0, 0, 2),
(1506, 77, 26, 57, 0, 0, 1),
(1507, 77, 27, 7, 0, 0, 2),
(1508, 77, 35, 7, 0, 0, 2),
(1509, 77, 36, 7, 0, 0, 2),
(1510, 77, 37, 7, 0, 0, 2),
(1511, 77, 45, 7, 0, 0, 2),
(1512, 77, 47, 57, 0, 0, 1),
(1513, 77, 47, 7, 3, 5, 2),
(1514, 78, 0, 58, 0, 0, 1),
(1515, 78, 0, 30, 0, 0, 1),
(1516, 78, 0, 35, 0, 0, 1),
(1517, 78, 11, 3, 0, 0, 1),
(1518, 78, 14, 7, 0, 0, 1),
(1519, 78, 16, 7, 5, 0, 1),
(1520, 78, 17, 7, 5, 0, 1),
(1521, 78, 18, 7, 0, 0, 1),
(1522, 78, 21, 3, 0, 0, 1),
(1523, 78, 22, 5, 4, 0, 1),
(1524, 78, 26, 7, 5, 0, 1),
(1525, 78, 27, 7, 5, 0, 1),
(1526, 78, 28, 7, 0, 0, 1),
(1527, 78, 34, 7, 0, 0, 1),
(1528, 78, 36, 12, 0, 0, 1),
(1529, 78, 37, 12, 0, 0, 1),
(1530, 78, 45, 7, 0, 0, 1),
(1531, 78, 46, 12, 0, 0, 1),
(1532, 78, 47, 12, 0, 0, 1),
(1533, 78, 48, 7, 5, 0, 1),
(1534, 79, 0, 58, 0, 0, 1),
(1535, 79, 0, 32, 0, 0, 1),
(1536, 79, 0, 35, 0, 0, 1),
(1537, 79, 0, 30, 0, 0, 1),
(1538, 79, 12, 76, 0, 0, 1),
(1539, 79, 12, 57, 0, 0, 1),
(1540, 79, 13, 13, 0, 0, 1),
(1541, 79, 14, 13, 0, 0, 1),
(1542, 79, 16, 13, 0, 0, 1),
(1543, 79, 17, 57, 0, 0, 1),
(1544, 79, 24, 57, 0, 0, 1),
(1545, 79, 25, 13, 0, 0, 1),
(1546, 79, 28, 7, 0, 0, 1),
(1547, 79, 37, 79, 0, 0, 1),
(1548, 79, 37, 7, 4, 0, 1),
(1549, 79, 47, 7, 0, 0, 1),
(1550, 80, 0, 58, 0, 0, 1),
(1551, 80, 0, 60, 0, 0, 1),
(1552, 80, 0, 31, 0, 0, 1),
(1553, 80, 0, 32, 0, 0, 1),
(1554, 80, 0, 30, 0, 0, 1),
(1555, 80, 0, 35, 0, 0, 1),
(1556, 80, 11, 6, 0, 0, 1),
(1557, 80, 15, 7, 0, 0, 1),
(1558, 80, 16, 7, 0, 0, 1),
(1559, 80, 17, 7, 5, 0, 1),
(1560, 80, 21, 6, 0, 0, 1),
(1561, 80, 21, 45, 0, 0, 1),
(1562, 80, 22, 6, 0, 0, 1),
(1563, 80, 24, 7, 0, 0, 1),
(1564, 80, 25, 7, 0, 0, 1),
(1565, 80, 31, 45, 0, 0, 1),
(1566, 80, 32, 45, 0, 0, 1),
(1567, 80, 34, 7, 0, 0, 1),
(1568, 80, 35, 7, 0, 0, 1),
(1569, 80, 36, 7, 2, 0, 1),
(1570, 80, 37, 7, 0, 0, 1),
(1571, 80, 41, 45, 0, 0, 1),
(1572, 80, 44, 7, 0, 0, 1),
(1573, 80, 45, 7, 0, 0, 1),
(1574, 80, 47, 7, 5, 0, 1),
(1575, 81, 11, 11, 0, 0, 1),
(1576, 81, 12, 11, 0, 0, 1),
(1577, 81, 21, 11, 0, 0, 1),
(1578, 81, 22, 11, 0, 0, 1),
(1579, 82, 11, 9, 0, 0, 1),
(1580, 82, 12, 9, 0, 0, 1),
(1581, 82, 21, 9, 0, 0, 1),
(1582, 82, 22, 9, 0, 0, 1),
(1583, 83, 0, 30, 0, 0, 1),
(1584, 83, 0, 58, 0, 0, 1),
(1585, 83, 0, 32, 0, 0, 1),
(1586, 83, 0, 61, 0, 0, 1),
(1587, 83, 16, 29, 0, 0, 1),
(1588, 83, 26, 29, 0, 0, 1),
(1589, 83, 36, 29, 0, 0, 1),
(1590, 83, 46, 29, 0, 0, 1),
(1591, 83, 74, 29, 0, 0, 1),
(1592, 83, 75, 29, 0, 0, 1),
(1593, 83, 84, 29, 0, 0, 1),
(1594, 83, 85, 29, 0, 0, 1),
(1595, 84, 0, 58, 0, 0, 1),
(1596, 84, 0, 32, 0, 0, 1),
(1597, 84, 0, 30, 0, 0, 1),
(1598, 84, 0, 33, 0, 0, 1),
(1599, 84, 11, 5, 0, 0, 1),
(1600, 84, 12, 3, 0, 0, 1),
(1601, 84, 16, 7, 0, 0, 1),
(1602, 84, 17, 7, 0, 0, 1),
(1603, 84, 21, 5, 0, 0, 1),
(1604, 84, 25, 7, 3, 0, 1),
(1605, 84, 26, 57, 0, 0, 1),
(1606, 84, 27, 7, 0, 0, 1),
(1607, 84, 37, 7, 0, 0, 1),
(1608, 84, 46, 57, 0, 0, 1),
(1609, 84, 46, 7, 5, 0, 1),
(1610, 84, 47, 7, 0, 0, 1),
(1611, 85, 0, 58, 0, 0, 1),
(1612, 85, 0, 30, 0, 0, 1),
(1613, 85, 0, 31, 0, 0, 1),
(1614, 85, 0, 70, 0, 0, 1),
(1615, 85, 0, 71, 0, 0, 1),
(1616, 85, 16, 7, 0, 0, 1),
(1617, 85, 26, 7, 0, 0, 1),
(1618, 85, 36, 7, 0, 0, 1),
(1619, 86, 0, 58, 0, 0, 1),
(1620, 86, 0, 32, 0, 0, 1),
(1621, 86, 0, 30, 0, 0, 1),
(1622, 86, 54, 29, 0, 0, 1),
(1623, 86, 55, 29, 0, 0, 1),
(1624, 86, 64, 29, 0, 0, 1),
(1625, 86, 65, 29, 0, 0, 1),
(1626, 86, 74, 29, 0, 0, 1),
(1627, 86, 75, 29, 0, 0, 1),
(1628, 86, 84, 29, 0, 0, 1),
(1629, 86, 85, 29, 0, 0, 1),
(1644, 87, 0, 55, 0, 0, 1),
(1645, 87, 0, 30, 0, 0, 1),
(1646, 87, 0, 32, 0, 0, 1),
(1647, 87, 53, 5, 0, 0, 1),
(1648, 87, 54, 7, 0, 0, 1),
(1649, 87, 55, 7, 0, 0, 1),
(1650, 87, 64, 7, 0, 0, 1),
(1651, 87, 65, 7, 0, 0, 1),
(1652, 87, 74, 7, 0, 0, 1),
(1653, 87, 74, 20, 0, 0, 1),
(1654, 87, 75, 7, 0, 0, 1),
(1655, 87, 84, 7, 0, 0, 1),
(1656, 87, 84, 20, 0, 0, 1),
(1657, 87, 85, 7, 0, 0, 1),
(1658, 88, 0, 30, 0, 0, 1),
(1659, 88, 0, 31, 0, 0, 1),
(1660, 88, 0, 34, 0, 0, 1),
(1661, 88, 0, 58, 0, 0, 1),
(1662, 88, 16, 7, 5, 0, 1),
(1663, 88, 17, 7, 0, 0, 1),
(1664, 88, 22, 7, 0, 0, 1),
(1665, 88, 26, 7, 3, 5, 1),
(1666, 88, 27, 7, 4, 0, 1),
(1667, 88, 36, 7, 5, 0, 1),
(1668, 88, 37, 7, 0, 0, 1),
(1669, 88, 46, 7, 0, 0, 1),
(1670, 88, 47, 7, 0, 0, 1),
(1671, 89, 0, 58, 0, 0, 1),
(1672, 89, 0, 34, 0, 0, 1),
(1673, 89, 0, 30, 0, 0, 1),
(1674, 89, 0, 32, 0, 0, 1),
(1675, 89, 15, 3, 7, 0, 1),
(1676, 89, 15, 79, 0, 0, 1),
(1677, 89, 15, 57, 0, 0, 1),
(1678, 89, 16, 7, 0, 0, 1),
(1679, 89, 17, 7, 0, 0, 1),
(1680, 89, 24, 7, 0, 0, 1),
(1681, 89, 25, 7, 0, 0, 1),
(1682, 89, 37, 7, 0, 0, 1),
(1683, 89, 38, 7, 0, 0, 1),
(1684, 89, 45, 16, 0, 0, 1),
(1685, 89, 45, 9, 0, 0, 1),
(1686, 89, 45, 57, 0, 0, 1),
(1687, 89, 45, 23, 0, 0, 1),
(1688, 89, 47, 7, 0, 0, 1),
(1689, 89, 48, 7, 0, 0, 1),
(1690, 90, 0, 58, 0, 0, 1),
(1691, 90, 0, 31, 0, 0, 1),
(1692, 90, 0, 33, 0, 0, 1),
(1693, 90, 0, 30, 0, 0, 1),
(1694, 90, 11, 5, 0, 0, 1),
(1695, 90, 12, 2, 5, 7, 1),
(1696, 90, 14, 29, 0, 0, 1),
(1697, 90, 15, 29, 0, 0, 1),
(1698, 90, 16, 7, 0, 0, 1),
(1699, 90, 17, 7, 0, 0, 1),
(1700, 90, 22, 5, 0, 0, 1),
(1701, 90, 24, 29, 0, 0, 1),
(1702, 90, 25, 29, 0, 0, 1),
(1703, 90, 26, 7, 0, 0, 1),
(1704, 90, 27, 7, 0, 0, 1),
(1705, 90, 34, 29, 0, 0, 1),
(1706, 90, 35, 29, 0, 0, 1),
(1707, 90, 36, 7, 0, 0, 1),
(1708, 90, 37, 7, 0, 0, 1),
(1709, 90, 38, 57, 0, 0, 1),
(1710, 90, 44, 29, 0, 0, 1),
(1711, 90, 45, 29, 0, 0, 1),
(1712, 90, 46, 7, 0, 0, 1),
(1713, 90, 47, 7, 0, 0, 1),
(1714, 90, 48, 57, 0, 0, 1),
(1715, 91, 0, 58, 0, 0, 1),
(1716, 91, 45, 9, 0, 0, 1),
(1717, 91, 46, 13, 0, 0, 1),
(1718, 91, 46, 9, 0, 0, 1),
(1719, 91, 47, 9, 0, 0, 1),
(1720, 92, 44, 7, 0, 0, 1),
(1721, 92, 35, 6, 0, 0, 1),
(1722, 92, 34, 7, 0, 0, 1),
(1723, 92, 34, 6, 0, 0, 1),
(1724, 92, 28, 7, 0, 0, 1),
(1725, 92, 26, 5, 0, 0, 1),
(1726, 92, 25, 90, 0, 0, 1),
(1727, 92, 24, 90, 0, 0, 1),
(1728, 92, 16, 6, 0, 0, 1),
(1729, 92, 16, 5, 0, 0, 1),
(1730, 92, 15, 90, 0, 0, 1),
(1731, 92, 14, 90, 0, 0, 1),
(1732, 92, 13, 5, 0, 0, 1),
(1733, 92, 12, 5, 0, 0, 1),
(1734, 92, 11, 3, 0, 0, 1),
(1735, 92, 0, 58, 0, 0, 1),
(1736, 92, 0, 61, 0, 0, 1),
(1737, 92, 0, 30, 0, 0, 1),
(1738, 92, 0, 32, 0, 0, 1),
(1739, 93, 47, 7, 0, 0, 1),
(1740, 93, 37, 7, 0, 0, 1),
(1741, 93, 36, 7, 0, 0, 1),
(1742, 93, 35, 7, 0, 0, 1),
(1743, 93, 34, 7, 0, 0, 1),
(1744, 93, 17, 7, 0, 0, 1),
(1745, 93, 16, 7, 0, 0, 1),
(1746, 93, 15, 7, 0, 0, 1),
(1747, 93, 14, 7, 0, 0, 1),
(1748, 93, 0, 30, 0, 0, 1),
(1749, 93, 0, 33, 0, 0, 1),
(1750, 93, 0, 31, 0, 0, 1),
(1751, 93, 0, 58, 0, 0, 1),
(1752, 93, 0, 57, 0, 0, 1),
(1753, 94, 47, 7, 0, 0, 1),
(1754, 94, 46, 7, 0, 0, 1),
(1755, 94, 45, 29, 0, 0, 1),
(1756, 94, 44, 7, 0, 0, 1),
(1757, 94, 37, 7, 0, 0, 1),
(1758, 94, 35, 29, 0, 0, 1),
(1759, 94, 34, 7, 0, 0, 1),
(1760, 94, 28, 12, 0, 0, 1),
(1761, 94, 27, 7, 0, 0, 1),
(1762, 94, 25, 7, 0, 0, 1),
(1763, 94, 24, 7, 0, 0, 1),
(1764, 94, 16, 7, 0, 0, 1),
(1765, 94, 15, 7, 0, 0, 1),
(1766, 94, 14, 7, 0, 0, 1),
(1767, 94, 11, 4, 3, 0, 1),
(1768, 94, 0, 31, 0, 0, 1),
(1769, 94, 0, 34, 0, 0, 1),
(1770, 94, 0, 58, 0, 0, 1),
(1771, 94, 0, 30, 0, 0, 1),
(1772, 94, 0, 57, 0, 0, 1),
(1773, 95, 82, 4, 0, 0, 1),
(1774, 96, 41, 2, 0, 0, 1),
(1775, 97, 83, 5, 0, 0, 1),
(1776, 98, 82, 4, 0, 0, 1),
(1777, 99, 52, 3, 0, 0, 1),
(1778, 100, 83, 6, 0, 0, 1),
(1779, 101, 75, 3, 0, 0, 1),
(1780, 102, 13, 2, 3, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedors`
--

CREATE TABLE `proveedors` (
  `id` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `email` varchar(120) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `dni` varchar(8) DEFAULT NULL,
  `telefono` varchar(60) DEFAULT NULL,
  `celular` varchar(60) DEFAULT NULL,
  `empresa` varchar(120) DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `ruc` varchar(11) DEFAULT NULL,
  `banco` varchar(60) DEFAULT NULL,
  `nrocuenta` varchar(60) DEFAULT NULL,
  `insumo_id` int(11) NOT NULL,
  `tipo_id` int(1) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `proveedors`
--

INSERT INTO `proveedors` (`id`, `nombres`, `email`, `direccion`, `dni`, `telefono`, `celular`, `empresa`, `ciudad`, `ruc`, `banco`, `nrocuenta`, `insumo_id`, `tipo_id`, `updated_at`, `created_at`) VALUES
(1, 'Adderlin Alonso Marquez', '', 'Urb. Huanchaquito Alto Mz. 1 Lt. 29', '', '(044)652123', '980777620', 'Vía Lab Laboratorio Dental', 'Trujillo - La Libertad', '', '', '', 0, 1, NULL, NULL),
(2, 'Percy Lucano Campos', 'artdent_89@hotmail.com', '', '', '', '', 'RTCerDent', 'Cajamarca', '', '', '', 3, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedors_detalles`
--

CREATE TABLE `proveedors_detalles` (
  `id` int(11) NOT NULL,
  `idProveedor` int(11) NOT NULL,
  `detalle` varchar(120) NOT NULL,
  `monto` decimal(5,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `rolid` int(11) NOT NULL,
  `nombre` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`rolid`, `nombre`, `descripcion`) VALUES
(1, 'Administrador', 'Administrador de la aplicación'),
(2, 'Invitado', 'Usuario sin privilegios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tratamientos`
--

CREATE TABLE `tratamientos` (
  `id` int(11) NOT NULL,
  `detalle` varchar(120) NOT NULL,
  `updated_at` date NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tratamientos`
--

INSERT INTO `tratamientos` (`id`, `detalle`, `updated_at`, `created_at`) VALUES
(2, 'Resina Simple Vestibular', '0000-00-00', '0000-00-00'),
(3, 'Resina Simple Mesial', '0000-00-00', '0000-00-00'),
(4, 'Resina Simple Distal', '0000-00-00', '0000-00-00'),
(5, 'Resina Simple Palatino', '0000-00-00', '0000-00-00'),
(6, 'Ionomero', '0000-00-00', '0000-00-00'),
(7, 'Resina Simple Oclusal', '0000-00-00', '0000-00-00'),
(8, 'Corona Fenestrada', '0000-00-00', '0000-00-00'),
(9, 'Corona Metal Porcelana', '0000-00-00', '0000-00-00'),
(10, 'Corona de Acero', '0000-00-00', '0000-00-00'),
(11, 'Corona Free Metal', '0000-00-00', '0000-00-00'),
(12, 'Exodoncia Simple', '0000-00-00', '0000-00-00'),
(13, 'Exodoncia Compleja', '0000-00-00', '0000-00-00'),
(14, 'Exodoncia 3ra Molar', '0000-00-00', '0000-00-00'),
(15, 'Endodoncia Incisivo', '0000-00-00', '0000-00-00'),
(16, 'Endodoncia de Premolar', '0000-00-00', '0000-00-00'),
(17, 'Endodoncia Molar', '0000-00-00', '0000-00-00'),
(18, 'Carillas Inyectada', '0000-00-00', '0000-00-00'),
(19, 'Carilla Estratificada', '0000-00-00', '0000-00-00'),
(20, 'Pulpotomia', '0000-00-00', '0000-00-00'),
(21, 'Pulpectomia', '0000-00-00', '0000-00-00'),
(22, 'Perno de Colado', '0000-00-00', '0000-00-00'),
(23, 'Perno de Fibra de Vidrio', '0000-00-00', '0000-00-00'),
(26, 'Incrustacion de Resina', '0000-00-00', '0000-00-00'),
(27, 'Incrustacion de Porcelana', '0000-00-00', '0000-00-00'),
(28, 'Incrustacion Metal', '0000-00-00', '0000-00-00'),
(29, 'Resina Compuesta', '0000-00-00', '0000-00-00'),
(30, 'Resina Compleja', '0000-00-00', '0000-00-00'),
(31, 'Sellantes por pieza dental', '0000-00-00', '0000-00-00'),
(32, 'Profilaxis', '0000-00-00', '0000-00-00'),
(33, 'Flúor gel', '0000-00-00', '0000-00-00'),
(34, 'Flúor Barniz', '0000-00-00', '0000-00-00'),
(35, 'Destartraje (Grado 1)', '0000-00-00', '0000-00-00'),
(36, 'Destartraje (Grado 2)', '0000-00-00', '0000-00-00'),
(37, 'Destartraje (Grado 3)', '0000-00-00', '0000-00-00'),
(38, 'RAR por pieza', '0000-00-00', '0000-00-00'),
(39, 'Colgajo por sextante', '0000-00-00', '0000-00-00'),
(40, 'Odontosección (1pieza)', '0000-00-00', '0000-00-00'),
(41, 'Osteotomía', '0000-00-00', '0000-00-00'),
(42, 'Osteoplastía', '0000-00-00', '0000-00-00'),
(43, 'Retratamiento Endodoncia Incisivo', '0000-00-00', '0000-00-00'),
(45, 'Retratamiento Endodoncia Molar', '0000-00-00', '0000-00-00'),
(49, 'Resina Estética Simple (1 superficie)', '0000-00-00', '0000-00-00'),
(50, 'Resina Estética Compuesta (2 superficies)', '0000-00-00', '0000-00-00'),
(51, 'Resina Estética Compleja (3 superficies)', '0000-00-00', '0000-00-00'),
(52, 'Análisis de Rehabilitación', '0000-00-00', '0000-00-00'),
(53, 'PPR, Base Metálica Unimaxilar Olimpic', '0000-00-00', '0000-00-00'),
(54, 'PPR, Base Metálica Unimaxilar Ortolux', '0000-00-00', '0000-00-00'),
(55, 'PPR, Base Metálica Unimaxilar Ivostar', '0000-00-00', '0000-00-00'),
(56, 'Prótesis Completa Olimpic', '0000-00-00', '0000-00-00'),
(57, 'Prótesis Completa Ortolux', '0000-00-00', '0000-00-00'),
(58, 'Prótesis Completa Ivostar', '0000-00-00', '0000-00-00'),
(59, 'Mantenedor de espacio', '0000-00-00', '0000-00-00'),
(60, 'Medicación Pastas Médicas', '0000-00-00', '0000-00-00'),
(61, 'Sedación consciente con medicamentos por/sedación', '0000-00-00', '0000-00-00'),
(62, 'Sedación consciente sin medicamentos', '0000-00-00', '0000-00-00'),
(63, 'Radiografía periapical adulto c/u', '0000-00-00', '0000-00-00'),
(64, 'Consulta', '0000-00-00', '0000-00-00'),
(65, 'Férula de Acetato', '0000-00-00', '0000-00-00'),
(66, 'Férula Nauromiorelajante', '0000-00-00', '0000-00-00'),
(67, 'Modelos de Estudio', '0000-00-00', '0000-00-00'),
(68, 'Macro abrasión por pieza', '0000-00-00', '0000-00-00'),
(69, 'Micro abrasión por pieza', '0000-00-00', '0000-00-00'),
(70, 'Blanqueamiento con férulas', '0000-00-00', '0000-00-00'),
(71, 'Blanqueamiento mixto', '0000-00-00', '0000-00-00'),
(72, 'Blanqueamiento láser', '0000-00-00', '0000-00-00'),
(73, 'Análisis de ortodoncia (Rx cefalométrica y panorámica)', '0000-00-00', '0000-00-00'),
(74, 'Brakets Cerímero Inicial', '0000-00-00', '0000-00-00'),
(75, 'Brakets Cerímeno Mensualidad', '0000-00-00', '0000-00-00'),
(76, 'Brakets Metálicos Inicial', '0000-00-00', '0000-00-00'),
(77, 'Brakets Metálicos Mensualidad', '0000-00-00', '0000-00-00'),
(78, 'Brakets Estéticos Porcelana Inicial', '0000-00-00', '0000-00-00'),
(79, 'Brakets Estéticos Porcelana Mensualidad', '0000-00-00', '0000-00-00'),
(80, 'Brakets Estéticos Zafiro Inicial', '0000-00-00', '0000-00-00'),
(81, 'Brakets Estéticos Zafiro Mensualidad', '0000-00-00', '0000-00-00'),
(82, 'Gingivoplastía por sextante', '0000-00-00', '0000-00-00'),
(83, 'Gingivectomía por sextante', '0000-00-00', '0000-00-00'),
(84, 'Radiografía periapical niño c/u', '0000-00-00', '0000-00-00'),
(85, 'Recubrimiento Pulpar Directo', '0000-00-00', '0000-00-00'),
(86, 'Recubrimiento Pulpar Indirecto', '0000-00-00', '0000-00-00'),
(87, 'Prótesis Completa Unimaxilar - Olimpic', '0000-00-00', '0000-00-00'),
(88, 'Prótesis Completa Unimaxilar - Ortolux', '0000-00-00', '0000-00-00'),
(89, 'Prótesis Completa Unimaxilar - Ivostar', '0000-00-00', '0000-00-00'),
(90, 'PPR, base metálica Unimaxilar - Ivostar', '0000-00-00', '0000-00-00'),
(91, 'PPR, base metálica Unimaxilar - Ortolux', '0000-00-00', '0000-00-00'),
(92, 'PPR, base metálica Unimaxilar - Olimpic', '0000-00-00', '0000-00-00'),
(93, 'Retratamiento Endodoncia Premolar', '0000-00-00', '0000-00-00'),
(94, 'Frenectomía', '0000-00-00', '0000-00-00'),
(95, 'Fistulografía con Radiografía Periapical', '0000-00-00', '0000-00-00'),
(96, 'Encerado de diagnóstico por pieza', '0000-00-00', '0000-00-00'),
(97, 'Reparación Simple de Prótesis', '0000-00-00', '0000-00-00'),
(98, 'Ajuste Oclusal c/piedra de Arkansas', '0000-00-00', '0000-00-00'),
(99, 'Cirugía de Mucocele', '0000-00-00', '0000-00-00'),
(100, 'Reposición de tejidos blandos (autoinjerto)', '0000-00-00', '0000-00-00'),
(101, 'Exodoncia de Deciduo', '0000-00-00', '0000-00-00'),
(102, 'Flúor Neutro (2 Aplicaciones para Blanqueamiento)', '0000-00-00', '0000-00-00'),
(103, 'Cementación por corona', '0000-00-00', '0000-00-00'),
(104, 'Prótesis Completa Combinada (Ivostar+Ortholux)', '0000-00-00', '0000-00-00'),
(107, 'Retiro de Brackets Arcada Superior + Pulido', '2017-09-13', '2017-09-13'),
(108, 'Retiro de Brackets Arcada Inferior + Pulido', '2017-09-13', '2017-09-13'),
(109, 'Impresión de maxilares', '2017-09-13', '2017-09-13'),
(110, 'Retenedor Dental', '2017-09-13', '2017-09-13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `rolid` int(11) NOT NULL DEFAULT '2',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `rolid`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(0, 1, 'Admin', 'admin@core.com', '$2y$10$5s.4JhmL6ZkwMi5KEWhqDOY0IKrcfd4i5SkbbD4zkeTJpvi8pBDQK', '2mK7VJG0kWQBIVtUzMjpOIntk3qDwCM7m4V2FUEI6wbBugiNTY1jUsIjTyaY', '2017-08-04 09:20:39', '2017-08-04 09:20:39'),
(1, 2, 'Arturo Quilcate Gonzales', 'dr.quilcate92@outlook.com', '$2y$10$A7ZE5ybQnZQIWBJDZ5PY5.0jyxONqWApUSfXBrw3PGGk1ifsZSSpW', NULL, '2017-09-13 02:37:40', '2017-09-13 02:37:40'),
(2, 2, 'Fresia Sandoval', 'fresiv.wu@hotmail.com', '$2y$10$WWlBvurFJ5aOAxct/DdMW.UBrjVi6H0gnZjBTPn.iYZ/6bY8mQbnq', 'A27cYFPN5pVT3CdTMn0vea8pcoa2APh1gihlFhNTsmDW8HLjod6iWfWbnfk3', '2017-09-12 05:37:59', '2017-09-12 05:37:59'),
(3, 2, 'Martín Suárez', 'ssuarezb13@outlook.com', '$2y$10$Idp4Dbisvk2U816JCQXDUeXMtSCst9s7fGRAKU01W/PW.N8Kh830W', 'FU6IJ36tIMIRQpa7z7eGeDeenbFQ9FgRkLzPjvsEWJ7gMZmi1yqWw2xmEDbk', '2017-11-08 04:23:37', '2017-11-08 04:23:37');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `agendas`
--
ALTER TABLE `agendas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `medicos`
--
ALTER TABLE `medicos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `precios`
--
ALTER TABLE `precios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `presupuestos_detalle`
--
ALTER TABLE `presupuestos_detalle`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proveedors`
--
ALTER TABLE `proveedors`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proveedors_detalles`
--
ALTER TABLE `proveedors_detalles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`rolid`);

--
-- Indices de la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `agendas`
--
ALTER TABLE `agendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `medicos`
--
ALTER TABLE `medicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT de la tabla `precios`
--
ALTER TABLE `precios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT de la tabla `presupuestos_detalle`
--
ALTER TABLE `presupuestos_detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1781;

--
-- AUTO_INCREMENT de la tabla `proveedors`
--
ALTER TABLE `proveedors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `proveedors_detalles`
--
ALTER TABLE `proveedors_detalles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `rolid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
