<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$host = "127.0.0.1";
$user = "root"; 
$password = "1234";
$database = "venta_ropa_deportiva";
$port = 3307;

$conexion = new mysqli($host, $user, $password, $database, $port);

if ($conexion->connect_error) {
    http_response_code(500);
    echo json_encode(["estado" => "error", "mensaje" => "Error de conexión: " . $conexion->connect_error]);
    exit();
}

$conexion->set_charset("utf8");

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $stmt = $conexion->prepare("SELECT id, nombre, precio FROM productos WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($producto = $resultado->fetch_assoc()) {
                http_response_code(200);
                echo json_encode($producto);
            } else {
                http_response_code(404);
                echo json_encode(["estado" => "error", "mensaje" => "Producto no encontrado."]);
            }
            $stmt->close();
        } else {
            $sql = "SELECT id, nombre, precio FROM productos";
            $resultado = $conexion->query($sql);
            $productos = [];

            while ($row = $resultado->fetch_assoc()) {
                $productos[] = $row;
            }

            http_response_code(200);
            echo json_encode($productos);
        }
        exit();

    case 'POST':
        $datos = json_decode(file_get_contents("php://input"), true);

        if (!empty($datos['nombre']) && isset($datos['precio'])) {
            $nombre = $datos['nombre'];
            $precio = $datos['precio'];

            $stmt = $conexion->prepare("INSERT INTO productos (nombre, precio) VALUES (?, ?)");
            $stmt->bind_param("sd", $nombre, $precio);

            if ($stmt->execute()) {
                http_response_code(201);
                echo json_encode([
                    "estado" => "exito", 
                    "mensaje" => "Producto creado exitosamente.",
                    "id" => $conexion->insert_id
                ]);
            } else {
                http_response_code(500);
                echo json_encode(["estado" => "error", "mensaje" => "Error al guardar el producto."]);
            }
            $stmt->close();
        } else {
            http_response_code(400);
            echo json_encode(["estado" => "error", "mensaje" => "Datos incompletos en el Body JSON."]);
        }
        exit();

    case 'PUT':
        $id = isset($_GET['id']) ? intval($_GET['id']) : null;
        $datos = json_decode(file_get_contents("php://input"), true);

        if ($id && !empty($datos['nombre']) && isset($datos['precio'])) {
            $nombre = $datos['nombre'];
            $precio = $datos['precio'];

            $stmt = $conexion->prepare("UPDATE productos SET nombre = ?, precio = ? WHERE id = ?");
            $stmt->bind_param("sdi", $nombre, $precio, $id);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    http_response_code(200);
                    echo json_encode(["estado" => "exito", "mensaje" => "Producto actualizado exitosamente."]);
                } else {
                    http_response_code(200);
                    echo json_encode(["estado" => "info", "mensaje" => "No se realizaron cambios o el producto no existe."]);
                }
            } else {
                http_response_code(500);
                echo json_encode(["estado" => "error", "mensaje" => "Error al actualizar el producto."]);
            }
            $stmt->close();
        } else {
            http_response_code(400);
            echo json_encode(["estado" => "error", "mensaje" => "Falta el parámetro ID o datos en el JSON."]);
        }
        exit();

    case 'DELETE':
        $id = isset($_GET['id']) ? intval($_GET['id']) : null;

        if ($id) {
            $stmt = $conexion->prepare("DELETE FROM productos WHERE id = ?");
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    http_response_code(200);
                    echo json_encode(["estado" => "exito", "mensaje" => "Producto eliminado exitosamente."]);
                } else {
                    http_response_code(404);
                    echo json_encode(["estado" => "error", "mensaje" => "El ID especificado no existe."]);
                }
            } else {
                http_response_code(500);
                echo json_encode(["estado" => "error", "mensaje" => "Error al eliminar el producto."]);
            }
            $stmt->close();
        } else {
            http_response_code(400);
            echo json_encode(["estado" => "error", "mensaje" => "Falta especificar el parámetro ?id= en la URL."]);
        }
        exit();

    default:
        http_response_code(405);
        echo json_encode(["estado" => "error", "mensaje" => "Método no permitido."]);
        exit();
}

$conexion->close();
?>