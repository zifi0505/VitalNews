<!DOCTYPE html>  
<html lang="es">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!--Responsiva-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> <!--Libreria para estilos en los iconos--> 
    <link rel="stylesheet" href="Nosotros.css">      
    <script src="../../auto-translate.js"></script>
    <title data-translate data-force-en="About Us">Sobre Nosotros</title>  
    <style>
        /* Pie de página */
         .footer {
             text-align: center;
             padding:10px;
             background: linear-gradient(to right, #333, #555555);
             color: white;
             margin-top: 150px;
             box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
             animation: fadeIn 1s ease-in-out;
             position: relative;
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
                 transform: translateY(0px);
             }
         }

         html, body {
    height: auto;
    min-height: 100vh;
    overflow-x: hidden;
    overflow-y: auto;
}

html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    width: 100%;
    box-sizing: border-box; /* <- Mejora el cálculo del ancho */
}


.text-section{
    margin-top: 75px;
}

body {
    background-image: url('nosotros.png');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
    background-attachment: fixed;
    font-family: Arial, sans-serif; /* Mejor presentación */
    overflow: auto;
}

.container {
    display: flex;
    justify-content: space-around;
    align-items: center;
    padding: 20px;
    position: relative;
    margin-top: 70px;
}

.text-section {
    width: 40%;
}

.about {
    background-color: #55a2f4; /* Morado */
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.about h2, .about p {
    color: #ffffff; /* Texto blanco */
}

.what-we-do {
    background-color: #212d5d; /* Naranja */
    padding: 20px;
    border-radius: 8px;
}

.what-we-do h3, .what-we-do p {
    color: #ffffff; /* Texto blanco */
}

.image-section {

    display: flex;
    align-items: center;
    justify-content: center;
}

.image-section img {
    width: 100%;
    height: auto;
    max-height: 400px;
    border-radius: 8px;
    display: block;
}



     </style>

    <title data-translate data-force-en="About Us">Sobre Nosotros</title>  
</head>  

<?php include '../BarraN/barra_de_navegacion.php'; ?>

<body>  

    <div class="container">  
        <div class="text-section">  
            <div class="about">  
                <h2 data-translate data-force-en="About us!">¡Sobre nosotros!</h2>  
                <p data-translate>
                    Carrillo Barajas Victor Manuel: Programador, Diseñador y Gestor de Documentos.<br>
                    Guzman Kristofer Guzman Kristhoper Alexander: Programador y Diseñador.<br>
                    Mei Chen Zifei: Programador y Diseñador<br>
                    Parra Garzón Miguel Arturo: Programador y Diseñador.
                </p>  
            </div>  
            <div class="what-we-do">  
                <h3 data-translate data-force-en="What do we do?">¿Qué hacemos?</h3>  
                <p data-translate data-force-en="On our blog we gather health and wellness news from various reliable sources, organizing them clearly and intuitively. Our goal is to make finding relevant information for your well-being quick, simple, and accessible, helping you stay informed and take care of your health every day.">
                    En nuestro blog reunimos noticias sobre salud y bienestar de distintas fuentes confiables, organizándolos de forma clara e intuitiva. Nuestro objetivo es hacer que encontrar información relevante para tu bienestar sea rápido, sencillo y accesible, ayudándote a mantenerte informado y cuidar de tu salud día a día.
                </p>  
            </div>  
        </div>  
        <div class="image-section">  
            <img src="../Imagenes/Logo.png" alt="Vital News">  
        </div>  
    </div>  
    <!--Pie inicio-->
<div class="footer">
    <p class="footer-title" data-translate data-force-en="Vitals News">Vitals News</p>
    <p data-translate data-force-en="Contact us">Contactanos</p>
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

    <!--Pie fin-->
</body>  
</html>  