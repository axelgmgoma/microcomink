<?php
$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['nombre']) || !isset($data['pedido_html'])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Datos inválidos"]);
    exit;
}

$nombre = preg_replace('/[^a-zA-Z0-9_-]/', '_', $data['nombre']);
$pedidoHTML = $data['pedido_html'];

if (!file_exists("pedidos")) {
    mkdir("pedidos", 0777, true);
}

$archivo = "pedidos/pedido_" . date("Y-m-d_H-i-s") . "_$nombre.html";
file_put_contents($archivo, $pedidoHTML);

echo json_encode(["status" => "success", "file" => $archivo]);
?>
