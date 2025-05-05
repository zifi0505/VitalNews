<?php  
ini_set('display_errors', 1);  
ini_set('display_startup_errors', 1);  
error_reporting(E_ALL);  

session_start();  
  
$servername = "localhost";  
$username = "root"; //nombre de usuario de bd  
$password = ""; //contraseña bd  
$dbname = "blogmain"; //nombre de la bd

// Crear conexión  
$conn = new mysqli($servername, $username, $password, $dbname);  

// Verificar la conexión  
if ($conn->connect_error) {  
    die("Connection failed: " . $conn->connect_error);  
}  

// Recibir datos del formulario (IMPORTANTE: Sanitizar y validar!)  
$username = $_POST["username"];  
$password = $_POST["password"];  

// ***  MUY IMPORTANTE:  Usar "prepared statements" para prevenir inyección SQL ***  
$sql = "SELECT id, username, password FROM usuarios WHERE username = ?";  
$stmt = $conn->prepare($sql);  
$stmt->bind_param("s", $username);  // "s" indica que $username es un string  
$stmt->execute();  
$result = $stmt->get_result();  

if ($result->num_rows == 1) {  
    $row = $result->fetch_assoc();  

    // Verificar la contraseña (contraseña hasheada en la base de datos)  
    if (password_verify($password, $row["password"])) {  
        
        // Puedes guardar información del usuario en la sesión:  
        $_SESSION["userid"] = $row["id"];  
        $_SESSION["username"] = $row["username"];  

        // Redirigir a la página de inicio
        header("Location: inicio.php"); 
        exit();  

    } else {  
        // Contraseña incorrecta  
        echo "Contraseña incorrecta.";  
    }  
} else {  
    // Usuario no encontrado  
    echo "Usuario no encontrado.";  
}  

$stmt->close(); // Cierra el prepared statement  
$conn->close(); // Cierra la conexión  
?>  