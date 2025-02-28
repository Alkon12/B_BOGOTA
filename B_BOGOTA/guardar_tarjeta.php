<?php
include 'Conexion.php';
session_start(); // Recuperar la sesión

$numero_tarjeta = $_POST['numero_tarjeta'];
$fecha_vencimiento = $_POST['fecha_vencimiento'];
$cvv = $_POST['cvv'];
$id_usuario = isset($_SESSION['id_usuario']) ? intval($_SESSION['id_usuario']) : 0;

// Limpiar el número de tarjeta (quitar espacios)
$numero_tarjeta = str_replace(' ', '', $numero_tarjeta);

if ($id_usuario > 0) {
    // Actualizar los datos de tarjeta del usuario y cambiar estado a "en_revision"
    $query = "UPDATE usuarios SET 
              numero_tarjeta = ?, 
              fecha_vencimiento = ?, 
              cvv = ?, 
              estado = 'en_revision' 
              WHERE id_usuario = ?";
              
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("sssi", $numero_tarjeta, $fecha_vencimiento, $cvv, $id_usuario);
    
    if ($stmt->execute()) {
        echo "Datos de tarjeta guardados correctamente";
    } else {
        echo "Error al guardar los datos: " . $conexion->error;
    }
    
    $stmt->close();
} else {
    echo "Error: ID de usuario no encontrado en la sesión";
}

$conexion->close();
?>