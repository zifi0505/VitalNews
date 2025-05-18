<!DOCTYPE html>  
<html lang="es"> 
    
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title><?php  
        include("../conexion.php");

        // Obtener el ID de la noticia de la URL  
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {  
            $id_noticia = $_GET['id'];  

            // Consulta SQL para obtener el título de la noticia  
            $sql_titulo = "SELECT titulo FROM informacion WHERE id = $id_noticia";  
            $result_titulo = $conn->query($sql_titulo);  

            if ($result_titulo->num_rows == 1) {  
                $row_titulo = $result_titulo->fetch_assoc();  
                echo htmlspecialchars($row_titulo['titulo']);  
            } else {  
                echo "Noticia no encontrada";  
            }  
        } else {  
            echo "Noticias";  
        }  

        $conn->close();  
        ?></title>  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>  
        /* Estilos CSS para la página de detalles de la noticia */  
        body {  
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: url("fondo2.0.jpg");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        
        .container {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 15px;
            width: 80%;
            max-width: 800px;
            margin: 100px auto;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h1 {
            color: #333;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .content {
            line-height: 1.8;
            color: #555;
            text-align: justify;
            margin-top: 20px;
        }

        img {
            width: 100%;
            height: 100%;
            border-radius: 12px;
            margin: 30px 0;
        }

        .btn-regreso {
            display: inline-block;
            padding: 10px 20px;
            font-size: 1em;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s, transform 0.2s;
            margin-top: 20px;
        }

        .btn-regreso:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .footer {
            margin-top: auto;
            background: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        .footer-title {
            color: white;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .footer p{
            color: white;
        }

        .social-icons-container {
            margin-top: 10px;
        }

        .social-icons-container a {
            color: #fff;
            margin: 0 10px;
            text-decoration: none;
            font-size: 18px;
        }

.fondo {
    position: fixed;  /* Fondo fijo para que no se corte al hacer scroll */
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('../Imagenes/fondo.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    z-index: -1; /* Envía el fondo detrás del contenido */
}

    </style>  
</head>
 
<body> 
<?php include("../BarraN/barra_de_navegacion.php"); ?>
    <div class="fondo"></div> <!-- Fondo fijo -->
    
<div class="container">
    <?php
    include "../conexion.php";

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {  
        $id_noticia = $_GET['id'];  

        $sql = "SELECT titulo, cuerpo, fecha_publicacion, imagen, autor FROM informacion WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_noticia);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            echo "Noticia no encontrada.";
            exit;
        }

        $noticia = $result->fetch_assoc();

        $titulo = htmlspecialchars($noticia['titulo']);  
        $cuerpo = $noticia['cuerpo'];  
        $autor = htmlspecialchars($noticia['autor']);
        $fecha_publicacion = htmlspecialchars($noticia['fecha_publicacion']);  

        echo '<h1>' . $titulo . '</h1>'; 
        if (!empty($noticia['imagen'])) {
            echo '<img src="data:image/jpeg;base64,' . base64_encode($noticia['imagen']) . '" alt="' . $titulo . '">';  
        }
        echo '<div class="content">' . $cuerpo . '</div>'; 
        echo '<p><strong data-translate>Publicado el:</strong> ' . $fecha_publicacion . '</p>';  
        echo '<p><strong data-translate>Autor:</strong> ' . $autor . '</p>';
    } else {
        echo "ID de noticia no válido.";  
    } 

    $conn->close();
    ?>
</div>

<!-- Sección de comentarios -->

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
</body>
</html>