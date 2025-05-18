<?php
include '../conexion.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Si se ha enviado el formulario de cierre de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_unset();
    session_destroy();

    // Verifica si el usuario NO está ya en ../Inicio/indexUsuarios.php
    $currentPage = $_SERVER['PHP_SELF'];
    if (strpos($currentPage, 'indexUsuarios.php') === false) {
        header("Location: ../Inicio/indexUsuarios.php");
        exit;
    }
}

// Obtener imagen de perfil desde la base de datos
$imagenPerfil = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAABNUAAAEPCAYAAABlS/L8AADo/E...'; // Imagen por defecto

if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
    $stmt = $conn->prepare("SELECT foto FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($fotoBlob);
        $stmt->fetch();

        if (!empty($fotoBlob)) {
            // Detectar el tipo MIME de la imagen
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->buffer($fotoBlob);
            $imagenPerfil = 'data:' . $mime . ';base64,' . base64_encode($fotoBlob);
        }
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title data-translate>Buscar Noticia</title>
      <script src="../../auto-translate.js"></script>
  <link rel="stylesheet" href="PerfilCarda.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>

nav {
    position: fixed;
    z-index: 10;
    top: 0;
    left: 0;
    width: 100%;
    height: 60px;
    background-color: #007a;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 2%;
    font-family: Arial, Helvetica, sans-serif;
    box-sizing: border-box;
}

nav .logo {
    font-size: 24px;
    color: #ffffff;
    font-weight: bold;
}

nav .list {
    list-style: none;
    display: flex;
    gap: 20px;
}

nav .list li {
    list-style: none;
}

nav .list a {
    font-size: 16px;
    font-weight: bold;
    color: #ffffff;
    text-decoration: none;
    padding: 10px;
}

nav .list a:hover {
    border-bottom: 3px solid rgb(107, 193, 213);
}

#toggle {
    display: none;
}

nav .icon-bars {
    display: none;
    position: absolute;
    right: 5%;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
}

nav .icon-bars .line {
    width: 30px;
    height: 5px;
    background-color: #ffffff;
    border-radius: 3px;
    transition: all .3s ease-in-out;
}

nav .search-box {
    display: flex;
    align-items: center;
    background-color: white;
    border-radius: 20px;
    padding: 5px;
}

nav .search-box input {
    border: none;
    outline: none;
    padding: 5px;
    width: 150px;
    font-size: 14px;
}

nav .search-box button {
    border: none;
    background: none;
    cursor: pointer;
    font-size: 16px;
}

@media screen and (max-width: 768px) {
    nav .list {
        display: none;
        flex-direction: column;
        position: absolute;
        top: 60px;
        left: 0;
        width: 100%;
        background-color: #007a;
        padding: 10px 0;
    }

    nav .list a {
        padding: 15px;
        text-align: center;
    }

    nav .icon-bars {
        display: block;
    }

    nav input[type="checkbox"]:checked + .list {
        display: flex;
    }

    nav .search-box {
        width: 100%;
        margin-top: 10px;
    }

    nav .search-box input {
        width: 80%;
    }
}
/*Barra nav fin*/

.profile-modal {
  background: #7dd4ff;
  border-radius: 14px;
  box-shadow: 0 8px 32px rgba(0,0,0,0.18);
  width: 370px;
  max-width: 95vw;
  margin: 48px auto 0 auto;
  padding: 32px 28px 24px 28px;
  position: relative;
  text-align: center;
  animation: fadeIn 0.7s;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-30px);}
  to { opacity: 1; transform: translateY(0);}
}

.close-btn {
  position: absolute;
  top: 18px;
  right: 18px;
  background: none;
  border: none;
  font-size: 22px;
  color: #888;
  cursor: pointer;
  transition: color 0.2s;
}
.close-btn:hover {
  color: #62b6ff;
}

.profile-img-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-bottom: 12px;
}

.profile-img {
  width: 90px;
  height: 90px;
  border-radius: 50%;
  border: 3px solid #3c8dbc;
  object-fit: cover;
  background: #f0f0f0;
}

.profile-name {
  margin: 10px 0 2px 0;
  font-size: 1.6rem;
  font-weight: bold;
  color: #222;
  letter-spacing: 0.5px;
}

.profile-status {
  color: #7cb342;
  font-size: 1rem;
  margin-bottom: 18px;
}

.profile-tabs {
  display: flex;
  justify-content: center;
  margin-bottom: 18px;
  gap: 0;
}

.tab-btn {
  flex: 1;
  padding: 10px 0;
  border: none;
  background: #f3f3f3;
  color: #555;
  font-size: 1rem;
  font-weight: 500;
  cursor: pointer;
  border-radius: 0;
  border-bottom: 2px solid transparent;
  transition: background 0.2s, color 0.2s;
}
.tab-btn.active {
  background: #337ab7;
  color: #fff;
  border-bottom: 2px solid #337ab7;
}
.tab-btn i {
  margin-right: 6px;
}

.profile-details {
  text-align: left;
  margin: 0 0 24px 0;
  padding: 0 8px;
}

.profile-row {
  margin-bottom: 12px;
}

.profile-label {
  display: block;
  font-weight: 600;
  color: #148fc4;
  font-size: 0.98rem;
}

.profile-value {
  display: block;
  color: #222;
  font-size: 1.05rem;
  margin-top: 2px;
}

