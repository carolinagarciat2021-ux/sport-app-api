<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

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
?>