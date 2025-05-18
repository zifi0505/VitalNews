<?php
session_start(); // INICIA SESIÓN

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../conexion.php';

// DEBUG opcional: mostrar la sesión activa
// echo '<pre>'; print_r($_SESSION); echo '</pre>';

$sql_carrusel = "SELECT id, titulo, Imagen FROM informacion ORDER BY fecha_publicacion DESC LIMIT 5";
$resultado_carrusel = $conn->query($sql_carrusel);

$noticias_carrusel = [];
if ($resultado_carrusel && $resultado_carrusel->num_rows > 0) {
    while ($row = $resultado_carrusel->fetch_assoc()) {
        $noticias_carrusel[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Vital's News</title>

  <link rel="stylesheet" href="styleUsers.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

 <style>

    .contenedor h1 {
      margin: 0;
      padding: 10px 0;
      font-family: 'Roboto', sans-serif;
      font-size: 28px;
      color: #333;
      max-height: 10%;
    }



    .titulo {  
        background: url("../fondo.jpg") center/cover no-repeat;  
        color: white;  
        text-align: center;  
        padding: 120px 20px;  
    }  


    .titulo-content {
      margin: 0;
      padding: 0;
    }

    .hero-carousel {
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
      position: relative;
      overflow: hidden;
      border-radius: 32px;
      box-shadow: 0 12px 40px rgba(0, 0, 0, 0.25);
      
      
    }

    .hc-track {
      display: flex;
      transition: transform 0.6s ease-in-out;
    }

    .hc-slide {
      flex: 0 0 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
    }

    .hc-slide img {
      width: 100%;
      height: 600px;
      object-fit: cover;
      border-radius: 32px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
      transition: transform 0.5s ease-in-out;
    }

    .hc-slide img:hover {
      transform: scale(1.03);
    }

    .hc-caption {
      position: absolute;
      bottom: 40px;
      left: 50%;
      transform: translateX(-50%);
      background: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(6px);
      padding: 16px 32px;
      border-radius: 16px;
      color: #fff;
      font-size: 28px;
      font-weight: bold;
      font-family: 'Roboto', sans-serif;
      text-align: center;
      text-shadow: 0px 2px 5px rgba(0,0,0,0.8);
      max-width: 80%;
    }

    .carousel-indicators {
      position: absolute;
      bottom: 20px;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      gap: 12px;
      z-index: 20;
    }

    .carousel-indicators .dot {
      width: 14px;
      height: 14px;
      background-color: rgba(255, 255, 255, 0.6);
      border-radius: 50%;
      cursor: pointer;
      transition: background-color 0.3s, transform 0.3s;
    }

    .carousel-indicators .dot.active {
      background-color: #007bff;
      transform: scale(1.3);
    }

    .carousel-button {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(0, 0, 0, 0.4);
      color: white;
      border: none;
      padding: 12px 16px;
      cursor: pointer;
      z-index: 10;
      border-radius: 50%;
      font-size: 20px;
      transition: background 0.3s;
    }

    .carousel-button:hover {
      background: rgba(0, 0, 0, 0.7);
    }

    .carousel-button.left {
      left: 20px;
    }

    .carousel-button.right {
      right: 20px;
    }

    .footer {
      text-align: center;
      padding: 20px;
      background: linear-gradient(to right, #333, #555);
      color: white;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
      animation: fadeIn 1s ease-in-out;
      position: relative;
    }

         .footer-title {
             font-size: 24px;
             font-weight: bold;
             margin-bottom: 10px;
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
             color: #00aced; /* Color corporativo hover */
             transform: scale(1.05);
         }

         .social-icons-container {
             display: flex;
             justify-content: center; /* Asegura que los iconos estén centrados */
             align-items: center; /* Centra los iconos verticalmente */
             gap: 10px; /* Espaciado entre los íconos */
             margin-top: 10px;
             width: 100%; /* Asegura que ocupe todo el ancho disponible */
         }

         /* Estilo para los iconos */
         .social-icons-container a {
             display: inline-flex;
             align-items: center;
             justify-content: center;
             width: 40px;
             height: 40px;
             background-color: #555; /* Fondo de los íconos */
             color: white;
             border-radius: 50%;
             text-decoration: none;
             transition: background-color 0.3s, transform 0.3s;
         }

         .social-icons-container a:hover {
             background-color: #007BFF; /* Color de fondo al pasar el mouse */
             transform: scale(1.1);
         }

         .social-icons-container i {
             font-size: 20px; /* Tamaño del ícono */
         }

         /* Animación de entrada */
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
    

.cabecera-categorias {
  position: relative;
  width: 100%;
  height: 300px;
  background-image: url('fondoSuperior.jpg');
  background-size: cover;
  background-position: center;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
}

.cabecera-contenido h1 {
  font-size: 60px;
  font-weight: bold;
  color: #fff;
  text-shadow: 0px 3px 6px rgba(0, 0, 0, 0.7);
  margin: 0;
  text-transform: uppercase;
}

.cabecera-contenido h2 {
  font-size: 30px;
  color: #fff;
  text-shadow: 0px 2px 5px rgba(0, 0, 0, 0.6);
  margin-top: 10px;
  text-transform: uppercase;
  font-weight: normal;
}

.bienvenido {
  position: fixed; 
  top: 10px; 
  right: 1150px; 
  z-index: 1000;
  background-color: rgba(0,0,0,0.7); 
  color: white; 
  padding: 10px 15px; 
  border-radius: 10px; 
  font-family: 'Roboto', sans-serif;
}

  </style>

</head>
<body>

<?php include '../BarraN/barra_de_navegacion.php'; ?>

<?php if (isset($_SESSION['username'])): ?>
  <div class="bienvenido">
    Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>
  </div>
<?php endif; ?>

<div class="cabecera-categorias">
  <div class="cabecera-contenido">
    <h1 data-translate>Recientes</h1>
    <h2 data-translate data-force-en="BREAKING NEWS">Noticias última hora</h2>
  </div>
</div>

<!-- Carrusel -->
<header class="titulo">  
  <div class="titulo-content">  
    <div class="hero-carousel" id="carousel">
      <div class="hc-track" id="carousel-track">
        <?php foreach ($noticias_carrusel as $noticia):
          $base64 = base64_encode($noticia['Imagen']);
          $imgSrc = "data:image/jpeg;base64,$base64";
          $titulo = htmlspecialchars($noticia['titulo']); ?>
        <div class="hc-slide">
          <a href="../Noticia/noticia.php?id=<?php echo $noticia['id']; ?>">
            <img src="<?php echo $imgSrc; ?>" alt="<?php echo $titulo; ?>">
            <div class="hc-caption"><?php echo $titulo; ?></div>
          </a>
        </div>
        <?php endforeach; ?>
      </div>
      <div class="carousel-indicators" id="carousel-indicators"></div>
    </div>
  </div>
</header>

<!-- Footer -->
<div class="footer">
  <p class="footer-title">Vitals News</p>
  <p data-translate>Contáctanos</p>
  <div class="social-icons-container">
          <a href="https://mail.google.com/mail/?view=cm&fs=1&to=vitals.news.pi@gmail.com&su=Asunto&body=Cuerpo%20del%20mensaje" target="_blank">
      <i class="fas fa-envelope">
      </i>
    </a>
    <a href="https://www.facebook.com/share/1DsxG3er3o/" target="_blank"><i class="fab fa-facebook-f"></i></a>
  </div>
</div>

<!-- JS del Carrusel (igual que antes) -->
  <script>
    const carousel = document.getElementById('carousel');
    const track = document.getElementById('carousel-track');
    let slides = Array.from(track.children);

    const firstClone = slides[0].cloneNode(true);
    const lastClone = slides[slides.length - 1].cloneNode(true);
    track.appendChild(firstClone);
    track.insertBefore(lastClone, slides[0]);

    slides = Array.from(track.children);
    let index = 1;
    const slideWidth = slides[0].offsetWidth;
    track.style.transform = `translateX(-${slideWidth * index}px)`;

    function moveToIndex(i) {
      track.style.transition = "transform 0.6s ease-in-out";
      track.style.transform = `translateX(-${slideWidth * i}px)`;
    }

    function nextSlide() {
      if (index >= slides.length - 1) return;
      index++;
      moveToIndex(index);
    }

    function prevSlide() {
      if (index <= 0) return;
      index--;
      moveToIndex(index);
    }

    track.addEventListener("transitionend", () => {
      if (index === slides.length - 1) {
        track.style.transition = "none";
        index = 1;
        track.style.transform = `translateX(-${slideWidth * index}px)`;
      }
      if (index === 0) {
        track.style.transition = "none";
        index = slides.length - 2;
        track.style.transform = `translateX(-${slideWidth * index}px)`;
      }
      updateDots();
    });

    let autoScroll = setInterval(nextSlide, 7000);

    function resetAutoScroll() {
      clearInterval(autoScroll);
      autoScroll = setInterval(nextSlide, 7000);
    }

    carousel.addEventListener('mouseenter', () => clearInterval(autoScroll));
    carousel.addEventListener('mouseleave', () => resetAutoScroll());

    carousel.addEventListener('wheel', (e) => {
      e.preventDefault();
      if (e.deltaY > 0) nextSlide();
      else prevSlide();
      resetAutoScroll();
    });

    const indicatorsContainer = document.getElementById('carousel-indicators');
    const realSlideCount = slides.length - 2;

    for (let i = 0; i < realSlideCount; i++) {
      const dot = document.createElement('div');
      dot.classList.add('dot');
      if (i === 0) dot.classList.add('active');
      dot.addEventListener('click', () => {
        index = i + 1;
        moveToIndex(index);
        updateDots();
        resetAutoScroll();
      });
      indicatorsContainer.appendChild(dot);
    }

    function updateDots() {
      const dots = indicatorsContainer.querySelectorAll('.dot');
      dots.forEach(dot => dot.classList.remove('active'));
      let visibleIndex = index - 1;
      if (visibleIndex < 0) visibleIndex = realSlideCount - 1;
      if (visibleIndex >= realSlideCount) visibleIndex = 0;
      dots[visibleIndex].classList.add('active');
    }
  </script>
</body>
</html>
