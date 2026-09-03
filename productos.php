<?php
include_once 'conexion.php';

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        // Consultar la lista de productos
        $sql = "SELECT * FROM productos"; // Asegúrate de que la tabla 'productos' exista en tu BD
        $resultado = $conexion->query($sql);
        
        $productos = [];
        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $productos[] = $fila;
            }
        }
        
        http_response_code(200);
        echo json_encode($productos);
        break;

    case 'POST':
        // Recibir los datos enviados en formato JSON
        $datos = json_decode(file_get_contents("php://input"), true);

        // Validación 1: Campos obligatorios
        if (empty($datos['nombre']) || empty($datos['precio'])) {
            http_response_code(400); // Bad Request
            echo json_encode([
                "estado" => "error", 
                "mensaje" => "Campos obligatorios incompletos (nombre y precio son requeridos)."
            ]);
            exit();
        }

        // Validación 2: Tipo de dato numérico
        if (!is_numeric($datos['precio']) || $datos['precio'] <= 0) {
            http_response_code(400);
            echo json_encode([
                "estado" => "error", 
                "mensaje" => "El precio debe ser un valor numérico mayor a 0."
            ]);
            exit();
        }

        // Guardar en la base de datos
        $nombre = $conexion->real_escape_string($datos['nombre']);
        $precio = $datos['precio'];

        $sqlInsert = "INSERT INTO productos (nombre, precio) VALUES ('$nombre', '$precio')";
        
        if ($conexion->query($sqlInsert)) {
            http_response_code(201); // Created
            echo json_encode([
                "estado" => "éxito", 
                "mensaje" => "Producto creado correctamente."
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                "estado" => "error", 
                "mensaje" => "Error al guardar: " . $conexion->error
            ]);
        }
        break;

    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(["mensaje" => "Método no permitido."]);
        break;
}
?>