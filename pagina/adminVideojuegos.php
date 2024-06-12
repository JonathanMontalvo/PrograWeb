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

        <div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="miModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-agregar">
                    <div id="modalContentAgregar">
                        <!-- Aquí se cargará el contenido del modal -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de confirmación de eliminación -->
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar eliminación</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de que quieres eliminar este videojuego?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>

        <table id="tablaVideojuegos" class="table table-striped table-bordered">
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
        $(document).ready(function() {
            // Variable para guardar el ID del videojuego
            var videojuegoId;
            // Variable para guardar la fila del videojuego
            var videojuegoRow;

            var myDeleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'), {});
            var myModal = new bootstrap.Modal(document.getElementById('miModal'), {});

            // Realizar una solicitud AJAX para obtener los datos de videojuegos
            $.ajax({
                url: '../BD/Consultar_videojuegos.php', // Archivo PHP que envía los datos de videojuegos
                method: 'GET', // Usamos GET ya que no estamos enviando datos
                dataType: 'json',
                success: function(response) {
                    // Iterar sobre los datos recibidos y agregar filas a la tabla
                    $.each(response, function(index, videojuego) {
                        var row = '<tr>';
                        row += '<td>' + videojuego.id + '</td>';
                        row += '<td>' + videojuego.nombre + '</td>';
                        row += '<td>' + videojuego.clasificacion + '</td>';
                        row += '<td>' + videojuego.descripcion + '</td>';
                        row += '<td>' + videojuego.precio + '</td>';
                        row += '<td>' + videojuego.compania + '</td>';
                        row += '<td>' + videojuego.fecha_lanzamiento + '</td>';
                        row += '<td><button class="btn btn-success btn-sm">ver</button></td>';
                        row += '<td><button class="btn btn-info btn-sm btn-editar">editar</button></td>';
                        row += '<td><button class="btn btn-danger btn-sm">eliminar</button></td>';
                        row += '</tr>';
                        $('#tablaVideojuegos tbody').append(row);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener datos de videojuegos:', error);
                }
            });

            // Manejar el evento click de los botones de acción
            $('#tablaVideojuegos').on('click', '.btn-success', function() {
                var row = $(this).closest('tr');
                var id = row.find('td:nth-child(1)').text();
                var nombre = row.find('td:nth-child(2)').text();
                var clasificacion = row.find('td:nth-child(3)').text();
                // Aquí puedes agregar el código para manejar la acción del botón
                alert('Acción 1 - ID: ' + id + '\nNombre: ' + nombre + '\nClasificación: ' + clasificacion);
            });

            // Manejar el evento click de los botones de editar
            $('#tablaVideojuegos').on('click', '.btn-editar', function() {
                // Obtener el ID del videojuego
                var row = $(this).closest('tr');
                var id = row.find('td:nth-child(1)').text();

                // Redirigir a la página de edición con el ID del videojuego como parámetro de consulta en la URL
                window.location.href = 'editar_videojuego.php?id=' + id;
            });

            // Manejar el evento click de los botones de eliminar
            $('#tablaVideojuegos').on('click', '.btn-danger', function() {
                // Abrir el modal de confirmación de eliminación
                myDeleteModal.show();
                // Guardar el ID del videojuego
                var row = $(this).closest('tr');
                videojuegoRow = row;
                videojuegoId = row.find('td:nth-child(1)').text();
            });

            // Manejar el evento click del botón de eliminar en el modal
            $(document).on('click', '#confirmDeleteModal .btn-danger', function() {
                console.log('Hola' + videojuegoId);
                $.ajax({
                    type: "POST",
                    url: "../BD/eliminar_videojuego.php",
                    data: {
                        videojuegoId: videojuegoId
                    },
                    success: function(result) {
                        if (result == "Videojuego eliminado exitosamente") {
                            // Eliminar la fila de la tabla
                            videojuegoRow.remove();
                        }

                        // Cerrar el modal
                        myDeleteModal.hide();

                        // Mostrar el alert después de 0.2 segundos
                        setTimeout(function() {
                            alert(result);
                        }, 200);
                    }
                });
            });

            // Manejar el evento click de los botones de agregar
            $('[data-toggle="modal"]').click(function() {
                // Cuando se haga clic en el botón "Agregar"
                $.get('agregar_videojuego.php', function(response, status, xhr) {
                    if (status == "error") {
                        alert("Error: " + xhr.status + " " + xhr.statusText);
                    } else {
                        console.log("Contenido cargado exitosamente!");
                        $('#modalContentAgregar').html(response);
                        myModal.show();
                    }
                });
            });

        });
    </script>
</body>

</html>