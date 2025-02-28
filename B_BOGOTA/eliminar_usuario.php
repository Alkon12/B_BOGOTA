<?php
include 'Conexion.php';

if (isset($_POST['id_usuario'])) {
    $id_usuario = intval($_POST['id_usuario']);
    
    $query = "DELETE FROM usuarios WHERE id_usuario = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id_usuario);
    
    if ($stmt->execute()) {
        echo "Usuario eliminado correctamente";
    } else {
        echo "Error al eliminar el usuario: " . $conexion->error;
    }
    
    $stmt->close();
} else {
    echo "ID de usuario no proporcionado";
}

$conexion->close();
?>