<?php
ob_start();
session_start();
$_SESSION = array();
session_destroy();
header("Location: ../Inicio/indexUsuarios.php");

// Redirección de respaldo
echo '<script>window.location.href = "../Inicio/indexUsuarios.php";</script>';
echo '<noscript><meta http-equiv="refresh" content="0;url=../Inicio/indexUsuarios.php" /></noscript>';
exit();
?>