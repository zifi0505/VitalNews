<?php
include '../conexion.php';

$id_categoria = $_GET['id'] ?? null;

if (!$id_categoria) {
    echo "ID de categoría no válido.";
    exit;
}

// Consulta para eliminar la categoría
$sql = "DELETE FROM Categorias WHERE id_categoria = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_categoria);

if ($stmt->execute()) {
    echo "Categoría eliminada correctamente.";
    header("Location: AdministrarNoticias.php");
    exit;
} else {
    echo "Error al eliminar la categoría: " . $conn->error;
}
?>