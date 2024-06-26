<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link rel="stylesheet" href="../CSS/navAdmin.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/i18n/datepicker-es.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>

<body>
    <nav>
        <div class="nav-item">
            <span class="ti">
                <i class="fas fa-gamepad" style="font-size: 40px;"></i>
                Bienvenido Admininstrador
            </span>
            <!-- Bootstrap dropdown for user name and logout option -->
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="../IMG/6941697.png" alt="Avatar del usuario">
                    <?php echo $_SESSION["usr"]; ?>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="../BD/logout.php">Cerrar sesión</a>
                </div>
            </div>
        </div>
    </nav>
</body>

</html>