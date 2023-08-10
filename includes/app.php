<?php 

require 'funciones.php';
require 'database.php';
require __DIR__ . '/../vendor/autoload.php';

// Conectarnos a la base de datos
use Dotenv\Dotenv;
use Model\ActiveRecord;
ActiveRecord::setDB($db);

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();