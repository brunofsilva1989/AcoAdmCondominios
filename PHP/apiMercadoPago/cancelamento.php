<?php

// Insira suas credenciais do Mercado Pago
$access_token = 'APP_USR-3089663735355019-110222-2dd85de944bdd6a711c7b611eee2c067-361747870';

// Receber o JSON do corpo da requisição
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); // TRUE retorna um array associativo

// Verifica se o ID do pagamento foi enviado via JSON
if ($input && isset($input['paymentId'])) {
    $payment_id = $input['paymentId']; // Certifique-se de que as chaves correspondam

    // Inicia o cURL
    $ch = curl_init();

    // Define a configuração do cURL para cancelar o pagamento
    curl_setopt_array($ch, [
        CURLOPT_URL => "https://api.mercadopago.com/v1/payments/$payment_id",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => json_encode(['status' => 'cancelled']),
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $access_token,
            'Content-Type: application/json',
        ],
    ]);

    // Executa a chamada e captura a resposta
    $response = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);

    // Fecha a conexão cURL
    curl_close($ch);

    // Tratar a resposta
    if ($http_status == 200) {
        // Boleto foi cancelado com sucesso
        echo json_encode(['status' => 'success', 'message' => 'Boleto cancelado com sucesso.']);
    } else {
        // Houve um erro ao cancelar o boleto
        error_log('Erro ao cancelar boleto: ' . $curl_error);
        echo json_encode(['status' => 'error', 'message' => "Erro ao cancelar o boleto: HTTP $http_status - $curl_error"]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID do pagamento não fornecido.']);
}

?>
