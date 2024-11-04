<?php 
session_start();

// Verifica si el usuario está logueado y es admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../Account/register.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminDashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: white; /* color zinc-300 de Tailwind */
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        header {
            background-color: #000000; /* color negro */
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 10; /* Asegura que el header esté encima del contenido */
            height: 56px; /* Ajustar la altura del header */
        }

        .main-content {
            display: flex;
            flex-grow: 1;
            margin-top: 56px; /* Ajustar el contenido principal para que no se superponga al header */
        }

        aside {
            background-color: #2d3748; /* Fondo oscuro para el sidebar */
            width: 250px; /* Ancho del sidebar */
            padding: 20px;
            box-sizing: border-box;
            height: 100vh; /* El sidebar debe ocupar toda la altura */
            position: fixed; /* Sidebar fijo a la izquierda */
            top: 56px; /* Colocar debajo del header */
            left: 0;
            overflow-y: auto; /* Si el contenido es largo, añade scroll */
        }

        main {
            margin-left: 250px; /* Espacio para el sidebar */
            padding: 20px;
            flex-grow: 1;
            box-sizing: border-box;
        }
    </style>
</head>
<header class="bg-black text-primary-foreground px-4 lg:px-6 h-14 flex items-center">
    <a class="flex items-center justify-center" href="../main.php">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white size-6">
            <path d="m8 3 4 8 5-5 5 15H2L8 3z"></path>
        </svg>
        <span class="sr-only">Encontrar Partido</span>
    </a>
    <nav class="ml-auto pr-10 mr-10 flex gap-4 sm:gap-6">
        <div class="space-x-3.5">
            <a href="../main.php" class="text-sm text-white font-medium hover:underline underline-offset-4">Inicio</a>
            <a href="../Equipos/BuscarRival.php" class="text-sm text-white font-medium hover:underline underline-offset-4">Partidos</a>
            <a href="../Equipos/CreacionEquipos.php" class="text-sm text-white font-medium hover:underline underline-offset-4">Equipos</a>
        </div>
        <!-- Dropdown "Mi cuenta" -->
        <div class="dropdown">
            <a href="../Account/micuenta.php" class="text-sm text-white font-medium hover:underline underline-offset-4 dropbtn">Mi cuenta</a>
            <div class="dropdown-content">
                <a href="../Account/micuenta.php">Configuración</a>
                <a href="../Scripts/CerrarSesion.php">Cerrar sesión</a>
            </div>
        </div>
    </nav>
</header>
<body>
    <div class="main-content">
        <!-- Sidebar -->
        <aside class="bg-gray-800 text-white flex flex-col">
            <h2 class="text-lg font-bold mb-4">Panel de Administración</h2>
            <ul class="space-y-4">
                <li>
                    <a href="usuariosAdmin.php" class="block p-2 bg-gray-700 rounded hover:bg-gray-600">Usuarios</a>
                </li>
                <li>
                    <a href="partidos.php" class="block p-2 bg-gray-700 rounded hover:bg-gray-600">Partidos</a>
                </li>
                <li>
                    <a href="equiposAdmin.php" class="block p-2 bg-gray-700 rounded hover:bg-gray-600">Equipos</a>
                </li>
            </ul>
        </aside>

        <!-- Contenido principal -->
        <main>
            <h1 class="text-2xl font-bold mb-6">Bienvenido al panel de administración</h1>
            <!-- Aquí puedes añadir más contenido según sea necesario -->
            <p>Contenido de la página de administración...</p>
        </main>
    </div>
</body>
</html>
