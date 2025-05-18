<?php

include '../conexion.php'; 

if (session_status() === PHP_SESSION_NONE) {
    session_start(); // INICIA SESIÓN SOLO SI NO ESTÁ ACTIVA
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Verifica que el usuario haya iniciado sesión
$usuario = isset($_SESSION['username']) ? $_SESSION['username'] : null;

// Procesamiento del formulario (insertar comentario)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['comentario']) && isset($_POST['id_noticia'])) {
    $comentario = $_POST['comentario'];
    $id_noticia = $_POST['id_noticia'];
    
    if ($usuario && $comentario && $id_noticia) {
        $sql_insert = "INSERT INTO comentarios (id_noticia, nombre_usuario, comentario, fecha_comentario) VALUES (?, ?, ?, NOW())";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("iss", $id_noticia, $usuario, $comentario);
        $stmt_insert->execute();
        $stmt_insert->close();
    }
}
?>

<!-- Enlace al CSS para estilos de comentarios -->
<style>
    .comentarios-container,
    .comentarios-lista {
        width: 60%;
        max-width: 900px;  
        margin: 30px auto;
        background-color: #f9f9f9;
        padding: 25px 30px;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        font-family: 'Segoe UI', sans-serif;
    }

    .comentarios-container h3,
    .comentarios-lista h3 {
        font-size: 1.2em;
        margin-bottom: 15px;
        color: #333;
    }

    .comentarios-container form label {
        font-weight: 600;
        color: #333;
    }

    .comentarios-container form input,
    .comentarios-container form textarea {
        width: 100%;
        padding: 12px;
        margin-bottom: 15px;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 0.95em;
        box-sizing: border-box;
    }

    .comentarios-container form button {
        width: 100%;
        padding: 12px;
        background-color: #4267B2;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        transition: background-color 0.3s ease;
        cursor: pointer;
    }

    .comentarios-container form button:hover {
        background-color: #365899;
    }

    .comentario {
        display: flex;
        align-items: flex-start;
        background-color: #2c2c2e;
        color: #fff;
        padding: 15px 20px;
        border-radius: 18px;
        margin-bottom: 15px;
        font-size: 0.95em;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .comentario img.avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        margin-right: 15px;
        object-fit: cover;
    }

    .comentario-content {
        flex: 1;
    }

    .comentario strong {
        color: #fff;
        font-weight: bold;
    }

    .comentario p {
        color: white;
        margin: 5px 0;
        line-height: 1.5;
    }
</style>

<?php
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_noticia = $_GET['id'];

    // Formulario para nuevo comentario
    if ($usuario) {
        echo '
        <div class="comentarios-container">
            <h3 data-translate>Deja un comentario:</h3>
            <form method="post">
                <input type="hidden" name="id_noticia" value="' . htmlspecialchars($id_noticia) . '">
                <div>
                    <label for="comentario" data-translate>Comentario:</label><br>
                    <textarea id="comentario" name="comentario" rows="5" required></textarea>
                </div>
                <button type="submit" data-translate>Publicar comentario</button>
            </form>
        </div>';
    } else {
        echo '<div class="comentarios-container"><p data-translate>Debes iniciar sesión para comentar.</p></div>';
    }

    // Mostrar comentarios existentes
    $sql_comentarios = "SELECT nombre_usuario, comentario, fecha_comentario FROM comentarios WHERE id_noticia = ? ORDER BY fecha_comentario DESC";
    $stmt = $conn->prepare($sql_comentarios);
    $stmt->bind_param("i", $id_noticia);
    $stmt->execute();
    $resultado = $stmt->get_result();

    echo '<div class="comentarios-lista"><h3 data-translate>Comentarios:</h3>';
    if ($resultado->num_rows > 0) {
        while ($comentario = $resultado->fetch_assoc()) {
            // Obtener la foto de perfil de cada usuario que comenta
            $foto_perfil_comentario = '../Comentarios/du.jpg'; // Por defecto
            $sql_foto_c = "SELECT fotoPerfil FROM usuarios WHERE username = ?";
            $stmt_foto_c = $conn->prepare($sql_foto_c);
            $stmt_foto_c->bind_param("s", $comentario['nombre_usuario']);
            $stmt_foto_c->execute();
            $stmt_foto_c->store_result();
            if ($stmt_foto_c->num_rows > 0) {
                $stmt_foto_c->bind_result($fotoBlobC);
                $stmt_foto_c->fetch();
                if (!empty($fotoBlobC)) {
                    $foto_perfil_comentario = 'data:image/jpeg;base64,' . base64_encode($fotoBlobC);
                }
            }
            $stmt_foto_c->close();

            echo "<div class='comentario'>";
            echo "<img src='" . htmlspecialchars($foto_perfil_comentario) . "' class='avatar' alt='Usuario'>";
            echo "<div class='comentario-content'>";
            echo "<p><strong>" . htmlspecialchars($comentario['nombre_usuario']) . "</strong></p>";
            echo "<p>" . nl2br(htmlspecialchars($comentario['comentario'])) . "</p>";
            echo "</div></div>";
        }
    } else {
        echo "<p data-translate>Aún no hay comentarios. ¡Sé el primero en comentar!</p>";
    }
    echo '</div>';

    $stmt->close();
    $conn->close();
} else {
    echo "ID de noticia no especificado.";
}
?>