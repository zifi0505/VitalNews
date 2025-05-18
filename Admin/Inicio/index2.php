<?php
// ARCHIVO PHP COMPLETO
include "../conexion.php";
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title data-translate>Noticias - Panel Admin</title>
  <link rel="stylesheet" href="../Categorias/categorias.css">
  <link rel="stylesheet" href="../footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="../../auto-translate.js"></script>
  <style>
    /* Tu CSS aquí (lo puedes mantener igual que antes)... */

    .sidebar a {
      background-color: #fff;
      display: block;
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 5px;
      color: #333;
      box-shadow: 0 0 5px rgba(0,0,0,0.05);
      transition: background 0.3s;
    }

    .fondo {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('../Imagenes/fondo.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        z-index: -1;
    }

    .sidebar a:hover {
      background-color: #ddd;
    }

    body {
      background-color: #eef1f5;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      overflow-x: hidden;
    }
    a {
      text-decoration: none
    }

    header.main-header {
      position: relative;
      width: 100%;
      height: 400px;
      overflow: hidden;
    }

    header.main-header img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .header-text {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      color: white;
      text-align: center;
      background-color: rgba(0, 0, 0, 0.64);
      padding: 20px;
      border-radius: 10px;
    }

    .header-text h1 {
      color: white;
      font-size: 48px;
      margin: 0;
    }

    .header-text p {
      color: rgba(255, 255, 255, 0.75);
      font-size: 20px;
      margin: 10px 0 0;
    }

    .main-content {
      display: flex;
      max-width: 1027px;
      margin: auto;
      padding: 40px 10px;
      gap: 30px;
      flex: 1;
      width: 1027px;
    }

    .container {
      flex: 2;
    }

    .sidebar {
      flex: 1;
      background-color: rgba(255, 255, 255, 0.8);
      padding: 20px;
      border-radius: 10px;
      height: fit-content;
    }

    .sidebar h3 {
      margin-bottom: 15px;
      color: #2c3e50;
    }

    .sidebar ul {
      list-style: none;
      padding: 0;
    }

    .sidebar li {
      margin-bottom: 10px;
    }

    .sidebar a {
      text-decoration: none;
      background-color: #fff;
      display: block;
      padding: 10px;
      border-radius: 5px;
      color: #333;
      box-shadow: 0 0 5px rgba(0,0,0,0.05);
      transition: all 0.3s;
    }

    .sidebar a:hover {
      background-color: #ddd;
    }

    .news-img {
      width: 250px;
      height: 200px;
      object-fit: cover;
      border-right: 1px solid #ddd;
    }

    .news-item {
      display: flex;
      background: #fff;
      border-radius: 10px;
      margin-bottom: 30px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .news-item:hover {
      transform: scale(1.02);
      box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }

    .news-img {
      width: 250px;
      height: auto;
      object-fit: cover;
      border-right: 1px solid #ddd;
    }

    .news-info {
      padding: 20px;
      flex: 1;
    }

    .news-info h3 {
      margin-top: 0;
      margin-bottom: 10px;
      color: #2c3e50;
    }

    .news-info small {
      display: block;
      margin-bottom: 10px;
      color: #999;
    }

    .news-info p {
      color: #333;
      line-height: 1.6;
      margin: 0;
    }

    form input[type="text"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .footer {
      text-align: center;
      padding: 20px;
      background: linear-gradient(to right, #333, #555);
      color: white;
      margin-top: auto;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
      width: 100%;
    }

    @media (max-width: 768px) {
      .main-content {
        flex-direction: column;
        padding: 20px;
      }

      .news-item {
        flex-direction: column;
      }

      .news-link {
        text-decoration: none;
        color: inherit;
        display: block;
      }
    }
  </style>
</head>

<body class="body">
  <?php include '../BarraN/barra_de_navegacion.php'; ?>
  <div class="fondo"></div>
  <header>
    <h1 data-translate data-force-en="HOME">INICIO</h1>
    <h2 data-translate data-force-en="Admin Control Panel">Panel de control Admin</h2>
  </header>

  <div class="main-content">
    <!-- CONTENEDOR PRINCIPAL -->
    <div class="container">
      <form method="GET">
        <input type="text" name="busquedaAdminNoticias" placeholder="Buscar noticia..." class="traducible-placeholder">
      </form>
      <br>

      <?php
      $busqueda = isset($_GET['busquedaAdminNoticias']) ? $_GET['busquedaAdminNoticias'] : '';

      $sql = "SELECT id, titulo, subtitulo, cuerpo, autor, Imagen, fecha_publicacion, Archivado
              FROM informacion 
              WHERE (titulo LIKE ? OR subtitulo LIKE ? OR cuerpo LIKE ?) 
              ORDER BY fecha_publicacion DESC";

      $stmt = $conn->prepare($sql);
      $busqueda_param = "%" . $busqueda . "%";
      $stmt->bind_param("sss", $busqueda_param, $busqueda_param, $busqueda_param);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
          setlocale(LC_TIME, 'es_ES.UTF-8', 'Spanish_Spain.1252');
          while($row = $result->fetch_assoc()) {
              if ($row["Archivado"] == 0) {
                  $titulo = htmlspecialchars($row["titulo"]);
                  $subtitulo = htmlspecialchars($row["subtitulo"]);
                  $contenido = substr($row["cuerpo"], 0, 100) . "...";
                  $autor = htmlspecialchars($row["autor"]);
                  $fecha = $row["fecha_publicacion"];
                  $imagenSrc = "data:image/jpeg;base64," . base64_encode($row["Imagen"]);

                  // Formatear fecha legible en español
                  $fecha_obj = new DateTime($fecha);
                  $fecha_legible = strftime('%d de %B de %Y', $fecha_obj->getTimestamp());

                  echo '<a href="../Noticias/noticia.php?id=' . $row["id"] . '" class="news-link">';
                  echo '<article class="news-item">';
                  echo '<img src="' . $imagenSrc . '" alt="' . $titulo . '" class="news-img">';
                  echo '<div class="news-info">';
                  echo '<h3>' . $titulo . '</h3>';
                  echo '<h4>' . $subtitulo . '</h4>';
                  echo '<p><strong data-translate>Autor:</strong> ' . $autor . '</p>';
                  echo '<br><p>' . $contenido . '</p>';
                  echo '<br><p data-translate>Fecha de publicación: ' . $fecha_legible . '</p>';
                  echo '</div>';
                  echo '</article>';
                  echo '</a>';
              }
          }
      } else {
          echo '<p data-translate>No se encontraron noticias.</p>';
      }
      ?>
    </div>

    <!-- SIDEBAR ARCHIVES -->
    <aside class="sidebar">
      <h3 data-translate>FECHAS</h3>
      <ul>
        <?php
        // Mostrar meses SIEMPRE en español para traducción automática
        setlocale(LC_TIME, 'es_ES.UTF-8', 'Spanish_Spain.1252');
        $sql_archives = "SELECT DISTINCT DATE_FORMAT(fecha_publicacion, '%Y-%m') AS mes
                         FROM informacion
                         WHERE Archivado = 0
                         ORDER BY mes DESC";
        $result_archives = $conn->query($sql_archives);

        if ($result_archives->num_rows > 0) {
          while ($row = $result_archives->fetch_assoc()) {
              $fecha_obj = DateTime::createFromFormat('Y-m', $row['mes']);
              $mes_legible = strftime('%B %Y', $fecha_obj->getTimestamp());
              $mes_legible = ucfirst($mes_legible);
              $enlace_mes = $fecha_obj->format('Y-m');
              echo '<li><a href="?archivo=' . $enlace_mes . '" data-translate data-original="' . $mes_legible . '">' . $mes_legible . '</a></li>';
          }
        } else {
          echo '<li><p data-translate>No hay archivos disponibles.</p></li>';
        }
        ?>
      </ul>
    </aside>
  </div>

  <div class="footer">
    <p class="footer-title" data-translate>Vitals News</p>
    <p data-translate>Contáctanos</p>
    <div class="social-icons-container">
          <a href="https://mail.google.com/mail/?view=cm&fs=1&to=vitals.news.pi@gmail.com&su=Asunto&body=Cuerpo%20del%20mensaje" target="_blank">
        <i class="fas fa-envelope"></i></a>
      <a href="https://www.facebook.com/share/1DsxG3er3o/" target="_blank">
        <i class="fab fa-facebook-f">
        </i>
      </a>
    </div>
  </div>
</body>
</html>