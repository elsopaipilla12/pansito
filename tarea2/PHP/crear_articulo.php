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
    <title>Panel del Autor</title>
    <link rel="stylesheet" href="../Public/CSS/estilohome.css">
    <link rel="stylesheet" href="../Public/CSS/estilos.css">
</head>
<body class="pagina-autor">
    <body class="pagina-autor">
    <a href="logout.php" class="btn-cerrar-sesion">Cerrar sesión</a>
    <div class="panel-autor">
        <div class="contenedor-principal">
            <!-- Formulario a la izquierda -->
            <div class="formulario-articulo">
                <h2>Bienvenido, autor</h2>
                <form action="procesar_articulo.php" method="post">
                    <h3>Datos del Artículo</h3>
                    <label>Título:</label>
                    <input type="text" name="titulo" required><br>

                    <label>Resumen:</label>
                    <textarea name="resumen" required></textarea><br>

                    <label>Tópicos (separados por coma):</label>
                    <input type="text" name="topicos" required><br>

                    <h3>Autores del artículo</h3>
                    <label>Nombre Autor 1:</label>
                    <input type="text" name="autor[0][nombre]" required>
                    <label>Email:</label>
                    <input type="email" name="autor[0][email]" required><br>

                    <label>Nombre Autor 2:</label>
                    <input type="text" name="autor[1][nombre]">
                    <label>Email:</label>
                    <input type="email" name="autor[1][email]"><br>

                    <label>Nombre Autor 3:</label>
                    <input type="text" name="autor[2][nombre]">
                    <label>Email:</label>
                    <input type="email" name="autor[2][email]"><br>
                    
                    <label>Selecciona autor de contacto:</label>
                    <select name="autor_contacto_index" required>
                        <option value="0">Autor 1</option>
                        <option value="1">Autor 2</option>
                        <option value="2">Autor 3</option>
                    </select><br>

                    <input type="submit" value="Enviar artículo">
                </form>
            </div>
            
            
            <div class="tabla-articulos">
                <h3>Tópicos de articulos</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">N°Topico</th>
                            <th scope="col">Topico</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "conexion.php";
                        $sql = $conexion->query("SELECT * FROM especialidad_topico");
                        while($datos = $sql->fetch_object()) { 
                        ?>
                        <tr>
                            <td><?= $datos->id_especialidad_topico ?></td>
                            <td><?= $datos->tipo ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>