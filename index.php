<?php
// Variable para mostrar un mensaje al usuario después del insert
$mensaje = "";

// --- CONEXIÓN A LA BASE DE DATOS ---
// Datos de conexión: host, usuario, contraseña y nombre de la base de datos
$host = 'localhost';          // Servidor de base de datos (localhost si está en tu PC)
$usuario = 'root';            // Usuario por defecto en XAMPP
$contrasena = '';             // Sin contraseña por defecto en XAMPP
$basededatos = 'prueba';      // Nombre de la base de datos que creamos

// Creamos un nuevo objeto mysqli para conectarnos
$conn = new mysqli($host, $usuario, $contrasena, $basededatos);

// Verificamos si la conexión fue exitosa
if ($conn->connect_error) {
    // Si hubo error, detenemos todo con un mensaje
    die("Conexión fallida: " . $conn->connect_error);
}

// --- PROCESAMIENTO DEL FORMULARIO ---
// Si el formulario fue enviado con método POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtenemos el valor enviado desde el campo "nombre"
    // Usamos real_escape_string para evitar errores o inyecciones
    $nombre = $conn->real_escape_string($_POST["nombre"]);

    // Preparamos la consulta SQL para insertar el nuevo nombre
    $sql = "INSERT INTO personas (nombre) VALUES ('$nombre')";

    // Ejecutamos la consulta
    if ($conn->query($sql) === TRUE) {
        $mensaje = "Nombre insertado correctamente.";
    } else {
        $mensaje = "Error: " . $conn->error;
    }
}

// --- OBTENER TODOS LOS NOMBRES GUARDADOS ---
// Ejecutamos una consulta para mostrar los nombres ya guardados
$resultado = $conn->query("SELECT id, nombre FROM personas ORDER BY id DESC");

// Cerramos la conexión (es buena práctica hacerlo)
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

    <!-- Formulario que envía datos a este mismo archivo -->
    <form method="post">
        <input type="text" name="nombre" required placeholder="Escribe un nombre">
        <button type="submit">Guardar</button>
    </form>

    <!-- Mostramos el mensaje si hay -->
    <p><?= $mensaje ?></p>

    <h2>Nombres guardados</h2>
    <!-- Tabla con los datos guardados -->
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
