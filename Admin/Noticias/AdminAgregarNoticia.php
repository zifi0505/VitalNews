<?php
include('../conexion.php');

// Manejo AJAX para categorías
if (isset($_GET['getCategorias'])) {
    $sql = "SELECT nombre_categoria FROM Categorias";
    $result = $conn->query($sql);
    $categorias = [];

    while ($row = $result->fetch_assoc()) {
        $categorias[] = [
            "nombre_categoria" => $row['nombre_categoria']
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($categorias);
    exit;
}

// Procesamiento del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $subtitulo = $_POST['subtitulo'];
    $cuerpo = $_POST['cuerpo'];
    $autor = $_POST['autor'];
    $categoriaNombre = $_POST['categoria'];

    if (empty($categoriaNombre)) {
        echo "<script>alert('Debe seleccionar una categoría.'); window.history.back();</script>";
        exit;
    }

    $imagenBlob = null;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagenBlob = file_get_contents($_FILES['imagen']['tmp_name']);
    }

    // Verificar si la categoría ya existe por nombre
    $stmtCat = $conn->prepare("SELECT nombre_categoria FROM Categorias WHERE nombre_categoria = ?");
    $stmtCat->bind_param("s", $categoriaNombre);
    $stmtCat->execute();
    $stmtCat->store_result();

    if ($stmtCat->num_rows == 0) {
        // Si no existe, insertarla
        $imagenDummy = null;
        $insertCat = $conn->prepare("INSERT INTO Categorias (nombre_categoria, imagen_categoria) VALUES (?, ?)");
        $insertCat->bind_param("sb", $categoriaNombre, $imagenDummy);
        $insertCat->send_long_data(1, '');
        $insertCat->execute();
        $insertCat->close();
    }
    $stmtCat->close();

    $stmt = $conn->prepare("INSERT INTO informacion (titulo, subtitulo, cuerpo, autor, categoria, imagen) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $titulo, $subtitulo, $cuerpo, $autor, $categoriaNombre, $imagenBlob);
    $stmt->send_long_data(5, $imagenBlob);

    if ($stmt->execute()) {
        echo "<script>alert('Noticia insertada correctamente.');</script>";
    } else {
        echo "<script>alert('Error al insertar la noticia: " . $stmt->error . "');</script>";
    }

    header("Location: ../Noticias/Noticia.php?id=" . $conn->insert_id);
    exit;

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title data-translate>Insertar Noticia</title>
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

  <!-- FORMULARIO CENTRADO -->
  <div class="bg">
    <div class="form-container">
      <h2 data-translate>Insertar Noticia</h2>
      <form action="" method="post" enctype="multipart/form-data" onsubmit="return validarFormulario()">
        <label for="titulo" data-translate>Título</label>
        <input type="text" name="titulo" id="titulo" required placeholder="Título de la noticia" class="traducible-placeholder" />

        <label for="subtitulo" data-translate>Subtítulo</label>
        <input type="text" name="subtitulo" id="subtitulo" required placeholder="Subtítulo breve" class="traducible-placeholder" />

        <label for="cuerpo" data-translate>Cuerpo</label>
        <textarea name="cuerpo" id="cuerpo"></textarea>

        <label for="categoria" data-translate>Seleccionar categoría</label>
        <select name="categoria" id="categoria" required></select>

        <label for="autor" data-translate>Autor</label>
        <input type="text" name="autor" id="autor" required placeholder="Nombre del autor" class="traducible-placeholder" />

        <label for="imagen" data-translate>Imagen</label>
        <input type="file" name="imagen" id="imagen" accept="image/*" required />

        <button class="button" type="submit" data-translate data-force-en="Upload">Subir</button>
      </form>
    </div>
  </div>

  <!-- FOOTER -->
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

  <!-- SCRIPT -->
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

    // Llenar select de categorías
    window.addEventListener('DOMContentLoaded', () => {
      fetch('AdminAgregarNoticia.php?getCategorias=1')
        .then(response => response.json())
        .then(data => {
          const select = document.getElementById('categoria');
          select.innerHTML = '';

          if (data.length === 0) {
            select.innerHTML = '<option value="" data-translate>No hay categorías</option>';
          } else {
            const defaultOption = document.createElement('option');
            defaultOption.value = "";
            defaultOption.textContent = "Seleccionar categoría...";
            defaultOption.setAttribute('data-translate', '');
            select.appendChild(defaultOption);

            data.forEach(categoria => {
              const option = document.createElement('option');
              option.value = categoria.nombre_categoria;
              option.textContent = categoria.nombre_categoria;
              select.appendChild(option);
            });
          }
        })
        .catch(error => {
          console.error('Error al cargar las categorías:', error);
          document.getElementById('categoria').innerHTML = '<option value="" data-translate>Error al cargar</option>';
        });
    });

    // Validación frontend antes de enviar
    function validarFormulario() {
      const categoria = document.getElementById('categoria').value;
      if (!categoria) {
        alert('Por favor, selecciona una categoría antes de continuar.');
        return false;
      }
      return true;
    }
  </script>

</body>
</html>