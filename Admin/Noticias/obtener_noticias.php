<?php
// Incluir el archivo de configuración de la base de datos
include 'config.php';

// Consulta SQL para obtener las noticias
$sql = "SELECT titulo, subtitulo, cuerpo, imagen_principal, imagenes_adicionales FROM noticias"; // Reemplaza "noticias" con el nombre de tu tabla
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<article class='news-item'>";
        echo "<div class='news-content'>";
        echo "<a href='Inicio.html'><img src='" . $row["imagen_principal"] . "' alt=''></a>";
        echo "<div><h3>" . $row["titulo"] . "</h3>";
        echo "<p>" . $row["cuerpo"] . "</p>";
        echo "</div>";

        // Mostrar imágenes adicionales (si las hay)
        if (!empty($row["imagenes_adicionales"])) {
            $imagenes = explode(",", $row["imagenes_adicionales"]);
            foreach ($imagenes as $imagen) {
                echo "<img src='" . trim($imagen) . "' alt='' style='max-width: 100px;'>";
            }
        }

        echo "<h1 class='imagen'></h1>";
        echo "</div>";
        echo "</article>";
    }
} else {
    echo "<p>No se encontraron noticias.</p>";
}

$conn->close();
?>