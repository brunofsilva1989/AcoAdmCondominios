<?php
// Primeira parte: Obter o Token OAuth com Certificados SSL

// Configuração inicial do cURL para obter o token
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://cdpj.partners.bancointer.com.br/oauth/v2/token");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_SSLCERT, "caminho/para/certificado.crt"); // Caminho para o certificado
curl_setopt($ch, CURLOPT_SSLKEY, "caminho/para/chave.key"); // Caminho para a chave privada

// Parâmetros para obter o token
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
    'client_id' => 'seu_client_id', // Substitua pelo seu client ID
    'client_secret' => 'seu_client_secret', // Substitua pelo seu client secret
    'scope' => 'escopos_necessarios', // Defina os escopos necessários
    'grant_type' => 'client_credentials'
)));

curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Executar a requisição e obter a resposta
$server_response = curl_exec($ch);
if (curl_error($ch)) {
    echo 'Erro na autenticação OAuth: ' . curl_error($ch);
    curl_close($ch);
    exit;
}
curl_close($ch);

// Decodificar a resposta para obter o token
$responseData = json_decode($server_response);
$token = $responseData->access_token;

// Segunda parte: Enviar dados do boleto para a API

$url = "https://api.bancointer.com.br/openbanking/v1/certificado/boletos";

$headers = array(
    "x-inter-conta-corrente: sua_conta_corrente", // Substitua com o número da conta corrente
    "Content-Type: application/json",
    "Authorization: Bearer $token"
);

// Dados do boleto
$boletodata = [
    // ... mantenha os dados do boleto como no seu script original
];

$boletodata_json = json_encode($boletodata);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $boletodata_json);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execução da requisição para a criação do boleto
$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Erro na requisição do boleto: ' . curl_error($ch);
} else {
    // Imprime a resposta da API
    echo $response;
}

curl_close($ch);
?>
