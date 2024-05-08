<?php
// Para verificar si se está ejecutando con CLI.
if (php_sapi_name() !== 'cli') {
    die("Este script debe ejecutarse desde la línea de comandos (CLI).\n");
}

// Ponemos la función getopt
$options = getopt('a:d:h', ['add:', 'delete:', 'help']);
//Sus funciones
function showHelp() {
    echo "Uso: php script.php [OPCIÓN]\n";
    echo "Opciones:\n";
    echo "  -a, --add          Agregar una tarea\n";
    echo "  -d, --delete       Eliminar una tarea\n";
    echo "  -h, --help         Mostrar esta ayuda\n";
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

// Procesar las opciones
if (isset($options['a']) || isset($options['add'])) {
    // La opción -a o --add añade una tarea.
    $nombre = mysqli_real_escape_string($conn, $options['a'] ?? $options['add']);
    echo "Descripción: ";
    $descripcion = mysqli_real_escape_string($conn, readline());

    // Consulta SQL para insertar una nueva tarea en la base de datos.
    $sql = "INSERT INTO oscar (nombre, descripcion) VALUES ('$nombre', '$descripcion')";
    if (mysqli_query($conn, $sql)) {
        echo "Nueva tarea añadida con éxito.\n";
    } else {
        echo "Error al añadir la tarea: " . mysqli_error($conn) . "\n";
    }
} elseif (isset($options['d']) || isset($options['delete'])) {
    // La opción -d o --delete elimina una tarea.
    $id = mysqli_real_escape_string($conn, $options['d'] ?? $options['delete']);
    // Consulta SQL para eliminar la tarea con la ID proporcionada
    $sql = "DELETE FROM oscar WHERE id = '$id'";
    if (mysqli_query($conn, $sql)) {
        echo "Tarea eliminada con éxito.\n";
    } else {
        echo "Error al eliminar la tarea: " . mysqli_error($conn) . "\n";
    }
} elseif (isset($options['h']) || isset($options['help'])) {
    // Mostrar la ayuda si se especifica la opción -h o --help
    showHelp();
} else {
    echo "Opción no válida. Usa -h o --help para ver la ayuda.\n";
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>
