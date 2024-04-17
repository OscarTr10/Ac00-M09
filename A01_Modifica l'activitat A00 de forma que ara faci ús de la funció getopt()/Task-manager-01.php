<?php
// Para verificar si se está ejecutando con CLI.
if (php_sapi_name() !== 'cli') {
    die("Este script debe ejecutarse desde la línea de comandos (CLI).\n");
}

// Datos de conexión a la base de datos
$serverName = "localhost";
$username = "Oscar";
$password = "Oscar_1234";
$dbname = "oscar";

// Crear la conexión con MySQL.
$conn = mysqli_connect($serverName, $username, $password, $dbname);

// Verificar la conexión
if (mysqli_connect_errno()) {
    die("Error de conexión: " . mysqli_connect_error());
}
echo "Conexión exitosa\n";

// Función para mostrar el menú
function menu() {
    echo "Selecciona una opción:\n";
    echo "1- Agregar una tarea\n";
    echo "2- Eliminar una tarea\n";
    echo "3- Mostrar tareas existentes\n";
    echo "4- Marcar una tarea como completada\n";
}

// Función para listar las tareas existentes
function listTasks($conn) {
    $sql = "SELECT * FROM oscar";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "Tareas existentes:\n";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "ID: " . $row['id'] . " Nombre: " . $row['nombre'] . " Descripción: " . $row['descripcion'] . "\n";
        }
    } else {
        echo "No hay tareas existentes.\n";
    }
}

menu(); // Mostrar el menú

// Solicitar la opción al usuario
echo "Ingrese el número de opción: ";
$opcion = readline();

switch ($opcion) {
    case '1':
        // La opción 1 añade una tarea.
        echo "Nombre de la Tarea: ";
        $nombre = mysqli_real_escape_string($conn, readline());
        echo "Descripción: ";
        $descripcion = mysqli_real_escape_string($conn, readline());

        // Consulta SQL para insertar una nueva tarea en la base de datos.
        $sql = "INSERT INTO oscar (nombre, descripcion) VALUES ('$nombre', '$descripcion')";
        if (mysqli_query($conn, $sql)) {
            echo "Nueva tarea añadida con éxito.\n";
        } else {
            echo "Error al añadir la tarea: " . mysqli_error($conn) . "\n";
        }
        break;

    case '2':
        // La opción 2 elimina una tarea.
        listTasks($conn); // Mostrar las tareas existentes
        echo "Ingresa la ID de la tarea que deseas eliminar: ";
        $id = mysqli_real_escape_string($conn, readline());
        // Consulta SQL para eliminar la tarea con la ID proporcionada
        $sql = "DELETE FROM oscar WHERE id = '$id'";
        if (mysqli_query($conn, $sql)) {
            echo "Tarea eliminada con éxito.\n";
        } else {
            echo "Error al eliminar la tarea: " . mysqli_error($conn) . "\n";
        }
        break;

    case '3':
        // La opción 3 muestra las tareas existentes.
        listTasks($conn);
        break;

    case '4':
        // La opción 4 marca como completada una tarea.
        listTasks($conn); // Mostrar las tareas existentes
        echo "Ingresa el ID de la tarea que quieres marcar como completada: ";
        $id = mysqli_real_escape_string($conn, readline());
        // Consulta SQL para marcar la tarea como completada
        $sql = "UPDATE oscar SET completada = 1 WHERE id = '$id'";
        if (mysqli_query($conn, $sql)) {
            echo "Tarea marcada como completada con éxito.\n";
        } else {
            echo "Error al marcar la tarea como completada: " . mysqli_error($conn) . "\n";
        }
        break;

    default:
        echo "Opción no válida. Por favor, selecciona una opción válida.\n";
        break;
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>
