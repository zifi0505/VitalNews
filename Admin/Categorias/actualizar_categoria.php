<?php
// filepath: c:\xampp\htdocs\actualizar_categoria.php

include '../conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_categoria = $_POST['id_categoria'] ?? null;
    $nombre_categoria = $_POST['nombre_categoria'] ?? '';

    if (!$id_categoria || empty($nombre_categoria)) {
        echo "Datos incompletos.";
        exit;
    }

    // Si se ha subido una nueva imagen
    if (isset($_FILES['imagen_categoria']) && $_FILES['imagen_categoria']['error'] === UPLOAD_ERR_OK) {
        $imagenTmp = $_FILES['imagen_categoria']['tmp_name'];
        $imagenContenido = file_get_contents($imagenTmp);

        // Preparar la sentencia con la imagen
        $sql = "UPDATE Categorias SET nombre_categoria = ?, imagen_categoria = ? WHERE id_categoria = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sbi", $nombre_categoria, $imagenContenido, $id_categoria);

        // Enviar los datos binarios como BLOB
        $stmt->send_long_data(1, $imagenContenido);
    } else {
        // Sin imagen nueva, solo actualizar el nombre
        $sql = "UPDATE Categorias SET nombre_categoria = ? WHERE id_categoria = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $nombre_categoria, $id_categoria);
    }

    // Ejecutar y redireccionar
    if ($stmt->execute()) {
        header("Location: AdministrarNoticias.php");
        exit;
    } else {
        echo "Error al actualizar la categoría: " . $stmt->error;
    }
} else {
    echo "Método de solicitud no válido.";
}
?>
