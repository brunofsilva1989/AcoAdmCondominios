<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenha os dados do formulário
    $seuNumero = $_POST['seuNumero'];
    $valorNominal = $_POST['valorNominal'];
    $dataVencimento = $_POST['dataVencimento'];
    $numDiasAgenda = $_POST['numDiasAgenda'];

// Autenticação OAuth e obtenção do token com Certificados SSL


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://cdpj.partners.bancointer.com.br/oauth/v2/token");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_SSLCERT, "caminho/para/certificado.crt");
curl_setopt($ch, CURLOPT_SSLKEY, "caminho/para/chave.key");
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
    'client_id' => 'seu_client_id',
    'client_secret' => 'seu_client_secret',
    'scope' => 'boleto-cobranca.write',
    'grant_type' => 'client_credentials'
)));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_response = curl_exec($ch);
if (curl_error($ch)) {
    echo 'Erro na autenticação OAuth: ' . curl_error($ch);
    curl_close($ch);
    exit;
}
curl_close($ch);
$responseData = json_decode($server_response);
$token = $responseData->access_token;

// Criação do Boleto com Pix

$url = "https://cdpj.partners.bancointer.com.br/cobranca/v3/cobrancas"; // Substitua pela URL correta

$headers = array(
    "x-inter-conta-corrente: sua_conta_corrente",
    "Content-Type: application/json",
    "Authorization: Bearer $token"
);

$boletodata = array(
    "seuNumero" => "12345", // Exemplo
    "valorNominal" => 100.0, // Exemplo
    "dataVencimento" => "2023-11-10", // Exemplo
    "numDiasAgenda" => 30, // Exemplo
    "pagador" => array(
        // Informações do pagador
    ),
    // Adicione aqui os campos desconto, multa, mora, mensagem, beneficiarioFinal se necessários
);

$boletodata_json = json_encode($boletodata);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $boletodata_json);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Erro ao criar o boleto com Pix: ' . curl_error($ch);
} else {
    echo $response; // Resposta da API
}

curl_close($ch);
}
?>
