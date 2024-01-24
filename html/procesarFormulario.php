<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recaptcha_secret = '6LfOmVopAAAAAJsMC2QuAf6Krv_VMW3gG33x242R';
    $recaptcha_response = $_POST['g-recaptcha-response'];

    $recaptcha_url = "https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$recaptcha_response}";
    $recaptcha_data = json_decode(file_get_contents($recaptcha_url));

    if (!$recaptcha_data->success) {
        die('Captcha no válido');
    }

    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $fuente = $_POST['fuente'];
    $mensaje = $_POST['mensaje'];
    $empresa = $_POST['empresa'];
    $telefono = $_POST['telefono'];
    $servicio = $_POST['servicio'];

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'devzone.playeras@gmail.com'; 
        $mail->Password   = 'yxbe fhqt wklu mtkq ';
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
        echo '<script>alert("Mensaje enviado correctamente");</script>';
        echo '<script>setTimeout(function(){ window.location.href = "Contacto.html"; }, 10);</script>';
        // header('Location: Contacto.html');
        exit();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request method";
}
?>
