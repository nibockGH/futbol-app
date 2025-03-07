<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Equipo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        h1 {
            color: #343a40;
            text-align: center;
            margin-top: 40px;
            margin-bottom: 20px;
        }
        h3 {
            color: #495057;
            text-align: center;
            margin-bottom: 30px;
        }
        #alumnoForm {
            max-width: 500px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            margin-top: 20px; /* Espacio adicional para el botón de volver */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Gestión de Equipos</h1>
    
        <h3>Agregar Equipo</h3>
        <form id="EquipoForm" action="FuncionAddEquipo.php" method="POST">
    <div class="form-group">
        <label for="nombre">Nombre Del equipo</label>
        <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre del Usuario" required>
    </div>
    <div class="mb-4">
                    <label for="participantes" class="block text-gray-700 font-bold mb-2">Número de Participantes:</label>
                    <input type="number" id="cantidad_jugadores" name="cantidad_jugadores" max="22" class="form-control" required>
                </div>
    <div class="mb-6">
                    <label for="cancha" class="block text-gray-700 font-bold mb">Tipo de Cancha:</label>
                    <select id="tipo_cancha" name="tipo_cancha" class="form-control" required>
                        <option value=5>Fútbol 5</option>
                        <option value=7>Fútbol 7</option>
                        <option value=11>Fútbol 11</option>
                    </select>
                </div>
    <button type="submit" class="btn btn-primary">Agregar Equipo</button>
</form>


        <!-- Botón para volver al inicio -->
        <button onclick="location.href='../adminIndex.php'" class="btn btn-secondary">Volver al Inicio</button>
    </div>
    <script src="index.js"></script>
</body>
</html>
