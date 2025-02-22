<?php

$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

// Criar conexão
$db = new mysqli($servidor, $usuario, $senha, $banco);

if ($db->connect_error) {
    die("Conexão falhou: " . $db->connect_error);
}

// Insira suas credenciais do Mercado Pago
$access_token = 'APP_USR-3089663735355019-110222-2dd85de944bdd6a711c7b611eee2c067-361747870';

try {
    // Verifica se há uma requisição POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Identifique o método de pagamento
        $payment_method_id = $_POST['payment_type_id'];

        switch ($payment_method_id) {
            case 'bolbradesco':
                // Lógica para criar um boleto
                $payment_data = [
                    'transaction_amount' => (float)$_POST['amount'],
                    'description' => $_POST['description'],
                    'payment_method_id' => 'bolbradesco',
                    'payer' => [
                        'email' => $_POST['email'],
                        'first_name' => $_POST['first_name'],
                        'last_name' => $_POST['last_name'],
                        'identification' => [
                            'type' => $_POST['doc_type'],
                            'number' => $_POST['doc_number']
                        ],
                        'address' => [
                            'zip_code' => $_POST['address_zip_code'],
                            'street_name' => $_POST['address_street_name'],
                            'street_number' => intval($_POST['address_street_number'])
                        ]
                    ]
                ];
                $url = 'https://api.mercadopago.com/v1/payments';
                break;

            case 'pix':
                // Lógica para criar um pedido de pagamento Pix
                $payment_data = [
                    // ... dados específicos do Pix ...
                ];
                $url = 'https://api.mercadopago.com/v1/payments';
                break;

            case 'payment_link':
                // Lógica para criar um link de pagamento
                $payment_data = [
                    // ... dados específicos do link de pagamento ...
                ];
                $url = 'https://api.mercadopago.com/checkout/preferences';
                break;

            default:
                throw new Exception('Método de pagamento não suportado');
        }

        // O restante do código é semelhante, mas agora a URL e os dados de pagamento
        // podem mudar de acordo com o método de pagamento selecionado
        $ch = curl_init();
        $idempotencyKey = uniqid('', true);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payment_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $access_token,
            'Content-Type: application/json',
            'X-Idempotency-Key: ' . $idempotencyKey
        ]);
        

        $response = curl_exec($ch);
        if ($response === false) {
            throw new Exception('cURL Error: ' . curl_error($ch));
        }

        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_status != 201) {
            throw new Exception("HTTP Status Code: $http_status - Response: $response");
        }

        // Fecha a conexão cURL
        $payment = json_decode($response, true);
        curl_close($ch);


        if (!$payment || !isset($payment['status'])) {
            throw new Exception('Erro ao gerar boleto ou resposta inválida da API');
        }

        $payment['payment_type_id'] = $payment_type_id;

        // Valores vindos da API e do pedido
        $description = $_POST['description'];
        $amount = $_POST['amount'];
        $status = $payment['status']; 
        $paymentId = $payment['id'];
        $email = $_POST['email'];
        $boletoUrl = $payment['transaction_details']['external_resource_url'] ?? null;
        

        // Inserção no banco de dados
        $stmt = $db->prepare("INSERT INTO boletos (description, amount, status, payment_id, email, data_vencimento, boleto_url) VALUES (?, ?, ?, ?, ?, ?, ?)");

        if ($stmt === false) {
            // Maneira de tratar o erro de prepare
            throw new Exception('Erro ao preparar a declaração: ' . $db->error);
        }

        $dataCriacao = new DateTime(); // Data de hoje
        $diasParaVencer = 3; // Vencimento em 3 dias
        $dataVencimento = $dataCriacao->add(new DateInterval("P{$diasParaVencer}D"));
        $dataVencimentoFormatada = $dataVencimento->format('Y-m-d');
        

        $stmt->bind_param("sdsssss", $description, $amount, $status, $paymentId, $email, $dataVencimentoFormatada, $boletoUrl);
        $success = $stmt->execute();

        if (!$success) {
            // Maneira de tratar o erro de execute
            throw new Exception('Erro ao executar a declaração: ' . $stmt->error);
        }

        if ($payment['status'] === 'pending' || $payment['status'] === 'in_process') {
            // Boleto gerado com sucesso, aguardando pagamento
            echo json_encode(['status' => 'success', 'message' => 'Boleto gerado com sucesso', 'content' => $payment,'boleto_url' => $boletoUrl]);
        } elseif ($payment['status'] === 'approved') {
            // Pagamento aprovado (não é o caso de boleto antes do pagamento)
            echo json_encode(['status' => 'success', 'message' => 'Pagamento aprovado', 'content' => $payment]);
        } else {
            // Outros casos, como rejeitado ou cancelado
            echo json_encode(['status' => 'error', 'message' => 'Pagamento não aprovado', 'content' => $payment]);
        }
    } else {
        throw new Exception('Método de requisição inválido');
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
} finally {
    $db->close();
}
?>