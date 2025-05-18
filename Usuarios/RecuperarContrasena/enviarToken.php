<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';
require __DIR__ . '/PHPMailer/src/Exception.php';

session_start();

if (isset($_POST['correo'])) {
    $correoDestino = $_POST['correo'];
    $token = bin2hex(random_bytes(16));
    $expira = date("Y-m-d H:i:s", strtotime("+1 hour"));

    // Conexión a la base de datos
    $conexion = new mysqli("localhost", "root", "", "vitalnews");
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Guarda el token y expiración en la base de datos
    $stmt = $conexion->prepare("UPDATE usuarios SET password_reset_token=?, password_reset_expires=? WHERE email=?");
    $stmt->bind_param("sss", $token, $expira, $correoDestino);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = 0; // No mostrar mensajes de debug
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'vitals.news.pi@gmail.com';
            $mail->Password   = 'srqthrreggudhqzt';
            $mail->SMTPSecure = defined('PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS') ? PHPMailer::ENCRYPTION_STARTTLS : 'tls';
            $mail->Port       = 587;

            $mail->setFrom('vitals.news.pi@gmail.com', 'VitalNews');
            $mail->addAddress($correoDestino);

            $enlace = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/cambiarContrasena.html?token=$token";
            $mail->isHTML(true);
            $mail->Subject = 'Recuperación de contraseña - VitalNews';
            $mail->Body    = "<p>Hola,</p><p>Haz clic en el siguiente enlace para cambiar tu contraseña:</p>
                              <p><a href='$enlace'>$enlace</a></p>
                              <p>Este enlace expirará en 1 hora.</p>";

            $mail->send();
            header("Location: recuperarContrasena.html?success=1");
            exit();
        } catch (Exception $e) {
            header("Location: recuperarContrasena.html?error=1");
            exit();
        }
    } else {
        header("Location: recuperarContrasena.html?error=1");
        exit();
    }
    $stmt->close();
    $conexion->close();
} else {
    echo "No se recibió un correo.";
}
?>
