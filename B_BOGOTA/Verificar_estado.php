<?php
include 'Conexion.php';
session_start(); // Recuperar la sesión

header('Content-Type: application/json');

$id_usuario = isset($_SESSION['id_usuario']) ? intval($_SESSION['id_usuario']) : 0;

$query = "SELECT estado FROM usuarios WHERE id_usuario = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(["estado" => $row["estado"]]);
} else {
    echo json_encode(["estado" => "pendiente"]);
}

$stmt->close();
$conexion->close();
?>