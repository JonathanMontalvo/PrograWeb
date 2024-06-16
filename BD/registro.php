<?php
require_once ('database.php');
require_once ('orm.php');
require_once ('usuarios.php');

$errores = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $correo = $_POST['correo'];
    $contrasenia = $_POST['contrasenia'];

    // Validaciones Mejoradas
    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+$/", $nombre)) {
        $errores['nombre'] = "El nombre solo puede contener letras y acentos.";
    }
    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+$/", $apellido_paterno)) {
        $errores['apellido_paterno'] = "El apellido paterno solo puede contener letras y acentos.";
    }
    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+$/", $apellido_materno)) {
        $errores['apellido_materno'] = "El apellido materno solo puede contener letras y acentos.";
    }
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores['correo'] = "El correo electrónico no es válido.";
    }
    if (!preg_match("/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d\W_]{8,}$/", $contrasenia)) {
        $errores['contrasenia'] = "La contraseña debe tener al menos 8 caracteres, una mayúscula y un número.";
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


    $db = new Database();
    $encontrado = $db->verificarDriver();
    if ($encontrado) {
        $cnn = $db->getConnection();
        $usuariosModelo = new Usuarios($cnn);
        $insertar = [];

        $insertar['apellido_paterno'] = $apellido_paterno;
        $insertar['apellido_materno'] = $apellido_materno;
        $insertar['nombre'] = $nombre;
        $insertar['fecha_nacimiento'] = $fecha_nacimiento;
        $insertar['correo'] = $correo;
        $insertar['contrasenia'] = sha1($contrasenia);
        $insertar['rol'] = "CLIENTE";

        if (empty($errores)) {
            if ($usuariosModelo->insert($insertar)) {
                echo "Datos insertados correctamente.";
            } else {
                echo "No se logró añadir.";
            }
        } else {
            foreach ($errores as $error) {
                echo $error . "<br>";
            }
        }
    }
}