<?php 

namespace Model;

class Usuario extends ActiveRecord{
    protected static $tabla = "usuarios";
    protected static $columnasDB = ["id", "nombre", "email", "password", "token", "confirmado"];

    public function __construct($args = []){
        $this->id = $args["id"] ?? null;
        $this->nombre = $args["nombre"] ?? "";
        $this->email = $args["email"] ?? "";
        $this->password = $args["password"] ?? "";
        $this->password2 = $args["password2"] ?? "";
        $this->password_actual = $args["password_actual"] ?? "";
        $this->password_nuevo = $args["password_nuevo"] ?? "";
        $this->token = $args["token"] ?? "";
        $this->confirmado = $args["confirmado"] ?? 0;
    }
    public function validarLogin(){
        if(!$this->email){
            self::$alertas["error"][] = "Añada un email";
        } else{
            if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
                self::$alertas["error"][] = "Añada una dirección de Correo Electrónico válida";
            }
        }
        if(!$this->password){
            self::$alertas["error"][] = "Añada su contraseña";
        } 

        return self::$alertas;
    }

    public function validarNuevaCuenta(){
        if(!$this->nombre){
            self::$alertas["error"][] = "Añada un nombre";
        }
        if(!$this->email){
            self::$alertas["error"][] = "Añada un email";
        }
        if(!$this->password){
            self::$alertas["error"][] = "Añada una contraseña";
        } else{
            if(strlen($this->password) < 6){
                self::$alertas["error"][] = "La contraseña debe contener al menos 6 caracteres";
            }
        }
        if($this->password !== $this->password2){
            self::$alertas["error"][] = "Las contraseñas deben coincidir";
        }

        return self::$alertas;
    }

    public function validarEmail(){
        if(!$this->email){
            self::$alertas["error"][] = "Añada una dirección de Correo Electrónico";
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$alertas["error"][] = "Añada una dirección de Correo Electrónico válida";
        }
        return self::$alertas;
    }

    public function validarPassword(){
        if(!$this->password){
            self::$alertas["error"][] = "Añada una contraseña";
        } else{
            if(strlen($this->password) < 6){
                self::$alertas["error"][] = "La contraseña debe contener al menos 6 caracteres";
            }
        }
        return self::$alertas;
    }

    public function nuevo_password() : array{
        if(!$this->password_actual){
            self::$alertas["error"][] = "Escriba su Contraseña Actual";
        }
        if(!$this->password_nuevo){
            self::$alertas["error"][] = "Escriba su Nueva Contraseña";
        } else{
            if(strlen($this->password_nuevo) < 6){
                self::$alertas["error"][] = "Su Nueva Contraseña debe contener al menos 6 caracteres";
            }
        }

        return self::$alertas;

    }

    public function comprobar_password() : bool{
        return password_verify($this->password_actual, $this->password);
    }

    public function hashPassword() : void{
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken() : void{
        $this->token = uniqid();
    }

    public function validar_perfil(){
        if(!$this->nombre){
            self::$alertas["error"][] = "Añada un nombre";
        }
        if(!$this->email){
            self::$alertas["error"][] = "Añada una dirección de Correo Electrónico";
        }
        return self::$alertas;
    }
            
}
