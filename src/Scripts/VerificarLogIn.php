<?php
session_start();

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verificar si los campos 'email' y 'password' están definidos en $_POST
    if (isset($_POST['email']) && isset($_POST['password'])) {
        
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

        // Obtener datos del formulario
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Buscar el usuario en la base de datos
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Obtener la información del usuario
            $row = $result->fetch_assoc();
            $hash = $row['password'];
            
            // Verificar la contraseña
            if (password_verify($password, $hash)) {
                // Guardar información del usuario en la sesión
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['role'] = $row['role']; // Aquí guardas el rol del usuario
                
                // Verificar si es administrador
                if ($row['role'] == 'admin') {
                    // Redirigir al panel de administración
                    header("Location: ../Admin/adminIndex.php");
                } else {
                    // Redirigir a la página de usuarios normales
                    header("Location: ../main.php");
                }
                exit();
            } else {
                echo "Contraseña incorrecta";
            }
        } else {
            echo "No se encontró una cuenta con ese correo electrónico";
        }

        // Cerrar la conexión
        $conn->close();

    } else {
        echo "Por favor, completa todos los campos.";
    }
} else {
    echo "Por favor, envía el formulario.";
}
?>
