<?php
// Conectar a la base de datos
include '../conexion.php';

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos del formulario
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$lang = $_POST['lang'] ?? 'es';

// Validar formato de correo
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Error: El correo electrónico no es válido.");
}

// Verificar si el nombre de usuario o email ya existen
$sql_verificar = "SELECT * FROM usuarios WHERE username = ? OR email = ?";
$stmt_verificar = $conn->prepare($sql_verificar);
$stmt_verificar->bind_param("ss", $username, $email);
$stmt_verificar->execute();
$resultado = $stmt_verificar->get_result();

if ($resultado->num_rows > 0) {
    header("Location: Registro.html?error=1&lang=$lang");
    exit();
}
$stmt_verificar->close();

// Encriptar la contraseña
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Leer imagen por defecto como binario
$imagenPorDefecto = file_get_contents(__DIR__ . '/perfil.jpg');

// Insertar usuario con imagen por defecto
$sql = "INSERT INTO usuarios (username, email, password, fotoPerfil) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $username, $email, $passwordHash, $imagenPorDefecto);

if ($stmt->execute()) {
    header("Location: Registro.html?success=1&lang=$lang");
    exit();
} else {
    echo "Error al registrar: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>