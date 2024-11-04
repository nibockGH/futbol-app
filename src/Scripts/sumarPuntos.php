<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users_db";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir y limpiar los datos del formulario
    $equipo_id = $conn->real_escape_string($_POST['equipo_id']);
    $puntos = $conn->real_escape_string($_POST['puntos']);

    // Actualizar los puntos del equipo en la base de datos
    $sql = "UPDATE equipos SET puntos = puntos + $puntos WHERE id = $equipo_id";

    if ($conn->query($sql) === TRUE) {
        echo "Puntos actualizados exitosamente.";
        header("Location: ../Admin/equiposAdmin.php"); 
        exit();
    } else {
        echo "Error al actualizar los puntos: " . $conn->error;
    }
}

// Cerrar la conexión
$conn->close();

?>
