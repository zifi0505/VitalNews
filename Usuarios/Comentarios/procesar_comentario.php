<?php
$servername = "localhost"; // Generalmente es "localhost" si la base de datos está en el mismo servidor  
$username = "root";       // Tu nombre de usuario de la base de datos  
$password = "";           // Tu contraseña de la base de datos (déjalo vacío si no tienes contraseña)  
$dbname = "vitalnews";     // El nombre de tu base de datos  

// Crear conexión  
$conn = new mysqli($servername, $username, $password, $dbname);  

// Verificar la conexión  
if ($conn->connect_error) {  
    die("Connection failed: " . $conn->connect_error);  
}  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_noticia = $_POST['id_noticia'];
    $nombre_usuario = $_POST['nombre_usuario'];
    $email_usuario = $_POST['email_usuario'];
    $comentario = $_POST['comentario'];

    $sql = "INSERT INTO comentarios (id_noticia, nombre_usuario, email_usuario, comentario, fecha_comentario)
            VALUES (?, ?, ?, ?, NOW())";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("isss", $id_noticia, $nombre_usuario, $email_usuario, $comentario);

    if ($stmt->execute()) {
        header("Location: ../noticia.php?id=$id_noticia");
        exit;
    } else {
        echo "Error al guardar el comentario: " . $conexion->error;
    }

    $stmt->close();
    $conexion->close();
}
?>
