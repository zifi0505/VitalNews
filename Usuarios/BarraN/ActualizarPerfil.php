<?php
include '../conexion.php';
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['userid'])) {
    header("Location: ../iniciarSesion/iniciarSesion.html");
    exit();
}

// Obtener datos del formulario
$id = $_SESSION['userid'];
$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$foto = null;

// Validar campos requeridos
if (empty($username) || empty($email)) {
    echo "Nombre de usuario y correo electrónico son obligatorios.";
    exit();
}

// Procesar imagen si se subió
if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
    $foto = file_get_contents($_FILES['profile_image']['tmp_name']);
}

// Preparar SQL para actualización
$sql = "UPDATE usuarios SET username = ?, email = ?";
$params = [$username, $email];

// Actualizar contraseña si se proporcionó
if (!empty($password)) {
    if (strlen($password) < 10 || preg_match('/\s/', $password)) {
        echo "La contraseña debe tener al menos 10 caracteres y no contener espacios.";
        exit();
    }
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql .= ", password = ?";
    $params[] = $hashedPassword;
}

// Actualizar foto si se proporcionó
if ($foto !== null) {
    $sql .= ", fotoPerfil = ?";
    $params[] = $foto;
}

$sql .= " WHERE id = ?";
$params[] = $id;

// Preparar y ejecutar la consulta
$stmt = $conn->prepare($sql);

// Vincular parámetros dinámicamente
$types = str_repeat("s", count($params) - 1) . "i"; // Todos string excepto el último que es ID
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    // Actualizar variables de sesión
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;

    if ($foto !== null) {
        $_SESSION['fotoperfil'] = $foto;
    }

    echo "<script>
        alert('Perfil actualizado correctamente.');
        window.location.href = '../Inicio/indexUsuarios.php';
    </script>";
} else {
    echo "Error al actualizar el perfil: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
