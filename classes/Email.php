<?php 

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{
    protected $email;
    protected $nombre;
    protected $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion(){

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '66221563f71daa';
        $mail->Password = '2667f41ce6c25c';

        $mail->setFrom("cuentas@uptask.com");
        $mail->addAddress("cuentas@uptask.com", "uptask.com");
        $mail->Subject = "Confirma tu Cuenta";

        $mail->isHTML(TRUE);
        $mail->CharSet = "UTF-8";

        $contenido = '<!DOCTYPE html>
        <html lang="en">
        
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Bienvenido a UpTask</title>
            <style>
                body {
                    font-family: "Arial", sans-serif;
                    background-color: #f7f7f7;
                    margin: 0;
                    padding: 20px;
                }
        
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
                }
        
                .title {
                    font-size: 2em;
                    color: #333;
                    text-align: center;
                    margin-bottom: 20px;
                }
        
                .info {
                    text-align: center;
                    color: #555;
                    font-size: 1.1em;
                }
        
                .confirm-button {
                    display: block;
                    margin: 20px auto;
                    padding: 10px 20px;
                    background-color: #6b5b95; 
                    color: #fff;
                    font-size: 1.2em;
                    border: none;
                    border-radius: 5px;
                    text-decoration: none;
                    text-align: center;
                }
        
                .confirm-button:hover {
                    background-color: #4a4371;
                }
            </style>
        </head>
        
        <body>
            <div class="container">
                <div class="title">¡Bienvenido a UpTask, ' . $this->nombre . '! 👋</div>
                <div class="info">
                    UpTask es tu herramienta de gestión de tareas preferida. Simplifica tus proyectos, organiza tus tareas y colorea tu día a día. Sea un proyecto personal o en equipo, ¡UpTask está aquí para ayudarte!
                </div>
                <a href="http://localhost:3000/confirmar?token=' . $this->token . '" class="confirm-button">Confirmar Cuenta</a>
            </div>
        </body>
        
        </html>';
        

        $mail->Body = $contenido;
        $mail->send();

    }

    public function enviarInstrucciones(){

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV["EMAIL_HOST"];
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->Username = $_ENV["EMAIL_USER"];
        $mail->Password = $_ENV["EMAIL_PASS"];

        $mail->setFrom("pruebas.webdev.a@gmail.com");
        $mail->addAddress($this->email);
        $mail->Subject = "Reestablece tu Contraseña";

        $mail->isHTML(TRUE);
        $mail->CharSet = "UTF-8";

        $contenido = '<!DOCTYPE html>
        <html lang="en">
        
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Recuperar Contraseña de UpTask</title>
            <style>
                body {
                    font-family: "Arial", sans-serif;
                    background-color: #f7f7f7;
                    margin: 0;
                    padding: 20px;
                }
        
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
                }
        
                .title {
                    font-size: 2em;
                    color: #333;
                    text-align: center;
                    margin-bottom: 20px;
                }
        
                .info {
                    text-align: center;
                    color: #555;
                    font-size: 1.1em;
                }
        
                .confirm-button {
                    display: block;
                    margin: 20px auto;
                    padding: 10px 20px;
                    background-color: #6b5b95; 
                    color: #fff;
                    font-size: 1.2em;
                    border: none;
                    border-radius: 5px;
                    text-decoration: none;
                    text-align: center;
                }
        
                .confirm-button:hover {
                    background-color: #4a4371;
                }
            </style>
        </head>
        
        <body>
            <div class="container">
                <div class="title">¿Te olvidaste de tu contraseña? ¡No te preocupes!</div>
                <div class="info">
                    ¡UpTask está aquí para ayudarte! Simplemente pulsa el botón de abajo y podrás reestablecer tu contraseña por una nueva. ¡Asegúrate de no olvidarla esta vez!
                </div>
                <a href="http://localhost:3000/reestablecer?token=' . $this->token . '" class="confirm-button">Reestablecer Contraseña</a>
            </div>
        </body>
        
        </html>';
        

        $mail->Body = $contenido;
        $mail->send();

    }
}

?>