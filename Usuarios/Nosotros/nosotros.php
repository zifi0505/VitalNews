<!DOCTYPE html>  
<html lang="es">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!--Responsiva-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> <!--Libreria para estilos en los iconos--> 
    <link rel="stylesheet" href="Nosotros.css"> 

     

    <style>
        /* Pie de página */
         .footer {
             text-align: center;
             padding: 20px;
             background: linear-gradient(to right, #333, #555555);
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

    <title data-translate>Sobre Nosotros</title>  
</head>  
<body>  
<!-- Barra de navegación inicio-->
 <?php include '../BarraN/barra_de_navegacion.php'; ?>
<div class="fondo"></div>

<!--Barra nav fin-->

    <div class="container">  
        <div class="text-section">  
            <div class="about">  
                <h2 data-translate>¡Sobre nosotros!</h2>  
                <p data-translate>Carrillo Barajas Victor Manuel: Programador, Diseñador y Gestor de Documentos.<br>Guzman Kristofer Guzman Kristhoper Alexander: Programador y Diseñador.<br>Mei Chen Zifei: Programador y Diseñador<br>Parra Garzón Miguel Arturo: Programador y Diseñador.</p>  
            </div>  
            <div class="what-we-do">  
                <h3 data-translate>¿Qué hacemos?</h3>  
                <p data-translate>En nuestro blog reunimos noticias sobre salud y bienestar de distintas fuentes confiables, organizándolos de forma clara e intuitiva. Nuestro objetivo es hacer que encontrar información relevante para tu bienestar sea rápido, sencillo y accesible, ayudándote a mantenerte informado y cuidar de tu salud día a día.</p>  
            </div>  
        </div>  
        <div class="image-section">  
            <img src="Logo.png" alt="Vital News">  
        </div>  
    </div>  
    <!--Pie inicio-->
    <div class="footer">
        <p class="footer-title">Vitals News</p>
        <p data-translate>Contactanos</p>
        <div class="social-icons-container">
            <a href="https://mail.google.com/mail/?view=cm&fs=1&to=vitals.news.pi@gmail.com&su=Asunto&body=Cuerpo%20del%20mensaje" target="_blank">
                <i class="fas fa-envelope"></i>
            </a>
            <a href="https://www.facebook.com/share/1DsxG3er3o/" target="_blank">
                <i class="fab fa-facebook-f"></i>
            </a>
        </div>
    </div>
    <!--Pie fin-->
</body>  
</html>  