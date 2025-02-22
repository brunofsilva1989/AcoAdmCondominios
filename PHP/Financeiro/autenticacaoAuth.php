<?php
// Endereço do endpoint para solicitar o token
$url = "https://cdpj.partners.bancointer.com.br/oauth/v2/token";

// Credenciais do cliente
$client_id = 'SEU_CLIENT_ID';
$client_secret = 'SEU_CLIENT_SECRET';

// Parâmetros para o corpo da requisição
$data = array(
    'client_id' => $client_id,
    'client_secret' => $client_secret,
    'grant_type' => 'client_credentials',
    'scope' => 'extrato.read boleto-cobranca.read' // Altere conforme necessário
);

// Opções para a requisição
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);

// Cria o contexto da requisição
$context  = stream_context_create($options);

// Executa a requisição e obtém a resposta
$response = file_get_contents($url, false, $context);

if ($response === FALSE) {
    die('Erro na requisição do token');
}

// Decodifica a resposta
$resultado = json_decode($response);

// Token de Acesso
$access_token = $resultado->access_token;

echo "Token: " . $access_token;
?>
