<?php
include '../conexion.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID no válido";
    exit;
}

// Obtener datos actuales de la categoría
$sql = "SELECT * FROM Categorias WHERE id_categoria = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    echo "Categoría no encontrada";
    exit;
}

$categoria = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-translate>Editar Categoría</title>
    <script src="https://cdn.tiny.cloud/1/f39ig8vqzbljg4nvcd9jt8h71r5gh3geerv7ziqjxzu48ywk/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
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
            /* Permitir scroll */
            overflow-y: auto;
        }
        nav { 
            background: rgba(254, 254, 254, 0.7); padding: 15px; color: white; 
        }
        
        .bg { 
            flex: 1; display: flex; align-items: center; justify-content: center; padding: 50px 20px; 
        }

        .form-container {
            background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px);
            padding: 5%; border-radius: 25px; width: 45%; max-width: 95%;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2); border: 1px solid rgba(255, 255, 255, 0.2);
        }

        h2 { 
            text-align: center; color: white; text-shadow: 0 1px 3px rgba(255,255,255,0.5); 
        }

        label { 
            display: block; margin-top: 15px; color: white; text-shadow: 0 1px 2px rgba(255,255,255,0.5); 
        }

        input, textarea {
            width: 100%; padding: 12px 15px; border-radius: 12px;
            border: none; margin-top: 5px; font-size: 15px; backdrop-filter: blur(5px);
        }

        .button {
            margin-top: 25px; width: 100%; padding: 12px;
            background: linear-gradient(to right, #ff6a00, #ee0979);
            color: white; font-weight: bold; border: none;
            border-radius: 50px; font-size: 16px;
            box-shadow: 0 5px 15px rgba(255,255,255,0.2); cursor: pointer;
        }

        .button:hover {
            transform: scale(1.03);
            background: linear-gradient(to right, #ee0979, #ff6a00);
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }

        .footer { 
            margin-top: auto; background: #333; color: #fff; padding: 20px 0; text-align: center; 
        }

        .preview-img {
            margin-top: 15px;
            max-width: 100%;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

    </style>
</head>

<body>
    <?php include '../BarraN/barra_de_navegacion.php'; ?>

    <div class="bg">
        <div class="form-container">
            <h2 data-translate>Editar Categoría</h2>
            <form action="actualizar_categoria.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_categoria" value="<?= htmlspecialchars($categoria['id_categoria']) ?>">

                <label for="nombre_categoria" data-translate>Nombre de la Categoría</label>
                <input type="text" name="nombre_categoria" id="nombre_categoria" required value="<?= htmlspecialchars($categoria['nombre_categoria']) ?>" class="traducible-placeholder"/>

                <?php if (!empty($categoria['imagen_categoria'])): ?>
                    <label data-translate>Imagen Actual</label>
                    <img src="data:image/jpeg;base64,<?= base64_encode($categoria['imagen_categoria']) ?>" alt="Imagen actual" class="preview-img">
                <?php endif; ?>

                <label for="imagen_categoria" data-translate>Cambiar Imagen</label>
                <input type="file" name="imagen_categoria" id="imagen_categoria" accept="image/*"/>

                <button class="button" type="submit" data-translate>Guardar Cambios</button>
            </form>
        </div>
    </div>

    <div class="footer">
        <p class="footer-title" data-translate>Vitals News</p>
        <p data-translate>Contáctanos</p>
        <div class="social-icons-container">
            <a href="mailto:vitals.news.pi@gmail.com" target="_blank"><i class="fas fa-envelope"></i></a>
            <a href="https://www.facebook.com/share/1DsxG3er3o/" target="_blank"><i class="fab fa-facebook-f"></i></a>
        </div>
    </div>
</body>
</html>