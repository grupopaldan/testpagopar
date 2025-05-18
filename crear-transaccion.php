<?php
$token_publico = '2d45c2b08ffbab721265fcd6c55750a3';
$token_privado = 'a88c6b7af4ea3f1bc8c4af006cf468ea';
$url_base = 'https://' . $_SERVER['HTTP_HOST'];

$data = [
    'token' => $token_privado,
    'public_key' => $token_publico,
    'operation' => [
        'amount' => 10000,
        'purchase_description' => 'Pedido de prueba',
        'currency' => 'PYG',
        'order_id' => 'TEST-' . rand(1000, 9999),
        'return_url' => $url_base . '/compra-exitosa.php?hash=HASH_PRUEBA',
        'confirmation_url' => $url_base . '/webhook-pagopar.php',
        'client' => [
            'name' => 'Cliente de Prueba',
            'email' => 'prueba@correo.com'
        ],
        'products' => [
            [
                'product_id' => 1,
                'description' => 'Producto de prueba',
                'quantity' => 1,
                'price' => 10000
            ]
        ]
    ]
];

// ✅ Usamos el dominio oficial, NO IP directa
$ch = curl_init('https://api.pagopar.com/api/v2/transactions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json'
]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Seguro en Railway
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
$response = curl_exec($ch);
$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_error = curl_error($ch);
curl_close($ch);

// Mostrar resultado
echo "<h2>Respuesta PagoPar:</h2>";
echo "<pre>";
echo "HTTP Status: $http_status\n";
if ($curl_error) echo "cURL Error: $curl_error\n";
print_r(json_decode($response, true));
echo "</pre>";
?>
