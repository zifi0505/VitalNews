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
// echo "Connected successfully"; // Puedes descomentar esta línea para probar la conexión  
?>  