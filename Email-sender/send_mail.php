<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Asegúrate de que la ruta sea correcta

// Configuración del servidor SMTP
$smtp_server = 'smtp.gmail.com';
$smtp_port = 587;
$email_sender = 'gabrielbwebdev@gmail.com';
$email_password = 'uwlz fxif yawa eybf'; // Usa la contraseña de aplicación generada

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica si el archivo fue subido correctamente
    if (isset($_FILES['csvfile']) && $_FILES['csvfile']['error'] == 0) {
        // Obtiene el nombre del archivo y su ubicación temporal
        $csvFile = $_FILES['csvfile']['tmp_name'];

        // Abre el archivo CSV para lectura
        if (($handle = fopen($csvFile, 'r')) !== FALSE) {
            // Leer la cabecera del CSV (opcional)
            $header = fgetcsv($handle, 1000, ',');

            // Procesar cada línea del archivo
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                // Asegúrate de que los datos estén en UTF-8
                $nombre = utf8_encode($data[0]);
                $apellido = utf8_encode($data[1]);
                $email_recipient = $data[2];

                // Crear una instancia de PHPMailer
                $mail = new PHPMailer(true);

                try {
                    // Configurar PHPMailer para usar SMTP
                    $mail->isSMTP();
                    $mail->Host = $smtp_server;
                    $mail->SMTPAuth = true;
                    $mail->Username = $email_sender;
                    $mail->Password = $email_password;
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = $smtp_port;
                    
                    // Configurar PHPMailer para usar UTF-8
                    $mail->CharSet = 'UTF-8';

                    // Destinatario
                    $mail->setFrom($email_sender, 'Gabriel Bustos');
                    $mail->addAddress($email_recipient, "$nombre $apellido");

                    // Contenido del correo
                    $mail->isHTML(true);
                    $mail->Subject = 'Prueba de envío de correo'; // El asunto debe estar en UTF-8
                    $mail->Body = "Hola $nombre $apellido,<br><br>Esto es una prueba."; // El cuerpo del correo debe estar en UTF-8

                    // Enviar el correo
                    $mail->send();
                    echo "Correo enviado a $nombre $apellido ($email_recipient)<br>";
                } catch (Exception $e) {
                    echo "Error al enviar correo a $nombre $apellido ($email_recipient): {$mail->ErrorInfo}<br>";
                }
            }
            fclose($handle);
        } else {
            echo "Error al abrir el archivo CSV.";
        }
    } else {
        echo "Error al subir el archivo CSV.";
    }
} else {
    echo "Método de solicitud no válido.";
}

?>
