<?php
    include('../layout/Nav.php');
    session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X.UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresate</title>
    <link rel="stylesheet" href="../CSS/Estilos.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>

<body>
    <form action="../BD/login.php" id="myForm" class="form" method="post">
        <h2 class="form_title">Inicia Sesión</h2>
        <p class="form_paragraph">¿No eres cliente? <a href="*" class="form_link"  style="color: #076bad;">Entra aquí</a></p>

        <?php if (!empty($message)) : ?>
            <p style="color: #9e2020"><?php echo $message; ?></p>
        <?php endif; ?>

        <div class="form_container">
            <div class="form_group">
                <input type="email" name="Correo" id="Correo" class="form_input" placeholder=" " required>
                <label for="Correo" class="form_label">Correo: </label>
                <span class="form_line"></span>
            </div>
            <div class="form_group">
                <input type="password" name="pws" id="pws" class="form_input" placeholder=" " required>
                <label for="pws" class="form_label">Contraseña: </label>
                <span class="form_line"></span>
            </div>
            <input type="submit" name="Entrar" class="form_submit" value="Entrar">
        </div> <!-- Cierre de la primera sección form_container -->
    </form>
    <?php include('../layout/footer.php'); ?> 
</body>

</html>
