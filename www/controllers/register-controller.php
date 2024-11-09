<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');

include('../models/dbConnection.php');
include('../querys/querys.php');
require '../phpMailer/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validar y obtener los datos del formulario
    $name_player = ucfirst(trim($_POST['name_player']));
    $lastname_player = ucfirst(trim($_POST['lastname_player']));
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    
    if (isset($_POST['password']) && !empty($_POST['password'])) {
        $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    } else {
        die("La contraseña es requerida.");
    }

    $registration_date = date('Y-m-d H:i:s'); 

    // Validación: Verificar si el username ya existe
    $stmt_username = $conn->prepare(SQL_COUNT_USERNAMES);
    $stmt_username->bind_param("s", $username);
    $stmt_username->execute();
    $stmt_username->bind_result($username_count);
    $stmt_username->fetch();
    $stmt_username->close();

    if ($username_count > 0) {
        die("El username '$username' ya está en uso. Por favor, elige otro.");
    }

    // Validación: Verificar si el email ya está registrado
    $stmt_email = $conn->prepare(SQL_COUNT_EMAILS);
    $stmt_email->bind_param("s", $email);
    $stmt_email->execute();
    $stmt_email->bind_result($email_count);
    $stmt_email->fetch();
    $stmt_email->close();

    if ($email_count > 0) {
        die("El email '$email' ya fue registrado. Por favor, utiliza otro.");
    }


    
    $stmt = $conn->prepare(SQL_INSERT_PLAYER);
    
    if ($stmt === false) {
        die('Error en la preparación de la declaración: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("ssssss", $name_player, $lastname_player, $username, $email, $password, $registration_date);

    if ($stmt->execute()) {
        // Enviar correo de bienvenida
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();                                            
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'escaperoomgba@gmail.com';
            $mail->Password = 'ouks cuuf szuu jmwx'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
            $mail->Port = 587;

            $mail->setFrom('escaperoomgba@gmail.com', 'Escape Room'); 
            $mail->addAddress($email, "$name_player $lastname_player"); 

            $mail->isHTML(true);
            $mail->Subject = 'Bienvenido a EscapeRoom';
            $mail->Body = "
                            <!DOCTYPE html>
                            <html lang='es'>
                            <head>
                                <meta charset='UTF-8'>
                                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                                <title>EscapeRoom</title>
                                <style>
                                    body { 
                                        font-family: Arial, sans-serif; 
                                        background-color: #f4f4f4; 
                                        margin: 0; 
                                        padding: 20px; 
                                    }
                                    .container { 
                                        max-width: 600px; 
                                        margin: auto; 
                                        background: white; 
                                        padding: 30px; 
                                        border-radius: 10px; 
                                        box-shadow: 0 2px 15px rgba(0,0,0,0.1); 
                                    }
                                    h1 { 
                                        color: #333; 
                                        font-size: 24px; 
                                        text-align: center; 
                                        margin-bottom: 20px; 
                                    }
                                    p { 
                                        color: #555; 
                                        line-height: 1.6; 
                                        margin-bottom: 15px; 
                                    }
                                    .highlight { 
                                        color: #d9a700; 
                                    } 
                                    .footer { 
                                        margin-top: 30px; 
                                        font-size: 14px; 
                                        color: #888; 
                                        border-top: 1px solid #eaeaea; 
                                        padding-top: 20px; 
                                    }
                                    .button { 
                                        display: inline-block; 
                                        background-color: #d9a700; 
                                        color: white; 
                                        padding: 10px 20px; 
                                        border-radius: 5px; 
                                        text-decoration: none; 
                                        font-weight: bold; 
                                        margin-top: 20px; 
                                        transition: background-color 0.3s; 
                                    }
                                    .button:hover { 
                                        background-color: #c69a00; 
                                    }
                                </style>
                            </head>
                            <body>
                                <div class='container'>
                                    <h1 class='highlight'>¡BIENVENIDO A ESCAPEROOM!</h1>
                                    <p>Hola $name_player $lastname_player. Te damos la bienvenida a EscapeRoom. Prepárate para vivir emocionantes aventuras que desafiarán tu ingenio y creatividad.</p>
                                    <p>Te invitamos a explorar estas salas y a reservar tu próxima aventura desde la comodidad de tu hogar. Recuerda que estamos aquí para ayudarte con cualquier consulta que tengas.</p>
                                    <p>¡Comienza tu aventura ahora!</p>
                                    <div class='footer'>
                                        <p>Atentamente, el equipo de <strong>EscapeRoom</strong></p>
                                        
                                    </div>
                                </div>
                            </body>
                            </html>
                            ";
            $mail->AltBody = "Hola $name_player,\n Gracias por registrarte en EscapeRoom. ¡Estamos felices de tenerte!";
            $mail->send();
            
        } catch (Exception $e) {
            die("El correo no se pudo enviar. Error: {$mail->ErrorInfo}"); 
        }

        header("Location: ../index.php");
        exit(); 
    } else {
        die("Error al registrar el jugador: " . htmlspecialchars($stmt->error));
    }
    $stmt->close();
}
