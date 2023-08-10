<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController{
    public static function login(Router $router){
        $alertas = [];
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $usuario = new Usuario($_POST);

            $alertas = $usuario->validarLogin();

            if(empty($alertas)){
                // Verificar que el Usuario existe
                $usuario = Usuario::where("email", $usuario->email);

                if(!$usuario){
                    Usuario::setAlerta("error", "El Usuario no existe");
                } else if(!$usuario->confirmado){
                    Usuario::setAlerta("error", "El Usuario no está confirmado");
                } else{
                    // El Usuario existe
                    if(password_verify($_POST["password"], $usuario->password)){
                        // Iniciar Sesión
                        session_start();
                        $_SESSION["id"] = $usuario->id;
                        $_SESSION["nombre"] = $usuario->nombre;
                        $_SESSION["email"] = $usuario->email;
                        $_SESSION["login"] = true;

                        // Redireccionar
                        header("Location: /dashboard");
                    } else{
                        Usuario::setAlerta("error", "Contraseña Incorrecta");
                    }
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render("auth/login", [
            "titulo" => "Iniciar Sesión",
            "alertas" => $alertas
        ]);
    }

    public static function logout(){
        if(!isset($_SESSION)){
            session_start();
        }
        $_SESSION = [];
        header("Location: /");

    }


    public static function crear(Router $router){
        $alertas = [];
        $usuario = new Usuario;
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            if(empty($alertas)){
                $existeUsuario = Usuario::where("email", $usuario->email);

                if($existeUsuario){
                    Usuario::setAlerta("error", "El Usuario ya está registrado");
                    $alertas = Usuario::getAlertas();
                } else{
                    // Hashear Contraseña
                    $usuario->hashPassword();
                    unset($usuario->password2);

                    // Token
                    $usuario->crearToken();

                    // Crear Usuario
                    $resultado = $usuario->guardar();

                    // Enviar email
                    
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

                    if($resultado){
                        header("Location: /mensaje");
                    }

                }
            }

        }
        $router->render("auth/crear", [
            "titulo" => "Crear Cuenta",
            "usuario" => $usuario,
            "alertas" => $alertas
        ]);
    }


    public static function olvide(Router $router){
        $alertas = [];
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();

            if(empty($alertas)){
                $usuario = Usuario::where("email", $usuario->email);

                if($usuario){
                    if($usuario->confirmado){
                        unset($usuario->password2);
                        // Generar token
                        $usuario->crearToken();

                        // Actualizar Usuario
                        $usuario->guardar();

                        // Enviar email
                        $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                        $email->enviarInstrucciones();
                        // Alerta
                        Usuario::setAlerta("exito", "¡Listo! Hemos enviado las instrucciones a tu email");
                        
                    } else{
                        Usuario::setAlerta("error", "El Usuario no está confirmado");
                    }
                } else{
                    Usuario::setAlerta("error", "El Usuario no existe");
                }

            }
        }
        $alertas = Usuario::getAlertas();
        $router->render("auth/olvide", [
            "titulo" => "Recuperar Contraseña",
            "alertas" => $alertas
        ]);

    }

    public static function reestablecer(Router $router){
        $token = $_GET["token"];
        $mostrar = true;

        if(!$token){ header("Location: /");}

        // Identificar Usuario
        $usuario = Usuario::where("token", $token);

        if(empty($usuario)){
            $mostrar = false;
            Usuario::setAlerta("error", "El token no es válido o la contraseña ya ha sido reestablecida. Si no fuiste tú quien la reestableció, por favor, solicite otro cambio de contraseña");
        }
        if($_SERVER["REQUEST_METHOD"] === "POST"){

            // Añadir password
            $usuario->sincronizar($_POST);

            // Validar
            $alertas = $usuario->validarPassword();

            if(empty($alertas)){
                // Hashear Contraseña
                $usuario->hashPassword();
                unset($usuario->password2);

                $usuario->token = null;

                $resultado = $usuario->guardar();

                if($resultado){
                    header("Location: /");
                }

            }

        }

        $alertas = Usuario::getAlertas();
        $router->render("auth/reestablecer", [
            "titulo" => "Reestablecer Contraseña",
            "alertas" => $alertas,
            "mostrar" => $mostrar
        ]);
    }

    public static function mensaje(Router $router){
        $router->render("auth/mensaje", [
            "titulo" => "Confirma tu Cuenta"
        ]);

    }


    public static function confirmar(Router $router){

        $token = s($_GET["token"]);

        $usuario = Usuario::where("token", $token);

        if(empty($usuario)){
            Usuario::setAlerta("error", "El token no es válido o la cuenta ya ha sido confirmada");

        } else {
            $usuario->confirmado = 1;
            $usuario->token = null;
            unset($usuario->password2);

            $usuario->guardar();

            Usuario::setAlerta("exito", "¡Cuenta confirmada! 🥳");
        }

        $alertas = Usuario::getAlertas();

        $router->render("auth/confirmar", [
            "titulo" => "Cuenta Confirmada",
            "alertas" => $alertas
        ]);

    }

}