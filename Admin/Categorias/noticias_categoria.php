<?php
include '../conexion.php';

$categoria = $_GET['categoria'] ?? '';

// Eliminar noticia si se solicita
if (isset($_GET['eliminar'])) {
    $idEliminar = intval($_GET['eliminar']);
    $sqlEliminar = "DELETE FROM informacion WHERE id = ?";
    $stmtEliminar = $conn->prepare($sqlEliminar);
    $stmtEliminar->bind_param("i", $idEliminar);
    $stmtEliminar->execute();
}

$sql = "SELECT id, titulo, Imagen FROM informacion WHERE categoria = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $categoria);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias de <?php echo htmlspecialchars($categoria); ?></title>
    <link rel="stylesheet" href="categorias.css">
    <link rel="stylesheet" href="../footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .categories {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin: 20px auto;
            max-width: 1200px;
        }

        .category {
            text-align: center;
            text-decoration: none;
            color: #333;
            transition: transform 0.2s, box-shadow 0.3s ease;
        }

        .category img {
            width: 100%;
            height: 200px;
            border-radius: 8px;
            object-fit: cover;
            transition: box-shadow 0.3s ease;
        }

        .category:hover {
            transform: scale(1.05);
        }

        .category h3 {
            margin-top: 10px;
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
        }

        .category a {
            text-decoration: none;
            color: inherit;
        }

        .actions {
            margin-top: 10px;
        }

        .actions a {
            display: inline-block;
            margin: 5px;
            padding: 8px 12px;
            font-size: 0.9rem;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .actions .btn-ver {
            background-color: #007bff;
        }

        .actions .btn-ver:hover {
            background-color: #0056b3;
        }

        .actions .btn-editar {
            background-color: #ffc107;
        }

        .actions .btn-editar:hover {
            background-color: #e0a800;
        }

        .actions .btn-eliminar {
            background-color: #dc3545;
        }

        .actions .btn-eliminar:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <?php include("../BarraN/barra_de_navegacion.php"); ?>
    <div class="fondo"></div>

    <div class="contenedor">
        <header>
            <h1>Noticias de "<?php echo htmlspecialchars($categoria); ?>"</h1>
            <h2>Explora las noticias de esta categoría</h2>
        </header>

        <main>
            <div class="categories">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $imagenSrc = 'data:image/jpeg;base64,' . base64_encode($row["Imagen"]);
                        echo '<div class="category">';
                        echo '<a href="../Noticias/noticia.php?id=' . $row["id"] . '">';
                        echo '<img src="' . $imagenSrc . '" alt="' . htmlspecialchars($row["titulo"]) . '">';
                        echo '<h3>' . htmlspecialchars($row["titulo"]) . '</h3>';
                        echo '</a>';
                        echo '<div class="actions">';
                        echo '<a href="../Noticias/noticia.php?id=' . $row["id"] . '" class="btn-ver">Ver</a>';
                        echo '<a href="../Noticias/editar_Noticia.php?id=' . $row["id"] . '" class="btn-editar">Editar</a>';
                        echo '<a href="?categoria=' . urlencode($categoria) . '&eliminar=' . $row["id"] . '" class="btn-eliminar" onclick="return confirm(\'¿Estás seguro de que deseas eliminar esta noticia?\')">Eliminar</a>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No hay noticias para esta categoría.</p>";
                }
                ?>
            </div>
        </main>
    </div>

    <div class="footer">
        <p class="footer-title">Vitals News</p>
        <p>Contáctanos</p>
        <div class="social-icons-container">
            <a href="mailto:vitals.news.pi@gmail.com" target="_blank">
                <i class="fas fa-envelope"></i>
            </a>
            <a href="https://www.facebook.com/share/1DsxG3er3o/" target="_blank">
                <i class="fab fa-facebook-f"></i>
            </a>
        </div>
    </div>
</body>
</html>
