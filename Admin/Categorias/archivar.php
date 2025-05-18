<?php
include '../conexion.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Obtener estado actual
    $sql = "SELECT Archivado FROM informacion WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($archivado);
    $stmt->fetch();
    $stmt->close();

    // Cambiar valor
    $nuevoEstado = ($archivado == 0) ? 1 : 0;

    $updateSql = "UPDATE informacion SET Archivado = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ii", $nuevoEstado, $id);

    if ($updateStmt->execute()) {
        header("Location: categorias.php?msg=estado_actualizado");
        exit;
    } else {
        echo "Error al cambiar el estado de archivado: " . $updateStmt->error;
    }

    $updateStmt->close();
} else {
    echo "ID no proporcionado";
}
?>
