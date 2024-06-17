<?php
include ('../layout/navUsuario.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Videojuegos</title>
    <!-- Incluyendo Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>

<body style="background-color: #c4c4c4;">
    <h1>-</h1>
    <div class="container">
        <h1 class="mt-5 text-center text-light font-weight-bold">Lista de Videojuegos</h1>
        <table id="tablaVideojuegos" class="table table-striped table-bordered table-secondary">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Clasificación</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Compañía</th>
                    <th>Fecha de Lanzamiento</th>
                    <th>Detalles</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <button id="mostrarTodo" class="btn btn-primary mt-3" style="display:none;">Mostrar Todo</button>
    </div>
    <script>
        $(document).ready(function () {
            var videojuegos = []; // Arreglo para almacenar los datos de los videojuegos

            // Realizar una solicitud AJAX para obtener los datos de videojuegos
            $.ajax({
                url: '../BD/Consultar_videojuegos.php', // Archivo PHP que envía los datos de videojuegos
                method: 'GET', // Usamos GET ya que no estamos enviando datos
                dataType: 'json',
                success: function (response) {
                    // Almacenar los datos de videojuegos en el arreglo
                    videojuegos = response;

                    // Iterar sobre los datos recibidos y agregar filas a la tabla
                    $.each(videojuegos, function (index, videojuego) {
                        var row = '<tr>';
                        row += '<td>' + videojuego.id + '</td>';
                        row += '<td>' + videojuego.nombre + '</td>';
                        row += '<td>' + videojuego.clasificacion + '</td>';
                        row += '<td>' + videojuego.descripcion + '</td>';
                        row += '<td>' + videojuego.precio + '</td>';
                        row += '<td>' + videojuego.compania + '</td>';
                        row += '<td>' + videojuego.fecha_lanzamiento + '</td>';
                        row += '<td><button class="btn btn-success btn-sm">ver</button></td>';
                        row += '</tr>';
                        $('#tablaVideojuegos tbody').append(row);
                    });
                },
                error: function (xhr, status, error) {
                    console.error('Error al obtener datos de videojuegos:', error);
                }
            });

            // Manejar el evento click de los botones de acción
            $('#tablaVideojuegos').on('click', '.btn-success', function () {
                var row = $(this).closest('tr');
                $('#tablaVideojuegos tbody tr').hide(); // Ocultar todas las filas
                row.show(); // Mostrar solo la fila seleccionada
                // Cambiar el nombre de la columna a "Cantidad"
                $('#tablaVideojuegos th:last-child').text('Cantidad');

                // Obtener el ID del videojuego desde la fila seleccionada
                var idVideojuego = row.find('td:first').text();
                // Encontrar el videojuego correspondiente en el arreglo
                var videojuego = videojuegos.find(v => parseInt(v.id) === parseInt(idVideojuego));
                row.find('td:last').text(videojuego.cantidad);
                $('#mostrarTodo').show(); // Mostrar el botón para mostrar todas las filas
            });

            // Manejar el evento click del botón "Mostrar Todo"
            $('#mostrarTodo').on('click', function () {
                // Cambiar el nombre de la columna de regreso a "Detalles"
                $('#tablaVideojuegos th:last-child').text('Detalles');
                $('#tablaVideojuegos tbody tr').show(); // Mostrar todas las filas
                // Agregar el botón "ver" a todas las filas nuevamente
                $('#tablaVideojuegos tbody tr').each(function () {
                    $(this).find('td:last').html('<button class="btn btn-success btn-sm btn-ver">ver</button>');
                });
                $(this).hide(); // Ocultar el botón "Mostrar Todo"
            });

        });
    </script>
</body>

</html>