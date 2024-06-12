<?php
class Database
{
    private $connection;

    public function __construct()
    {
    }

    public function verificarDriver()
    {
        $miArray = (PDO::getAvailableDrivers());
        $encontrado = false;
        foreach ($miArray as $n) {
            if ($n == 'mysql') {
                $encontrado = true;
                break;
            }
        }
        return $encontrado;
    }

    public function getConnection()
    {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
        $dns = "mysql:host=localhost;dbname=venta_videojuegos";
        $user = "root";
        $password = "";
        $this->connection = new PDO($dns, $user, $password, $options);
        $this->connection->exec("SET CHARACTER SET UTF8");
        return $this->connection;
    }
}

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

    // Validaciones básicas
    if (empty($nombre) || empty($correo) || empty($contrasenia)) {
        $errores[] = "Por favor, complete todos los campos.";
    }

    // Validación de correo electrónico
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El correo electrónico no es válido.";
    }

    // Otras validaciones que consideres necesarias

    // Si no hay errores, procesar el registro
    if (empty($errores)) {
        try {
            $conn = $db->getConnection();

            // Formatear la fecha de nacimiento a aaaa/mm/dd
            $fecha_nacimiento = date('Y/m/d', strtotime($fecha_nacimiento));

            // Escapar los datos (ahora usando la conexión PDO)
            $nombre = $conn->quote($nombre);
            $apellido_paterno = $conn->quote($apellido_paterno);
            $apellido_materno = $conn->quote($apellido_materno);
            $fecha_nacimiento = $conn->quote($fecha_nacimiento);
            $correo = $conn->quote($correo);
            $contrasenia = $conn->quote($contrasenia); 

            // Rol por defecto: CLIENTE
            $rol = $conn->quote("CLIENTE");

            // Insertar en la base de datos (usando prepared statements)
            $sql = "INSERT INTO usuarios (nombre, apellido_paterno, apellido_materno, fecha_nacimiento, correo, contrasenia, rol) 
                    VALUES (:nombre, :apellido_paterno, :apellido_materno, :fecha_nacimiento, :correo, :contrasenia, :rol)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido_paterno', $apellido_paterno);
            $stmt->bindParam(':apellido_materno', $apellido_materno);
            $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':contrasenia', $contrasenia);
            $stmt->bindParam(':rol', $rol);
            $stmt->execute();
            
            echo "Usuario registrado exitosamente.";
        } catch (PDOException $e) {
            echo "Error al registrar usuario: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro de Usuario</title>
</head>
<body>
    <h2>Registro de Usuario</h2>
    <?php if (!empty($errores)): ?>
        <ul>
            <?php foreach ($errores as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo isset($nombre) ? $nombre : ''; ?>" required><br><br>

        <label for="apellido_paterno">Apellido Paterno:</label>
        <input type="text" id="apellido_paterno" name="apellido_paterno" value="<?php echo isset($apellido_paterno) ? $apellido_paterno : ''; ?>" required><br><br>

        <label for="apellido_materno">Apellido Materno:</label>
        <input type="text" id="apellido_materno" name="apellido_materno" value="<?php echo isset($apellido_materno) ? $apellido_materno : ''; ?>" required><br><br>

        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo isset($fecha_nacimiento) ? $fecha_nacimiento : ''; ?>" required><br><br>

        <label for="correo">Correo Electrónico:</label>
        <input type="email" id="correo" name="correo" value="<?php echo isset($correo) ? $correo : ''; ?>" required><br><br>

        <label for="contrasenia">Contraseña:</label>
        <input type="password" id="contrasenia" name="contrasenia" required><br><br>

        <input type="submit" value="Registrar">
    </form>
</body>
</html>


