<?php
session_start();
require_once "conexion.php";

// Verificación básica de sesión
if (!isset($_SESSION["usuario_rut"]) || $_SESSION["usuario_tipo"] !== "revisor") {
    header("Location: login.php");
    exit();
}

$rut_revisor = $_SESSION["usuario_rut"];
$error = $mensaje = "";

// Obtener datos del revisor (sin consulta preparada)
$result = $conexion->query("SELECT * FROM revisores WHERE rut_revisor = '$rut_revisor'");
$revisor = $result->fetch_assoc();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $usuario = $_POST["usuario"];
    $nueva_contrasena = $_POST["nueva_contrasena"] ?? '';
    
    if (empty($nombre) || empty($correo) || empty($usuario)) {
        $error = "Nombre, correo y usuario son campos obligatorios";
    } else {
        $query = "UPDATE revisores SET 
                 nombre_revisor = '$nombre', 
                 correo_revisor = '$correo', 
                 usuario_revisor = '$usuario'";
        
        if (!empty($nueva_contrasena)) {
            $contrasena_hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
            $query .= ", contraseña_revisor = '$contrasena_hash'";
        }
        
        $query .= " WHERE rut_revisor = '$rut_revisor'";
        
        if ($conexion->query($query)) {
            $mensaje = "Perfil actualizado correctamente";
            $_SESSION["usuario_nombre"] = $nombre;
            $revisor['nombre_revisor'] = $nombre;
            $revisor['correo_revisor'] = $correo;
            $revisor['usuario_revisor'] = $usuario;
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
    <link rel="stylesheet" href="../Public/CSS/editarrevisor.css">
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
                <input type="text" value="<?= $revisor['rut_revisor'] ?>" readonly>
            </div>
            
            <div>
                <label>Nombre:</label>
                <input type="text" name="nombre" value="<?= $revisor['nombre_revisor'] ?>" required>
            </div>
            
            <div>
                <label>Correo:</label>
                <input type="email" name="correo" value="<?= $revisor['correo_revisor'] ?>" required>
            </div>
            
            <div>
                <label>Rol:</label>
                <input type="text" value="<?= $revisor['rol_revisor'] ?>" readonly>
            </div>
            
            <div>
                <label>Usuario:</label>
                <input type="text" name="usuario" value="<?= $revisor['usuario_revisor'] ?>" required>
            </div>
            
            <div>
                <label>Nueva contraseña (opcional):</label>
                <input type="password" name="nueva_contrasena">
            </div>
            
            <button type="submit">Guardar Cambios</button>
            <a href="home_revisor.php">Volver</a>
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