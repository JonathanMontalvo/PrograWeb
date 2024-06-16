
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/nav_Admin.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/i18n/datepicker-es.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">


</head>
<body>
<nav>
        <input type="checkbox" id="toggle">
        <ul class="list">
            <li><a style="color: white;">Hola, <?php echo isset($_SESSION["usr"]) ? $_SESSION["usr"] : 'Invitado'; ?></a></li>   
        </ul>
        <label for="toggle" class="icon-bars">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </label>
    </nav>
</body>


</html>