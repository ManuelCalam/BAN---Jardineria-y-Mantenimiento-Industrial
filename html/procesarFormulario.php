<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

ini_set('log_errors', 1);
ini_set('error_log', 'C:/xampp/htdocs/BAN---Jardineria-y-Mantenimiento-Industrial/Errores/error_log.txt');

require '../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recaptcha_secret = '6LfOmVopAAAAAJsMC2QuAf6Krv_VMW3gG33x242R';    
    $recaptcha_response = $_POST['g-recaptcha-response'];

    $recaptcha_url = "https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$recaptcha_response}";
    $recaptcha_data = json_decode(file_get_contents($recaptcha_url));

    if (!$recaptcha_data->success) {
        echo '<script>
            alert("Captcha no válido");
                window.onload = function() {
                    setTimeout(function() {
                    window.location.href = "Contacto.html";
                }, 0);
            };
        </script>';

        $captcha_error_info = json_encode($recaptcha_data);
        error_log("Error en el captcha: {$error_message}. Detalles: {$captcha_error_info}", 0);
        die($error_message);
    }

    $nombre = htmlspecialchars($_POST['nombre']);
    $correo = htmlspecialchars($_POST['correo']);
    $fuente = htmlspecialchars($_POST['fuente']);
    $mensaje = htmlspecialchars($_POST['mensaje']);
    $empresa = htmlspecialchars($_POST['empresa']);
    $telefono = htmlspecialchars($_POST['telefono']);
    $servicio = htmlspecialchars($_POST['servicio']);

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'devzone.playeras@gmail.com'; 
        $mail->Password   = 'yxbe fhqt wklu mtkq';       
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->addAddress('devzone.playeras@gmail.com', 'Noe Ibarra');     
        $mail->isHTML(true);
        $mail->Subject = 'Nuevo mensaje de contacto desde el formulario';
        $mail->Body    = "
            <p><strong>Nombre:</strong> $nombre</p>
            <p><strong>Correo electrónico:</strong> $correo</p>
            <p><strong>Cómo supo de nosotros:</strong> $fuente</p>
            <p><strong>Mensaje:</strong> $mensaje</p>
            <p><strong>Empresa:</strong> $empresa</p>
            <p><strong>Teléfono:</strong> $telefono</p>
            <p><strong>Servicio de interés:</strong> $servicio</p>
        ";

        $mail->send();

        echo '<script>alert("Tu mensaje ha sido enviado correctamente. Gracias por ponerte en contacto.");
                window.onload = function() {
                setTimeout(function() {
                window.location.href = "Contacto.html";
                }, 0);
            };
        </script>';

        exit();
    } catch (Exception $e) {

        echo '<script>
            alert("Hubo un problema al procesar tu solicitud. Por favor, contacta al soporte técnico en support@example.com para obtener ayuda.");
                window.onload = function() {
                    setTimeout(function() {
                    window.location.href = "Contacto.html";
                }, 0);
            };
        </script>';
        $smtp_error_info = $mail->ErrorInfo;

    error_log("Error al enviar el correo: {$smtp_error_info}", 0);
        die($error_message);
    }
} else {
    echo "Invalid request method";
}
?>
