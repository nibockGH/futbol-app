<?php
// Datos de conexión a la base de datos
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

$error = "";
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para eliminar el usuario
    $sql = "DELETE FROM equipos WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Usuario eliminado correctamente";
    } else {
        echo "Error al eliminar el equipo: " . $conn->error;
    }

    $conn->close();

    header("Location: ../usuariosAdmin.php");
}
?>