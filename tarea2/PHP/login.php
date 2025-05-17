<?php
session_start(); 
include("conexion.php");

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = mysqli_real_escape_string($conexion, $_POST["usuario"]);
    $password = $_POST["password"];

    if (empty($usuario) || empty($password)) {
        $error_message = "Por favor, ingresa usuario y contraseña.";
    } else {
        // Buscar en la tabla autores
        $query_autor = "SELECT rut_autor AS rut, nombre_autor AS nombre, correo_autor AS correo, usuario_autor AS usuario, contraseña_autor AS password 
                        FROM autores 
                        WHERE usuario_autor = '$usuario'";
        $result_autor = mysqli_query($conexion, $query_autor);

        if ($result_autor && mysqli_num_rows($result_autor) == 1) {
            $row = mysqli_fetch_assoc($result_autor);
            if (password_verify($password, $row["password"])) {
                // Usuario es autor
                $_SESSION["usuario_rut"] = $row["rut"];
                $_SESSION["usuario_nombre"] = $row["nombre"];
                $_SESSION["usuario_correo"] = $row["correo"];
                $_SESSION["usuario_tipo"] = "autor";

                header("Location: home_autor.php");
                exit();
            } else {
                $error_message = "Usuario o contraseña incorrectos.";
            }
        } else {
            // Buscar en la tabla revisores
            $query_revisor = "SELECT rut_revisor AS rut, nombre_revisor AS nombre, correo_revisor AS correo, rol_revisor AS rol, usuario_revisor AS usuario, contraseña_revisor AS password 
                              FROM revisores 
                              WHERE usuario_revisor = '$usuario'";
            $result_revisor = mysqli_query($conexion, $query_revisor);

            if ($result_revisor && mysqli_num_rows($result_revisor) == 1) {
                $row = mysqli_fetch_assoc($result_revisor);
                if (password_verify($password, $row["password"])) {
                    // Usuario es revisor o admin
                    $_SESSION["usuario_rut"] = $row["rut"];
                    $_SESSION["usuario_nombre"] = $row["nombre"];
                    $_SESSION["usuario_correo"] = $row["correo"];

                    $rol = strtolower(trim($row["rol"])); // por si acaso hay mayúsculas o espacios

                    if ($rol == "admin") {
                        $_SESSION["usuario_tipo"] = "admin";
                        header("Location: home_admin.php");
                        exit();
                    } elseif ($rol == "revisor" || $rol == "" || $rol == "pendiente") {
                        $_SESSION["usuario_tipo"] = "revisor";
                        header("Location: home_revisor.php");
                        exit();
                    } else {
                        $error_message = "Rol de usuario no válido.";
                    }
                } else {
                    $error_message = "Usuario o contraseña incorrectos.";
                }
            } else {
                $error_message = "Usuario o contraseña incorrectos.";
            }
        }
    }
}

include("../HTML/login.html");

// Mostrar mensaje de error en HTML si existe
echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            let errorMessage = document.getElementById('error-message');
            if (errorMessage) {
                errorMessage.textContent = '" . htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8') . "';
            }
        });
      </script>";
?>
