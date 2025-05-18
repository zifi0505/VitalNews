<?php
include '../conexion.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "DELETE FROM informacion WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: noticias_categoria.php?categoria=noticia");
        exit;
    } else {
        echo "Error al eliminar la noticia: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "ID no proporcionado";
}
?>
