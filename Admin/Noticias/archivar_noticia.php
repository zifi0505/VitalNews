<?php
include '../conexion.php';

if (isset($_GET['id']) && isset($_GET['accion'])) {
    $id = intval($_GET['id']);
    $accion = $_GET['accion'] === 'archivar' ? 1 : 0;

    $sql = "UPDATE Categorias SET archivado = ? WHERE id_categoria = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $accion, $id);
    $stmt->execute();

    header("Location: categorias.php"); // Redirige de nuevo
    exit();
}
?>