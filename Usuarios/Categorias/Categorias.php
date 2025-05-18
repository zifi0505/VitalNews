<?php
session_start(); // INICIA SESIÓN

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías de Salud</title>

    <style>
    * {  
    margin: 0;  
    padding: 0;  
    box-sizing: border-box;
    }  

    body {  
        overflow-y: auto;
        height: 100vh;
        position: relative;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f8f8;
    }

    .fondo {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('fondo.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        z-index: -1;
    }
    .fondo::after {
        content: "";
        position: absolute;
        width: 100%;
        height: 100%;
        background: inherit;
        filter: blur(50px);
        opacity: 1;
        mask-image: radial-gradient(circle, rgba(0, 0, 0, 0) 30%, rgba(0, 0, 0, 1) 80%);
        -webkit-mask-image: radial-gradient(circle, rgba(0, 0, 0, 0) 30%, rgba(0, 0, 0, 1) 80%);
    }

    .contenedor {
        position: relative;
        width: 100%;
        min-height: 100vh;
        padding-bottom: 50px; 
    }

    header {  
        text-align: center;  
        position: relative;
        background-image: url('Imagenes/fondoSuperior.jpg');
        background-size: cover;
        background-position: center;  
        background-repeat: no-repeat;
        height: 250px;  
        color: white;
        padding: 90px 0;
        z-index: 1;
    }

    header::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 50px;  
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.6) 100%);
        z-index: 0;
    }

    header h1 {
        font-family: 'Roboto', sans-serif;
        font-size: 3.5rem;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: white;
        text-shadow: 4px 4px 10px rgba(0, 0, 0, 0.8);
    }

    header h2 {
        font-family: 'Roboto', sans-serif;
        font-size: 1.8rem;
        font-weight: normal;
        margin-top: 10px;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.9);  
        text-shadow: 3px 3px 8px rgba(0, 0, 0, 0.6);  
    }

    .categories, .categories2, .noticias-categoria {  
        display: flex;  
        justify-content: center;  
        gap: 30px;
        margin: 20px;  
        flex-wrap: wrap;
    }  

    .category, .noticia-tarjeta {  
        margin: 10px;  
        text-align: center;  
        text-decoration: none;  
        color: #333;  
        transition: transform 0.2s, box-shadow 0.3s ease;  
    }  

    .category img, .noticia-tarjeta img {  
        width: 300px;  
        height: 250px;  
        border-radius: 8px;
        object-fit: cover;
        transition: box-shadow 0.3s ease;
    }

    .category:hover, .noticia-tarjeta:hover {  
        transform: scale(1.10);  
    }

    .category:hover img, .noticia-tarjeta:hover img {
        box-shadow:
        0 0 5px rgb(57, 57, 255),
        0 0 10px rgb(57, 57, 255),
        0 0 20px rgb(57, 57, 255),
        0 0 40px rgb(57, 57, 255),
        0 0 0px rgb(57, 57, 255); 
    }

    h3 {  
        margin-top: 10px;  
        font-family: 'Arial', sans-serif;  
        font-size: 1.5rem;  
        font-weight: bold;  
        text-transform: uppercase;  
        color: rgba(255, 255, 255, 0.85);  
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.4); 
        letter-spacing: 1px;  
        transition: color 0.3s ease;  
    }

    .category:hover h3, .noticia-tarjeta:hover h3 {
        text-shadow:
        0 0 5px rgb(57, 57, 255),
        0 0 10px rgb(57, 57, 255),
        0 0 20px rgb(57, 57, 255),
        0 0 40px rgb(57, 57, 255),
        0 0 80px rgb(57, 57, 255);  
    }

 
    .footer {
        text-align: center;
        padding: 20px;
        background: linear-gradient(to right, #333, #555);
        color: white;
        margin-top: 30px;
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
<?php
 include '../conexion.php'; include '../BarraN/barra_de_navegacion.php'; ?>
<div class="fondo"></div>

<div class="contenedor">
    <header>
        <h1 data-translate>CATEGORÍAS</h1>
        <h2 data-translate>Explora los diferentes temas</h2>
    </header>

    <main>
        <div class="categories">
            <?php
            $query = "SELECT nombre_categoria, imagen_categoria FROM Categorias WHERE archivado = 0";
            $resultado = $conn->query($query);

            if ($resultado && $resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    $nombre = htmlspecialchars($row['nombre_categoria']);
                    $imagen = base64_encode($row['imagen_categoria']);
                    echo '<a href="noticias_categoria.php?categoria=' . urlencode($nombre) . '" class="category">';
                    echo '<img src="data:image/jpeg;base64,' . $imagen . '" alt="' . $nombre . '">';
                    echo '<h3 data-translate>' . $nombre . '</h3>';
                    echo '</a>';
                }
            } else {
                echo '<p data-translate>No se encontraron categorías.</p>';
            }
            ?>
        </div>
    </main>
</div>

<div class="footer">
    <p class="footer-title">Vitals News</p>
    <p data-translate>Contáctanos</p>
    <div class="social-icons-container">
        <a href="https://mail.google.com/mail/?view=cm&fs=1&to=vitals.news.pi@gmail.com&su=Asunto&body=Cuerpo%20del%20mensaje" target="_blank">
            <i class="fas fa-envelope"></i>
        </a>
        <a href="https://www.facebook.com/share/1DsxG3er3o/" target="_blank">
            <i class="fab fa-facebook-f"></i>
        </a>
    </div>
</div>
</body>
</html>
