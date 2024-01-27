<?php


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

    

    

        // echo '<script>alert("Tu mensaje ha sido enviado correctamente. Gracias por ponerte en contacto.");
        //         window.onload = function() {
        //         setTimeout(function() {
        //         window.location.href = "Contacto.html";
        //         }, 0);
        //     };
        // </script>';

} else {
    echo "Invalid request method";
}
?>
