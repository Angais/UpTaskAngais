<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;
use Model\Proyecto;

class DashboardController{
    public static function index(Router $router){

        if(!isset($_SESSION)){
            session_start();
        }
        isAuth();

        $id = $_SESSION["id"];
        $proyectos = Proyecto::belongsTo("propietarioId", $id);

        

        $router->render("dashboard/index", [
            "titulo" => "Proyectos",
            "proyectos" => $proyectos
        ]);
    }

    public static function crear_proyecto(Router $router){

        if(!isset($_SESSION)){
            session_start();
        }
        isAuth();

        $alertas = [];

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $proyecto = new Proyecto($_POST);
            $alertas = $proyecto->validarProyecto();

            if(empty($alertas)){
                // Generar URL única
                $hash = md5(uniqid());
                $proyecto->url = $hash;

                // Almacenar creador
                $proyecto->propietarioId = $_SESSION["id"];

                // Guardar Proyecto
                $proyecto->guardar();

                header("Location: /proyecto?id=" . $proyecto->url);

            }
        }

        $router->render("dashboard/crear-proyecto", [
            "titulo" => "Crear Proyecto",
            "alertas" => $alertas
        ]);
    }

    public static function proyecto(Router $router){
        if(!isset($_SESSION)){
            session_start();
        }
        isAuth();

        $token = $_GET["id"];

        if(!$token){
            header("Location: /dashboard");
        }

        // Revisar quién creó el proyecto
        $proyecto = Proyecto::where("url", $token);
        if($proyecto->propietarioId !== $_SESSION["id"]){
            header("Location: /dashboard");
        }
        $router->render("dashboard/proyecto", [
            "titulo" => $proyecto->proyecto
        ]);
    }

    public static function perfil(Router $router){

        if(!isset($_SESSION)){
            session_start();
        }
        isAuth();
        $alertas = [];

        $usuario = Usuario::find($_SESSION["id"]);

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $usuario->sincronizar($_POST);

            $alertas = $usuario->validar_perfil();
            if(empty($alertas)){
                $existeUsuario = Usuario::where("email", $usuario->email);

                if($existeUsuario && $existeUsuario->id !== $usuario->id){
                    // Mensaje Error
                    Usuario::setAlerta("error", "Esta dirección de Correo Electrónico ya está siendo usada");
                    $alertas = $usuario->getAlertas();
                } else{
                        $usuario->guardar();
        
                        Usuario::setAlerta("exito", "Cambios Guardados");
                        $alertas = $usuario->getAlertas();
        
                        $_SESSION["nombre"] = $usuario->nombre;
                }
            }



        }

        $router->render("dashboard/perfil", [
            "titulo" => "Perfil",
            "usuario" => $usuario,
            "alertas" => $alertas
        ]);
    }

    public static function cambiar_password(Router $router){

        if(!isset($_SESSION)){
            session_start();
        }
        isAuth();

        $alertas = [];

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $usuario = Usuario::find($_SESSION["id"]);
            $usuario->sincronizar($_POST);

            $alertas = $usuario->nuevo_password();

            if(empty($alertas)){
                $resultado = $usuario->comprobar_password();

                if($resultado){
                    $usuario->password = $usuario->password_nuevo;
                    unset($usuario->password_actual);
                    unset($usuario->password_nuevo);

                    $usuario->hashPassword();
                    $resultado = $usuario->guardar();

                    if($resultado){
                        Usuario::setAlerta("exito", "Contraseña Actualizada exitosamente");
                        $alertas = $usuario->getAlertas();
                    }

                } else{
                    Usuario::setAlerta("error", "Contraseña Actual Incorrecta");
                    $alertas = $usuario->getAlertas();
                }
            }
        }

        $router->render("dashboard/cambiar-password", [
            "titulo" => "Cambiar Contraseña",
            "alertas" => $alertas
        ]);
    }
}