<?php include ('../layout/Nav.php'); ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diseño Web con Jumbotron</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../CSS/style.css">
</head>

<body>

    <div class="container-fluid">
        <!-- Bootstrap Jumbotron -->
        <div class="jumbotron bg-transparent text-white">
            <h1 class="tii">BIENVENIDO <i class="fas fa-robot"
                    style="font-size: 60px; position: relative; top: -13px;"></i></h1>
            <h2>¡Lo último en entretenimiento!</h2>
            <a href="Login_Usuarios.php">
                <button type="button" class="btn btn-primary btn-lg">
                    Compra ahora!!
                    <img class="emp" src="../IMG/EMP.png" alt="">
                    <img class="fondo-emp" src="../IMG/pattern..png" alt="">
                </button>
            </a>
        </div>
    </div>
    <!-- Footer -->
    <?php include ('../layout/footer.php'); ?>
</body>

</html>