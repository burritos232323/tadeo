<?php
$serverName = "localhost";
$username = "tadeo";
$password = "tadeo777";
$database = "tadeo";

$conexion = new mysqli($serverName, $username, $password, $database);

// Manejo de errores de conexión
if ($conexion->connect_error) {
    die("Ha fallado la conexión: " . $conexion->connect_error);
}

echo "Conectado correctamente <br>";

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = isset($_POST['correo']) ? $_POST['correo'] : '';
    $contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : '';

    // Validar y procesar los datos del formulario
    if (!empty($correo) && !empty($contrasena)) {
        // Sanitizar datos
        $correo = $conexion->real_escape_string($correo);
        $contrasena = $conexion->real_escape_string($contrasena);

        // Almacenar los datos en la tabla dots
        $registro = "INSERT INTO dots (nombre, r1, edoreg) VALUES ('$correo', '$contrasena', '1')";
        $resultados = $conexion->query($registro);

        if ($resultados) {
            echo "Se agregó correctamente el registro...<br><br>";
        } else {
            echo "Error al agregar el registro: " . $conexion->error . "<br><br>";
        }
    } else {
        echo "Por favor, completa todos los campos del formulario.<br><br>";
    }
}

echo "<h2>LISTA DE REGISTROS ADICIONADOS EN LA BASE DE DATOS Y EN LA TABLA DOTS:</h2><br><br>";

// Consulta para obtener todos los registros
$consulta = "SELECT * FROM dots";
$resultados = $conexion->query($consulta);

if ($resultados->num_rows > 0) {
    // Salida de la consulta mediante el ciclo WHILE
    ?>
    <table class="default" border=1>
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>RES R1</th>
            <th>ESTADO</th>
        </tr>

        <?php
        while ($registro = $resultados->fetch_assoc()) {
            echo "<tr><td>" . $registro["id"] . "</td><td>" . $registro["nombre"] . "</td><td>" . $registro["r1"] . "</td><td>" . $registro["edoreg"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        // Imprimimos si no hay ningún resultado.
        echo "0 resultados";
    }

// Cerrar la conexión
$conexion->close();
?>
