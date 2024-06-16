<?php

require_once ('database.php');

$db = new Database();

// Validaciones del lado del servidor
$errores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $correo = $_POST['correo'];
    $contrasenia = sha1($_POST['contrasenia']);

    // Validaciones Mejoradas
    if (!preg_match("/^[a-zA-Z]+$/", $nombre)) {
        $errores['nombre'] = "El nombre solo puede contener letras.";
    }
    if (!preg_match("/^[a-zA-Z]+$/", $apellido_paterno)) {
        $errores['apellido_paterno'] = "El apellido paterno solo puede contener letras.";
    }
    if (!preg_match("/^[a-zA-Z]+$/", $apellido_materno)) {
        $errores['apellido_materno'] = "El apellido materno solo puede contener letras.";
    }
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores['correo'] = "El correo electrónico no es válido.";
    }
    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $contrasenia)) {
        $errores['contrasenia'] = "La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.";
    }

    // Validación de fecha de nacimiento
    $fechaNacimiento = DateTime::createFromFormat('Y-m-d', $fecha_nacimiento);
    $hoy = new DateTime();
    $minimo = $hoy->modify('-18 years');

    if (!$fechaNacimiento) {
        $errores['fecha_nacimiento'] = "La fecha de nacimiento no es válida. Usa el formato YYYY-MM-DD.";
    } elseif ($fechaNacimiento >= $minimo) {
        $errores['fecha_nacimiento'] = "Debes tener al menos 18 años.";
    }

    if (empty($errores)) {
        $conn = $db->getConnection();
        $usuariosModelo = new Usuarios($cnn);
        $insertar = [];

        $insertar['apellido_paterno'] = $apellido_paterno;
        $insertar['apellido_materno'] = $apellido_materno;
        $insertar['nombre'] = $nombre;
        $insertar['fecha_nacimiento'] = $fechaNacimiento;
        $insertar['correo'] = $correo;
        $insertar['contrasenia'] = $contrasenia;
        $insertar['rol'] = "CLIENTE";

        print_r($insertar);
    }
}
