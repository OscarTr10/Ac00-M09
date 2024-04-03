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

switch ($opcion) {
    case '1':
        // La opcion 1 añade una tarea.
        echo "Nombre de la Tarea: ";
        $nombre = readline();
        echo"Descripción: ";
        $descripcion = readline();
        break;
    case '2':
        // La opcion 2  elimina la tarea.
        echo "Ingresa la ID de la tarea que desea eliminar: ";
        $id = readline();
        break;
    case '3':
        // El completeTask mostra las tareas existentes.
        listTask();
        break;
    case '4':
        // El deleteTask marca como completada una tarea.
        echo "Ingresa el ID de la tarea que quieras marcar como completada: ";
        $completada = readline();
        break;
    default:
        echo "Opcion no valida. Por favor, seleccione una opcion valida.\n";
        break;
}
