<?php
$mensaje = "";

// Conexión
$host = 'localhost';
$usuario = 'root';
$contrasena = '';
$basededatos = 'prueba';
$conn = new mysqli($host, $usuario, $contrasena, $basededatos);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $conn->real_escape_string($_POST["nombre"]);
    $sql = "INSERT INTO personas (nombre) VALUES ('$nombre')";
    if ($conn->query($sql) === TRUE) {
        $mensaje = "Nombre insertado correctamente.";
    } else {
        $mensaje = "Error: " . $conn->error;
    }
}

// Obtener todos los registros
$resultado = $conn->query("SELECT id, nombre FROM personas ORDER BY id DESC");

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Formulario PHP + MySQL</title>
</head>
<body>
    <h1>Ingresar nombre</h1>
    <form method="post">
        <input type="text" name="nombre" required>
        <button type="submit">Guardar</button>
    </form>
    <p><?= $mensaje ?></p>

    <h2>Nombres guardados</h2>
    <table border="1" cellpadding="5">
        <tr><th>ID</th><th>Nombre</th></tr>
        <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= $fila['id'] ?></td>
                <td><?= $fila['nombre'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
