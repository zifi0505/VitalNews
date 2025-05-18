<?php
include '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_categoria = $_POST['nombre_categoria'] ?? null;
    $imagen_categoria = $_FILES['imagen_categoria'] ?? null;

    if (!$nombre_categoria) {
        echo "El nombre de la categoría es obligatorio.";
        exit;
    }

    if (!$imagen_categoria || $imagen_categoria['error'] !== UPLOAD_ERR_OK) {
        echo "La imagen de la categoría es obligatoria.";
        exit;
    }

    $contenido_imagen = file_get_contents($imagen_categoria['tmp_name']);

    $sql = "INSERT INTO Categorias (nombre_categoria, imagen_categoria) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $null = NULL; // para bind_param con blob
    $stmt->bind_param("sb", $nombre_categoria, $null); // 's' para string, 'b' para blob
    $stmt->send_long_data(1, $contenido_imagen);

    if ($stmt->execute()) {
        echo "Categoría creada correctamente.";
        header("Location: AdministrarNoticias.php");
        exit;
    } else {
        echo "Error al crear la categoría: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-translate data-force-en="Create Category">Crear Categoría</title>
    <link rel="stylesheet" href="../footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="../../auto-translate.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: url("../Imagenes/fondo2.0.jpg");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: auto;
        }
        .form-container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 5%;
            border-radius: 25px;
            width: 45%;
            max-width: 95%;
            margin: auto;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-top: 150px;
        }
        h2 {
            text-align: center;
            color: white;
            text-shadow: 0 1px 3px rgba(255, 255, 255, 0.5);
        }
        label {
            display: block;
            margin-top: 15px;
            color: white;
            text-shadow: 0 1px 2px rgba(255, 255, 255, 0.5);
        }
        input[type="text"], input[type="file"] {
            width: 100%;
            padding: 12px 15px;
            border-radius: 12px;
            border: none;
            margin-top: 5px;
            font-size: 15px;
        }
        input[type="file"] {
            text-align: center;
            padding: 10px;
            background-color: white;
            cursor: pointer;
        }
        .file-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 15px;
        }
        .button {
            margin-top: 25px;
            width: 100%;
            padding: 12px;
            background: linear-gradient(to right, #007cf0, #00dfd8);
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-size: 16px;
        }
        .button:hover {
            transform: scale(1.03);
            background: linear-gradient(to right, #00dfd8, #007cf0);
        }
    </style>
</head>
<body>
    <?php include '../BarraN/barra_de_navegacion.php'; ?>
    <div class="form-container">
        <h2 data-translate data-force-en="Create New Category">Crear Nueva Categoría</h2>
        <form action="crear_categoria.php" method="post" enctype="multipart/form-data">
            <label for="nombre_categoria" data-translate data-force-en="Category Name">Nombre de la Categoría</label>
            <input type="text" name="nombre_categoria" id="nombre_categoria" required
                class="traducible-placeholder"
                placeholder="Escribe el nombre de la categoría"
                data-force-en="Enter the category name">

            <label for="imagen_categoria" data-translate data-force-en="Category Image">Imagen de la Categoría</label>
            <label for="imagen_categoria" data-translate data-force-en="Select file">Seleccionar archivo</label>
            <input type="file" name="imagen_categoria" id="imagen_categoria" accept="image/*" required>

            <button class="button" type="submit" data-translate data-force-en="Create Category">Crear Categoría</button>
        </form>
    </div>

    <div class="footer">
        <p class="footer-title" data-translate data-force-en="Vitals News">Vitals News</p>
        <p data-translate data-force-en="Contact us">Contáctanos</p>
        <div class="social-icons-container">
            <a href="mailto:vitals.news.pi@gmail.com" target="_blank"><i class="fas fa-envelope"></i></a>
            <a href="https://www.facebook.com/share/1DsxG3er3o/" target="_blank"><i class="fab fa-facebook-f"></i></a>
        </div>
    </div>
</body>
</html>