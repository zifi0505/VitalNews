<?php
include '../conexion.php';

// Eliminar categoría si se solicita
if (isset($_GET['eliminar'])) {
    $idEliminar = intval($_GET['eliminar']);

    // Obtener el nombre de la categoría antes de eliminarla
    $stmtNombre = $conn->prepare("SELECT nombre_categoria FROM Categorias WHERE id_categoria = ?");
    $stmtNombre->bind_param("i", $idEliminar);
    $stmtNombre->execute();
    $resultado = $stmtNombre->get_result();

    if ($resultado->num_rows > 0) {
        $nombreCategoria = $resultado->fetch_assoc()['nombre_categoria'];

        // Eliminar noticias que tengan esta categoría
        $stmtNoticias = $conn->prepare("DELETE FROM informacion WHERE categoria = ?");
        $stmtNoticias->bind_param("s", $nombreCategoria);
        $stmtNoticias->execute();

        // Eliminar la categoría
        $sqlEliminar = "DELETE FROM Categorias WHERE id_categoria = ?";
        $stmtEliminar = $conn->prepare($sqlEliminar);
        $stmtEliminar->bind_param("i", $idEliminar);
        $stmtEliminar->execute();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-translate>Categorías de Salud</title>
    <link rel="stylesheet" href="categorias.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="../../auto-translate.js"></script>
    <style>
        .footer {
            text-align: center;
            padding: 20px;
            background: linear-gradient(to right, #333, #555);
            color: white;
            margin-top: 60px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            animation: fadeIn 1s ease-in-out;
            position: relative;
        }

        .footer-title {
            color: white;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .footer p {
            color: white;
        }

        .footer a {
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            margin: 5px 0;
            transition: transform 0.3s, color 0.3s;
        }

        .footer a:hover {
            color: #00aced;
            transform: scale(1.05);
        }

        .social-icons-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
            width: 100%;
        }

        .social-icons-container a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: #555;
            color: white;
            border-radius: 50%;
            text-decoration: none;
            transition: background-color 0.3s, transform 0.3s;
        }

        .social-icons-container a:hover {
            background-color: #007BFF;
            transform: scale(1.1);
        }

        .social-icons-container i {
            font-size: 20px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <?php include '../BarraN/barra_de_navegacion.php'; ?>

    <div class="fondo"></div> <!-- Fondo fijo -->

    <div class="contenedor">
        <header>
            <h1 data-translate>CATEGORÍAS</h1>
            <h2 data-translate>Explora los diferentes temas</h2>
        </header>

        <main>
            <div class="categories">
                <?php
                $sql = "SELECT id_categoria, nombre_categoria, imagen_categoria FROM Categorias";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $blobData = $row["imagen_categoria"];
                        $imagenSrc = "data:image/jpeg;base64," . base64_encode($blobData);

                        echo '<div class="category">';
                        echo '<a href="noticias_categoria.php?categoria=' . urlencode($row["nombre_categoria"]) . '">';
                        echo '<img src="' . $imagenSrc . '" alt="' . htmlspecialchars($row["nombre_categoria"]) . '">';
                        echo '<h3 data-translate>' . htmlspecialchars($row["nombre_categoria"]) . '</h3>';
                        echo '</a>';
                        echo '<div class="actions">';
                        echo '<a href="editar_categoria.php?id=' . $row["id_categoria"] . '" class="btn-editar btn-adit" data-translate>✏️ Editar</a>';
                        echo '<a href="?eliminar=' . $row["id_categoria"] . '" class="btn-editar btn-eliminar" onclick="return confirm(\'¿Estás seguro de que deseas eliminar esta categoría?\')" data-translate data-force-en="🗑️Delete">🗑️ Eliminar</a>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<span data-translate>No se encontraron categorías.</span>';
                }
                ?>
            </div>
        </main>
    </div>

    <div class="footer">
        <h1 class="footer-title" data-translate>Vitals News</h1>
        <p data-translate>Contáctanos</p>
        <div class="social-icons-container">
          <a href="https://mail.google.com/mail/?view=cm&fs=1&to=vitals.news.pi@gmail.com&su=Asunto&body=Cuerpo%20del%20mensaje" target="_blank">
                <i class="fas fa-envelope">
                </i>
            </a>
            <a href="https://www.facebook.com/share/1DsxG3er3o/" target="_blank"><i class="fab fa-facebook-f"></i></a>
        </div>
    </div>
</body>
</html>