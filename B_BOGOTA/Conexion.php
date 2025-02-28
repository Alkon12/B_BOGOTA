<?php

ini_set('memory_limit', '2048M'); // Aumenta el límite de memoria

$servidor = "db"; 
$usuario = "root"; 
$clave = "root"; // Si tienes contraseña, colócala aquí
$base_datos = "banco_virtual"; 
$puerto = 3306; // Especificamos el puerto correcto

$conexion = new mysqli($servidor, $usuario, $clave, $base_datos, $puerto);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8");