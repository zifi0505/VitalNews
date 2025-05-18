<!DOCTYPE html>  
<html lang="es"> 
    
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
  <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title><?php  
    session_start(); // INICIA SESIÓN

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
        include '../conexion.php';  

        // Obtener el ID de la noticia de la URL  
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {  
            $id_noticia = $_GET['id'];  

            // Consulta SQL para obtener el título fg la noticia  
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
    <style>  
        body {  
            font-family: 'Roboto', sans-serif;  
            margin: 0%;
            padding: 0;  
            background-color: #f4f4f4;  
            color: #333;  
        }
        h1 {  
            color: #0056b3;  
        }  
    .container {  
            width: 60%;
            margin: 40px auto;  
            background-color: #fff;  
            padding: 20px;  
            border-radius: 8px;  
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);  
            text-align: center; /* Centrar contenido dentro del contenedor */
        }  

    .title{
        text-align: center;
    }

    .content {  
        line-height: 2;  
        max-width: 900px;  
        display: flex;  
        justify-content: center;  
        text-align: center; /* Centra el texto */
        margin: auto; /* Centra el bloque en la página */
        flex-direction: column; /* Organiza el texto en columna */
    }  

    img {  
        max-width: 70%;  
        height: auto;  
        border-radius: 8px;  
        margin-bottom: 20px;  
        display: block;
        margin-left: auto;  
        margin-right: auto; 
    }

    .AutorYFecha {
        font-weight: bold;
        margin: 10px;
        text-align: left;
    }

    .bg {  
        text-align: center;  
        position: relative;
        background-image: url('fondoSuperior.jpg');
        background-size: cover;
        background-position: center;  
        background-repeat: no-repeat;
        height: 250px;  
        color: white;
        padding: 90px 0;
        z-index: 1;
    }       
            /* Pie de página */
      

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
         
    </style>  
</head>
<body>

     <?php include '../BarraN/barra_de_navegacion.php'; ?>

    <div class="fondo"></div>
    <div class="container">
            <?php
            include '../conexion.php'; // Incluye el archivo de conexión  

            // Obtener el ID de la noticia de la URL  
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {  
                $id_noticia = $_GET['id'];  

                // Consulta SQL para obtener todos los detalles de la noticia  
                $sql = "SELECT titulo, cuerpo, fecha_publicacion, Imagen, autor FROM informacion WHERE id = $id_noticia";  
                $result = $conn->query($sql);  

                if ($result->num_rows == 1) {  
                    $row = $result->fetch_assoc();  
                    $titulo = htmlspecialchars($row['titulo']);  
                    $cuerpo = $row['cuerpo'];  
                    $autor = htmlspecialchars($row['autor']);
                    $fecha_publicacion = htmlspecialchars($row['fecha_publicacion']);  

                    // Obtener la ruta de la imagen desde la tabla 'imagenes'  
                    $imagen_id = $row["Imagen"];  
                    $sql_imagen = "SELECT Imagen FROM informacion";  
                    $result_imagen = $conn->query($sql_imagen);  

                    $blobData = $row["Imagen"];
                    $base64 = base64_encode($blobData);
                    $imagenSrc = "data:image/jpeg;base64," . $base64;

                    echo '<br><br><h1>' . $titulo . '</h1><br><br>'; 
                    echo '<img src="' . $imagenSrc . '" alt="' . $titulo . '" ';
 
                    echo '<br><br><br><br> ';
                    echo '<div class="content">' . $cuerpo . '</div>'; 
                    echo '<br><br>';
                    echo '<p class="AutorYFecha" data-translate>Publicado el: ' . $fecha_publicacion . '</p><br>';  
                    echo '<p class="AutorYFecha" data-translate>Autor de la publicacion: ' . $autor . '</p>';
                } else {
                    echo "Noticia no encontrada.";
                }
            } else {
                echo "ID de noticia no válido.";  
            } 

            $conn->close(); // Cierra la conexión  

            
            ?>
        </div>
    </div>

    <?php include '../Comentarios/PublicC.php'; ?>

    <div class="footer">
    <p class="footer-title">Vitals News</p>
    <p data-translate>Contactanos</p>
    <div class="social-icons-container">
        <!-- Ícono para Gmail -->
        <a href="https://mail.google.com/mail/?view=cm&fs=1&to=vitals.news.pi@gmail.com&su=Asunto&body=Cuerpo%20del%20mensaje" target="_blank">
            <i class="fas fa-envelope"></i>
        </a>
        
        <!-- Ícono para Facebook -->
        <a href="https://www.facebook.com/share/1DsxG3er3o/" target="_blank">
            <i class="fab fa-facebook-f"></i>
        </a>
    </div>
    </div>
    
</body>
</html>