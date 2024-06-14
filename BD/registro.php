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
    $contrasenia = $_POST['contrasenia'];

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
        try {
            $conn = $db->getConnection();

            // Hash de la contraseña (¡MUY IMPORTANTE!)
            $hashed_password = password_hash($contrasenia, PASSWORD_DEFAULT);

            // Prepared Statements (forma más segura)
            $sql = "INSERT INTO usuarios (nombre, apellido_paterno, apellido_materno, fecha_nacimiento, correo, contrasenia, rol) 
                        VALUES (:nombre, :apellido_paterno, :apellido_materno, :fecha_nacimiento, :correo, :contrasenia, :rol)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':nombre' => $nombre,
                ':apellido_paterno' => $apellido_paterno,
                ':apellido_materno' => $apellido_materno,
                ':fecha_nacimiento' => $fechaNacimiento->format('Y-m-d'), // Formatear fecha
                ':correo' => $correo,
                ':contrasenia' => $hashed_password,
                ':rol' => "CLIENTE"
            ]);

            // Enviar respuesta de éxito
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
            exit;
        } catch (PDOException $e) {
            // Manejo de errores mejorado
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'Error al registrar usuario.']); // Mensaje genérico para el usuario
            error_log('Error al registrar usuario: ' . $e->getMessage()); // Registrar el error real en el log del servidor
            exit;
        }
    } else {
        // Enviar errores de validación en formato JSON
        header('Content-Type: application/json');
        http_response_code(400); // Código de solicitud incorrecta
        echo json_encode($errores);
        exit;
    }
}
