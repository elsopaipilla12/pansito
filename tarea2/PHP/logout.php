<?php
session_start();
session_destroy(); // Destruye toda la información de la sesión
header("Location: login.php"); // Redirige al login
exit();
?>