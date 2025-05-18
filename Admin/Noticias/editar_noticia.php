<?php
include '../conexion.php';

$id = $_GET['id'] ?? null;

if (!$id) {
  echo "ID no válido";
  exit;
}

// Obtener datos actuales
$sql = "SELECT * FROM informacion WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
  echo "Noticia no encontrada";
  exit;
}

$noticia = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title data-translate>Editar Noticia</title>
  <script src="https://cdn.tiny.cloud/1/f39ig8vqzbljg4nvcd9jt8h71r5gh3geerv7ziqjxzu48ywk/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
  <link rel="stylesheet" href="footer.css">
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
    }

    nav {
      background: rgba(254, 254, 254, 0.7);
      padding: 15px;
      color: white;
    }

    .bg {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 50px 20px;
    }

    .form-container {
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      padding: 5%;
      border-radius: 25px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
      width: 45%;
      max-width: 95%;
      border: 1px solid rgba(255, 255, 255, 0.2);
      margin-top: 70px;
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #ffffff;
      text-shadow: 0 1px 3px rgba(255, 255, 255, 0.5);
    }

    label {
      display: block;
      font-weight: 60%;
      margin-top: 15px;
      color: #ffffff;
      text-shadow: 0 1px 2px rgba(255, 255, 255, 0.5);
    }

    input[type="text"],
    input[type="file"],
    select {
      width: 100%;
      padding: 12px 15px;
      border-radius: 12px;
      border: none;
      margin-top: 5px;
      color: #808080;
      font-size: 15px;
      backdrop-filter: blur(5px);
    }

    input[type="text"]::placeholder {
      color: #6f6f6f;
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
      box-shadow: 0 5px 15px rgba(255, 255, 255, 0.2);
    }

    .button:hover {
      transform: scale(1.03);
      background: linear-gradient(to right, #00dfd8, #007cf0);
      box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }

    @media (max-width: 500px) {
      .form-container {
        padding: 25px;
      }

      .button {
        font-size: 15px;
      }
    }

    .tox {
      border-radius: 10px !important;
    }
  </style>
</head>

<body>
<?php include '../BarraN/barra_de_navegacion.php'; ?>

  <div class="bg">
    <div class="form-container">
      <h2 data-translate>Editar Noticia</h2>
      <form action="actualizar_noticia.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= htmlspecialchars($noticia['id']) ?>">

        <label for="titulo" data-translate>Título</label>
        <input type="text" name="titulo" id="titulo" required value="<?= htmlspecialchars($noticia['titulo']) ?>" class="traducible-placeholder"/>

        <label for="subtitulo" data-translate>Subtítulo</label>
        <input type="text" name="subtitulo" id="subtitulo" required value="<?= htmlspecialchars($noticia['subtitulo']) ?>" class="traducible-placeholder"/>

        <label for="cuerpo" data-translate>Cuerpo</label>
        <textarea name="cuerpo" id="cuerpo"><?= htmlspecialchars($noticia['cuerpo']) ?></textarea>

        <label for="categoria" data-translate>Categoría</label>
        <input type="text" name="categoria" id="categoria" value="<?= htmlspecialchars($noticia['categoria']) ?>" required class="traducible-placeholder"/>

        <label for="autor" data-translate >Autor</label>
        <input type="text" name="autor" id="autor" required value="<?= htmlspecialchars($noticia['autor']) ?>" class="traducible-placeholder"/>

        <label for="imagen" data-translate>Cambiar imagen</label>
        <input type="file" name="imagen" id="imagen" accept="image/*"/>

        <button class="button" type="submit" data-translate>Guardar Cambios</button>
      </form>
    </div>
  </div>

  <div class="footer">
    <p class="footer-title" data-translate>Vitals News</p>
    <p data-translate>Contáctanos</p>
    <div class="social-icons-container">
        <a href="https://mail.google.com/mail/?view=cm&fs=1&to=vitals.news.pi@gmail.com&su=Asunto&body=Cuerpo%20del%20mensaje" target="_blank">
        <i class="fas fa-envelope">
        </i>
      </a>
      <a href="https://www.facebook.com/share/1DsxG3er3o/" target="_blank"><i class="fab fa-facebook-f"></i></a>
    </div>
  </div>

  <script>
    tinymce.init({
      selector: 'textarea#cuerpo',
      height: 300,
      menubar: false,
      plugins: [
        'advlist autolink lists link image charmap preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table code help wordcount'
      ],
      toolbar:
        'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
      content_style: 'body { font-family:Arial,sans-serif; font-size:14px }'
    });
  </script>
</body>
</html>