.close-main-btn {
  width: 100%;
  padding: 13px;
  background: #21a1b7;
  color: #fff;
  border: none;
  border-radius: 6px;
  font-size: 1.1rem;
  font-weight: bold;
  margin-top: 10px;
  cursor: pointer;
  transition: background 0.2s, transform 0.15s;
  box-shadow: 0 2px 8px rgba(60,140,188,0.10);
}
.close-main-btn:hover {
  background: #245d75;
  transform: scale(1.03);
}

body {
  font-family: Arial, sans-serif;
  margin: 0;
  background-color: #f9f9f9;
}
.contenido {
  max-width: 800px;
  padding: 30px;
  background: #fff;
  border-radius: 10px;
  margin: 40px auto;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}
h1 {
  font-size: 24px;
  margin-bottom: 20px;
  color: #333;
}
.modal-overlay {
  display: none;
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  justify-content: center;
  align-items: flex-start;
  padding-top: 50px;
}
  </style>
</head>
<body>
<!-- Barra de navegación -->
<nav>
  <div class="logo">Vital News</div>
  <ul class="list">
    <li><a href="../Inicio/indexUsuarios.php" data-translate data-force-en="Home">Inicio</a></li>
    <li>
            <button id="translateBtn" style="background-color: transparent; border: none; color: white; cursor: pointer; font: inherit;">
                <span data-translate>Idioma</span>
            </button>
        </li>
    <li><a href="../Categorias/Categorias.php" data-translate>Noticias</a></li>
    <li><a href="../Nosotros/nosotros.php" data-translate data-force-en="About Us">Nosotros</a></li>


    <?php if (isset($_SESSION['username'])): ?>
      <li><a href="#" id="perfil-btn" data-translate>Perfil</a></li>
      <li>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" style="display:inline;">
          <input type="hidden" name="logout" value="1">
          <button data-translate data-force-en="Log out" type="submit" style="background:none;border:none;color:white;cursor:pointer;    font-weight: bold;">
              Cerrar sesión
          </button>
        </form>
      </li>
    <?php else: ?>
      <li><a href="../iniciarSesion/iniciarSesion.html" data-translate>Iniciar sesión</a></li>
    <?php endif; ?>
  </ul>

  <div class="search-box">
    <form action="buscar.php" method="GET">
      <input type="text" name="query" placeholder="Buscar...">
      <button type="submit">🔍</button>
    </form>
  </div>
</nav>

<!-- Modal de perfil -->
<div class="modal-overlay" id="perfilModalOverlay">
  <div class="profile-modal">
    <button class="close-btn" onclick="cerrarPerfil()">
      <i class="fas fa-times"></i>
    </button>
    <form id="perfilForm" action="../BarraN/ActualizarPerfil.php" method="post" enctype="multipart/form-data" autocomplete="off">
      <div class="profile-img-wrapper" style="flex-direction: column; align-items: center;">
        <img class="profile-img" id="profileImg" src="<?php echo $imagenPerfil; ?>" alt="Foto de perfil" />
        <label data-translate for="imgInput" class="edit-img-btn" style="margin-top:12px; color:#148fc4; cursor:pointer;">
          <i class="fas fa-camera"></i> Cambiar imagen
        </label>
        <input type="file" id="imgInput" name="profile_image" accept="image/*" style="display:none" onchange="previewImg(event)">
      </div>

      <div class="profile-details">
        <div class="profile-row">
          <span class="profile-label" data-translate>Nombre de usuario</span>
          <input type="text" class="profile-value" id="username" name="username" value="<?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?>" required style="width:100%;margin-top:2px;">
        </div>
        <div class="profile-row">
          <span class="profile-label" data-translate>Correo Electronico</span>
          <input type="email" class="profile-value" id="email" name="email" value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>" required style="width:100%;margin-top:2px;">
        </div>
        <div class="profile-row">
          <span class="profile-label" data-translate >Nueva contraseña</span>
          <div style="position:relative; width:100%;">
            <input  type="password" class="profile-value" id="password" name="password" data-translate data-force-en="Leave blank to keep current" placeholder="Dejar en blanco para no cambiar"  minlength="10" pattern="^\S{10,}$" style="width:100%;margin-top:2px;padding-right:38px;box-sizing:border-box;">
            <i class="fas fa-eye toggle-password" onclick="togglePassword()" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer; color:#aaa; font-size:18px;"></i>
          </div>
          <small style="color:#148fc4;" data-translate>Mínimo 10 caracteres, sin espacios</small>
        </div>
      </div>

      <button type="submit" class="close-main-btn" data-translate>Guardar cambios</button>
    </form>
    <button class="close-main-btn" onclick="cerrarPerfil()" data-translate>Cerrar</button>
  </div>
</div>

<!-- Scripts -->
<script>
  document.getElementById('perfil-btn').addEventListener('click', function (e) {
    e.preventDefault();
    document.getElementById('perfilModalOverlay').style.display = 'flex';
  });

  function cerrarPerfil() {
    document.getElementById('perfilModalOverlay').style.display = 'none';
  }

  function previewImg(event) {
    const reader = new FileReader();
    reader.onload = function () {
      document.getElementById('profileImg').src = reader.result;
    };
    if (event.target.files[0]) {
      reader.readAsDataURL(event.target.files[0]);
    }
  }

  function togglePassword() {
    const passwordInput = document.getElementById("password");
    const icon = document.querySelector(".toggle-password");
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      icon.classList.remove("fa-eye");
      icon.classList.add("fa-eye-slash");
    } else {
      passwordInput.type = "password";
      icon.classList.remove("fa-eye-slash");
      icon.classList.add("fa-eye");
    }
  }
</script>
</body>
</html>
