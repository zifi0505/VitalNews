<?php
session_start();

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "vitalnewsbaseadaptada");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Procesar comentario solo si el usuario ha iniciado sesión
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['comentario']) && isset($_SESSION['id'])) {
    $id_usuario = $_SESSION['id'];
    $comentario = $conexion->real_escape_string($_POST['comentario']);
    $id_noticia = isset($_POST['id_noticia']) ? intval($_POST['id_noticia']) : 1;

    // Obtener nombre de usuario
    $resultado = $conexion->query("SELECT username FROM usuarios WHERE id = $id_usuario");
    $usuario = $resultado->fetch_assoc();
    $nombre_usuario = $usuario['username'];

    // Insertar comentario
    $conexion->query("INSERT INTO comentarios (id_noticia, nombre_usuario, comentario, fecha_comentario)
                      VALUES ($id_noticia, '$nombre_usuario', '$comentario', NOW())");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Comentarios</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
      background-color: #f2f2f2;
    }
    h2 {
      color: #333;
    }
    .comentario-box {
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 10px;
      margin-bottom: 15px;
      background: #fff;
      display: flex;
      align-items: center;
    }
    .comentario-box img {
      width: 50px;
      height: 50px;
      object-fit: cover;
      border-radius: 50%;
      margin-right: 10px;
    }
    .comentario-box .texto {
      max-width: 600px;
    }
    textarea {
      width: 100%;
      max-width: 600px;
      padding: 10px;
      margin-bottom: 10px;
    }
    button {
      padding: 8px 16px;
      background-color: #2e86de;
      border: none;
      color: white;
      border-radius: 5px;
      cursor: pointer;
    }
    button:hover {
      background-color: #1b4f72;
    }
    .aviso {
      background-color: #ffdddd;
      border-left: 5px solid #f44336;
      padding: 10px;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>

  <h2>Comentarios</h2>

  <!-- Formulario solo si hay sesión -->
  <?php if (isset($_SESSION['id'])): ?>
    <form method="POST" action="comentarios.php">
      <input type="hidden" name="id_noticia" value="1" />
      <textarea name="comentario" rows="3" placeholder="Escribe tu comentario..." required></textarea><br>
      <button type="submit">Enviar comentario</button>
    </form>
  <?php else: ?>
    <div class="aviso">
      <strong>Inicia sesión para comentar.</strong>
    </div>
    <a href="iniciarSesion.php">Ir a la página de inicio de sesión</a>
  <?php endif; ?>

  <hr>

  <!-- Mostrar comentarios -->
  <?php
  $id_noticia = 1; // ID de la noticia actual (puedes cambiar dinámicamente)
  $resultado = $conexion->query("SELECT * FROM comentarios WHERE id_noticia = $id_noticia ORDER BY fecha_comentario DESC");

  while ($comentario = $resultado->fetch_assoc()):
      $nombre = $comentario['nombre_usuario'];

      // Obtener imagen de perfil del usuario
      $queryUsuario = $conexion->query("SELECT fotoPerfil FROM usuarios WHERE username = '$nombre' LIMIT 1");
      $imagen = $queryUsuario->fetch_assoc();

      $foto = ($imagen && $imagen['fotoPerfil']) 
              ? 'data:image/jpeg;base64,' . base64_encode($imagen['fotoPerfil'])
              : 'https://via.placeholder.com/50';
  ?>
    <div class="comentario-box">
      <img src="<?= $foto ?>" alt="Foto de perfil">
      <div class="texto">
        <strong><?= htmlspecialchars($nombre) ?></strong><br>
        <?= htmlspecialchars($comentario['comentario']) ?><br>
        <small><?= $comentario['fecha_comentario'] ?></small>
      </div>
    </div>
  <?php endwhile; ?>

</body>
</html>
