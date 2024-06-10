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
    <!-- Ajax -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <h1 class="mt-5 text-center">Lista de Videojuegos</h1>

        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#miModal">
            <i class="fas fa-plus"></i> Agregar
        </button>
        <div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="miModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content"></div>
            </div>
        </div>
        <table id="tablaVideojuegos" class="table table-striped table-bordered ">
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
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <!-- Incluyendo jQuery y Bootstrap JS -->
    <!-- Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            // Realizar una solicitud AJAX para obtener los datos de videojuegos
            $.ajax({
                url: '../BD/Consultar_videojuegos.php', // Archivo PHP que envía los datos de videojuegos
                method: 'GET', // Usamos GET ya que no estamos enviando datos
                dataType: 'json',
                success: function (response) {
                    // Iterar sobre los datos recibidos y agregar filas a la tabla
                    $.each(response, function (index, videojuego) {
                        var row = '<tr>';
                        row += '<td>' + videojuego.id + '</td>';
                        row += '<td>' + videojuego.nombre + '</td>';
                        row += '<td>' + videojuego.clasificacion + '</td>';
                        row += '<td>' + videojuego.descripcion + '</td>';
                        row += '<td>' + videojuego.precio + '</td>';
                        row += '<td>' + videojuego.compania + '</td>';
                        row += '<td>' + videojuego.fecha_lanzamiento + '</td>';
                        row += '<td><button class="btn btn-success btn-sm">ver</button></td>';
                        row += '<td><button class="btn btn-info btn-sm">editar</button></td>';
                        row += '<td><button class="btn btn-danger btn-sm">elimiar</button></td>';
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
                var id = row.find('td:nth-child(1)').text();
                var nombre = row.find('td:nth-child(2)').text();
                var clasificacion = row.find('td:nth-child(3)').text();
                // Aquí puedes agregar el código para manejar la acción del botón
                alert('Acción 1 - ID: ' + id + '\nNombre: ' + nombre + '\nClasificacion: ' + clasificacion);
            });
            // Manejar el evento click de los botones de editar
            $('#tablaVideojuegos').on('click', '.btn-info', function () {

            });

            // Manejar el evento click de los botones  de eliminar
            $('#tablaVideojuegos').on('click', '.btn-danger', function () {

            });

            // Manejar el evento click de los botones de agregar
            $('[data-toggle="modal"]').click(function () {
                // Cuando se haga clic en el botón "Agregar"
                $('#miModal .modal-content').load('agregar_videojuego.php', function (response, status, xhr) {
                    if (status == "error") {
                        alert("Error: " + xhr.status + " " + xhr.statusText);
                    } else {
                        console.log("Contenido cargado exitosamente!");
                        // Abrir el modal manualmente
                        $('#miModal').modal('show');
                    }
                });
            });


        });
    </script>
</body>

</html>