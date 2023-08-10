<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\LoginController;
use Controllers\DashboardController;
use Controllers\TareaController;

$router = new Router();

// Rutas

// Login y Logout
$router->get("/", [LoginController::class, "login"]);
$router->post("/", [LoginController::class, "login"]);
$router->get("/logout", [LoginController::class, "logout"]);

// Crear Cuentas
$router->get("/crear", [LoginController::class, "crear"]);
$router->post("/crear", [LoginController::class, "crear"]);

// Olvidar Contraseña
$router->get("/olvide", [LoginController::class, "olvide"]);
$router->post("/olvide", [LoginController::class, "olvide"]);

// Nueva Contraseña
$router->get("/reestablecer", [LoginController::class, "reestablecer"]);
$router->post("/reestablecer", [LoginController::class, "reestablecer"]);

// Confirmar
$router->get("/mensaje", [LoginController::class, "mensaje"]);
$router->get("/confirmar", [LoginController::class, "confirmar"]);


// Zona de Proyectos
$router->get("/dashboard", [DashboardController::class, "index"]);
$router->get("/crear-proyecto", [DashboardController::class, "crear_proyecto"]);
$router->post("/crear-proyecto", [DashboardController::class, "crear_proyecto"]);
$router->get("/proyecto", [DashboardController::class, "proyecto"]);
$router->get("/perfil", [DashboardController::class, "perfil"]);
$router->post("/perfil", [DashboardController::class, "perfil"]);
$router->get("/cambiar-password", [DashboardController::class, "cambiar_password"]);
$router->post("/cambiar-password", [DashboardController::class, "cambiar_password"]);


// API Tareas
$router->get("/api/tareas", [TareaController::class, "index"]);
$router->post("/api/tarea", [TareaController::class, "crear"]);
$router->post("/api/tarea/actualizar", [TareaController::class, "actualizar"]);
$router->post("/api/tarea/eliminar", [TareaController::class, "eliminar"]);


$router->get("/404", [TareaController::class, "error"]);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();