<?php
session_start();
require_once "conexion.php";

// Verificación básica de sesión
if (!isset($_SESSION["usuario_rut"]) || $_SESSION["usuario_tipo"] !== "autor") {
    header("Location: login.php");
    exit();
}

$rut_autor = $_SESSION["usuario_rut"];
$error = $mensaje = "";

// Obtener datos del autor (sin consulta preparada)
$result = $conexion->query("SELECT * FROM autores WHERE rut_autor = '$rut_autor'");
$autor = $result->fetch_assoc();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $usuario = $_POST["usuario"];
    $nueva_contrasena = $_POST["nueva_contrasena"] ?? '';
    
    if (empty($nombre) || empty($correo) || empty($usuario)) {
        $error = "Nombre, correo y usuario son campos obligatorios";
    } else {
        $query = "UPDATE autores SET 
                 nombre_autor = '$nombre', 
                 correo_autor = '$correo', 
                 usuario_autor = '$usuario'";
        
        if (!empty($nueva_contrasena)) {
            $contrasena_hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
            $query .= ", contraseña_autor = '$contrasena_hash'";
        }
        
        $query .= " WHERE rut_autor = '$rut_autor'";
        
        if ($conexion->query($query)) {
            $mensaje = "Perfil actualizado correctamente";
            $_SESSION["usuario_nombre"] = $nombre;
            $autor['nombre_autor'] = $nombre;
            $autor['correo_autor'] = $correo;
            $autor['usuario_autor'] = $usuario;
        } else {
            $error = "Error al actualizar el perfil";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="../Public/CSS/editarautor.css">
</head>
<body>
    <div class="editar-container">
        <h1>Editar Perfil</h1>
        
        <?php if ($error): ?>
            <div style="color: red;"><?= $error ?></div>
        <?php endif; ?>
        
        <?php if ($mensaje): ?>
            <div style="color: green;"><?= $mensaje ?></div>
        <?php endif; ?>

        <form method="POST">
            <div>
                <label>RUT:</label>
                <input type="text" value="<?= $autor['rut_autor'] ?>" readonly>
            </div>
            
            <div>
                <label>Nombre:</label>
                <input type="text" name="nombre" value="<?= $autor['nombre_autor'] ?>" required>
            </div>
            
            <div>
                <label>Correo:</label>
                <input type="email" name="correo" value="<?= $autor['correo_autor'] ?>" required>
            </div>
            
            <div>
                <label>Rol:</label>
                <input type="text" value="<?= $autor['rol_autor'] ?>" readonly>
            </div>
            
            <div>
                <label>Usuario:</label>
                <input type="text" name="usuario" value="<?= $autor['usuario_autor'] ?>" required>
            </div>
            
            <div>
                <label>Nueva contraseña (opcional):</label>
                <input type="password" name="nueva_contrasena">
            </div>
            
            <button type="submit">Guardar Cambios</button>
            <a href="home_autor.php">Volver</a>
        </form>

        <div>
            <h3>Eliminar mi cuenta</h3>
            <form action="eliminar_cuenta.php" method="POST">
                <button type="submit">Eliminar Cuenta</button>
            </form>
        </div>
    </div>
</body>
</html>