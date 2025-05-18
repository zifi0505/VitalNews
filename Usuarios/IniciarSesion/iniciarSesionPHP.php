<?php  
ini_set('display_errors', 1);  
ini_set('display_startup_errors', 1);  
error_reporting(E_ALL);  

session_start();  

$servername = "localhost";  
$usernameDB = "root";  
$passwordDB = "";  
$dbname = "vitalnews";  

$conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);  
if ($conn->connect_error) {  
    die("Error de conexión: " . $conn->connect_error);  
}  

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["username"], $_POST["password"])) {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    
    // Agregamos el campo admin a la consulta
    $sql = "SELECT id, username, email, password, fotoperfil, admin FROM usuarios WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();  
    $result = $stmt->get_result();  

    if ($result->num_rows === 1) {  
        $row = $result->fetch_assoc();  

        if (password_verify($password, $row["password"])) {  
            $_SESSION["userid"] = $row["id"];  
            $_SESSION["username"] = $row["username"];  
            $_SESSION["email"] = $row["email"];  
            $_SESSION["fotoperfil"] = $row["fotoperfil"]; // ✅ AÑADIDO

            // Redirección según si es admin o no
            if (isset($row["admin"]) && (int)$row["admin"] === 1) {
                header("Location: ../../Admin/Inicio/index2.php");  // Redirección si es admin
            } else {
                header("Location: ../Inicio/indexUsuarios.php?success=1");  // Redirección si NO es admin
            }
            exit();  
        } else {
            header("Location: iniciarSesion.html?error=contrasena");  
            exit();  
        }
    } else {
        header("Location: iniciarSesion.html?error=usuario");  
        exit();  
    }

    $stmt->close();
} else {
    header("Location: iniciarSesion.html?error=datos");
    exit();
}

$conn->close();  
?>