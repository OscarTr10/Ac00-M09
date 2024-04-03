<?php
// Para verificar si se está ejecutando con CLI.
if (php_sapi_name() !== 'cli') {
    die("Este script debe ejecutarse desde la línea de comandos (CLI).\n");
}

// Ahora he puesto todos los datos de la base de datos para luego hacer la cone>
$serverName = "localhost";
$username = "Oscar";
$password = "Oscar_1234";
$dbname = "oscar";

// Para crear la conexión con MySQL.
$conn = mysqli_connect($serverName, $username, $password, $dbname);

// Para ver si la conexión ha salido exitosamente.
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

// Con esto podemos obtener todos los usuarios.
$sql = "SELECT * FROM oscar";
$result = mysqli_query($conn, $sql);

// Con este WHILE mostraremos los resultados.
while ($row = mysqli_fetch_assoc($result)) {
    echo "ID: " . $row['id'] . " Nombre: " . $row['nombre'] . "<br>";
}

// Cerrar la conexión a la base de datos.
mysqli_close($conn);

function menu(){ //Definimos la funcion menu para que nos muestre el menu
        echo "Selecciona una opcion:\n";
        echo "1- Agregar una tarea\n";
        echo "2- Eliminar una tarea\n";
        echo "3- Mostrar tareas existentes\n";
        echo "4- Marcar una tarea como completada\n";
}

menu();

//Ahora lo que vamos a hacer es que el usuario ingrese el número de la opción
echo "Ingrese el numero de opcion: ";
$opcion = readline();

function listTask($conn) {
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


switch ($opcion) {
    case '1':
        // La opcion 1 añade una tarea.
        echo "Nombre de la Tarea: ";
        $nombre = readline();
        echo "Descripción: ";
        $descripcion = readline();
    
        // Consulta SQL para insertar una nueva tarea en la base de datos.
        $sql = "INSERT INTO oscar (nombre, descripcion) VALUES ('$nombre', '$descripcion')";
        if (mysqli_query($conn, $sql)) {
            echo "Nueva tarea añadida con éxito.\n";
        } else {
            echo "Error al añadir la tarea: " . mysqli_error($conn) . "\n";
        }
        break;

    case '2':
        // La opcion 2 elimina la tarea.
        listTask($conn); //Con listTask muestra las tareas existentes.
        echo "Ingresa la ID de la tarea que deseas eliminar: ";
        $id = readline();
        // Aquí debes escribir el código para eliminar la tarea con la ID proporcionada.
        break;

    case '3':
        // La opcion 3 muestra las tareas existentes.
        listTask($conn);
        break;
    
    case '4':
        // La opcion 4 marca como completada una tarea.
        echo "Ingresa el ID de la tarea que quieres marcar como completada: ";
        $completada = readline();
    
        // Consultara la base de datos para marcas la tarea como completada
        $sql = "UPDATE oscar SET completada = 1 WHERE id = '$completada'";
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
