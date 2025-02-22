<?php

// Endpoint para obtenção do token OAuth
$url = "https://api.bancointer.com.br/oauth/token";

// Dados de autenticação (substitua pelos seus reais client_id e client_secret)
$client_id = "seu_client_id";
$client_secret = "seu_client_secret";

// Defina os escopos necessários
$scope = "extrato.read boleto-cobranca.write";

// Inicializar cURL
$ch = curl_init();

// Configurações do cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "client_id=$client_id&client_secret=$client_secret&grant_type=client_credentials&scope=$scope");
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

// Executar e obter a resposta
$response = curl_exec($ch);

// Verificar se houve erro
if (curl_errno($ch)) {
    echo 'Erro:' . curl_error($ch);
    exit;
}

// Fechar a conexão cURL
curl_close($ch);

// Decodificar a resposta JSON
$tokenData = json_decode($response, true);

// Imprimir o token de acesso (em um ambiente real, você deve manipulá-lo de forma adequada)
if (isset($tokenData['access_token'])) {
    echo "Token de Acesso: " . $tokenData['access_token'];
} else {
    echo "Não foi possível obter o token de acesso.";
    print_r($tokenData); // Imprimir a resposta para depuração
}

?>
