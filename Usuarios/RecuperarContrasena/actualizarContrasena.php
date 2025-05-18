<?php
$conexion = new mysqli("localhost", "root", "", "vitalnews");

$token = $_POST['token'];
$nueva = password_hash($_POST['nuevaContrasena'], PASSWORD_DEFAULT);
$ahora = date("Y-m-d H:i:s");

$stmt = $conexion->prepare("SELECT id FROM usuarios WHERE password_reset_token = ? AND password_reset_expires > ?");
$stmt->bind_param("ss", $token, $ahora);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $id = $result->fetch_assoc()['id'];

    $stmt = $conexion->prepare("UPDATE usuarios SET password = ?, password_reset_token = NULL, password_reset_expires = NULL WHERE id = ?");
    $stmt->bind_param("si", $nueva, $id);
    $stmt->execute();

    header("Location: cambiarContrasena.html?success=1");
    exit();
} else {
    header("Location: cambiarContrasena.html?error=1");
    exit();
}
?>
