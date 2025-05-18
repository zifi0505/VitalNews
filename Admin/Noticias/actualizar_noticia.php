<?php
include '../conexion.php';

// Validar si se recibió un ID válido
if (!isset($_POST['id']) || empty($_POST['id'])) {
    die("ID de noticia no proporcionado.");
}

$id = intval($_POST['id']);
$titulo = $_POST['titulo'] ?? '';
$subtitulo = $_POST['subtitulo'] ?? '';
$cuerpo = $_POST['cuerpo'] ?? '';
$categoria = $_POST['categoria'] ?? '';
$autor = $_POST['autor'] ?? '';
$nuevaCategoria = $_POST['crearCategoria'] ?? '';

// Prioriza la nueva categoría si se proporciona
if (!empty($nuevaCategoria)) {
    $categoria = $nuevaCategoria;
}

// Verificar si se subió una nueva imagen
$imagen = null;
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $imagen = file_get_contents($_FILES['imagen']['tmp_name']);
}

// Preparar SQL dinámico según si hay imagen
if ($imagen !== null) {
    $sql = "UPDATE informacion SET titulo=?, subtitulo=?, cuerpo=?, categoria=?, autor=?, Imagen=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $titulo, $subtitulo, $cuerpo, $categoria, $autor, $imagen, $id);
} else {
    $sql = "UPDATE informacion SET titulo=?, subtitulo=?, cuerpo=?, categoria=?, autor=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $titulo, $subtitulo, $cuerpo, $categoria, $autor, $id);
}

if ($stmt->execute()) {
    // Redirigir a la página de administración de noticias
    header("Location: ../Noticias/AdministrarNoticias.php");
    exit; // Asegúrate de detener la ejecución después de redirigir
} else {
    echo "Error al actualizar la noticia: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
