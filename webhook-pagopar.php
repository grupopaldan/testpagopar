<?php
file_put_contents('webhook-log.txt', date('Y-m-d H:i:s') . " - " . file_get_contents('php://input') . "\n", FILE_APPEND);
echo json_encode(['status' => 'ok', 'mensaje' => 'Webhook recibido']);
?>