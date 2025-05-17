<?php
session_start();
if (!isset($_SESSION["usuario_rut"]) || $_SESSION["usuario_tipo"] !== "admin") {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Administrador</title>
    <link rel="stylesheet" href="../Public/CSS/admin.css">
    <script src="https://kit.fontawesome.com/23ed4a8228.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="pagina-autor">
    <a href="logout.php" class="btn-cerrar-sesion">Cerrar sesión</a>
    
    <div class="ver-revisores">
        <div class="tabla-revisores">
            <div class="tabla-articulos">
                <h3>Bienvenido admin</h3>
                <h3>Información revisores</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Rut</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Rol</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Contraseña</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "conexion.php";
                        $sql = $conexion->query("SELECT * FROM revisores");
                        while($datos = $sql->fetch_object()) { 
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($datos->rut_revisor) ?></td>
                            <td><?= htmlspecialchars($datos->nombre_revisor) ?></td>
                            <td><?= htmlspecialchars($datos->correo_revisor) ?></td>
                            <td><?= htmlspecialchars($datos->rol_revisor) ?></td>
                            <td><?= htmlspecialchars($datos->usuario_revisor) ?></td>
                            <td><?= htmlspecialchars($datos->contraseña_revisor) ?></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary me-2">
                                    <i class="fas fa-pen-to-square"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>