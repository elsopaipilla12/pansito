<?php
session_start();
if (!isset($_SESSION["usuario_rut"]) || $_SESSION["usuario_tipo"] !== "autor") {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Artículos Enviados</title> 
    <link rel="stylesheet" href="../Public/CSS/admin.css">
    <script src="https://kit.fontawesome.com/23ed4a8228.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="pagina-autor">
    <a href="logout.php" class="btn-cerrar-sesion">Cerrar sesión</a>
    
    <div class="ver-revisores">
        <div class="tabla-revisores">
            <div class="tabla-articulos">
                <h3>Bienvenido <?= htmlspecialchars($_SESSION["usuario_nombre"] ?? 'Autor')?></h3> 
                <h3>Artículos Evaluados</h3> 
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID Artículo</th>
                            <th scope="col">Título</th>
                            <th scope="col">Resumen</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Autor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "conexion.php";
                        // Cambiamos la consulta para usar la vista
                        $sql = $conexion->query("SELECT * FROM ver_evaluados");
                        while($datos = $sql->fetch_object()) { 
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($datos->id_articulo) ?></td>
                            <td><?= htmlspecialchars($datos->titulo) ?></td>
                            <td><?= htmlspecialchars($datos->resumen) ?></td>
                            <td><?= htmlspecialchars($datos->estado) ?></td>
                            <td><?= htmlspecialchars($datos->autor) ?></td>
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