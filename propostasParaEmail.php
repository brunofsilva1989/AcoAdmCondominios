<?php
// Conectar ao banco de dados
$con = new mysqli('localhost', 'root', 'Bru@1989', 'acobd');

if($con->connect_error) {
    die("Conexão falhou: " . $con->connect_error);
}

// Buscar a última proposta inserida no banco de dados
$sql = "SELECT * FROM propostas ORDER BY id DESC LIMIT 1";
$result = $con->query($sql);

if($result->num_rows > 0) {
    // Pegar os dados da proposta
    $row = $result->fetch_assoc();
    
    // Definir o e-mail e mensagem
    $para = 'brunosilva@bfsilva.com.br';
    $titulo = 'Nova Proposta Recebida';
    $mensagem = "Nova proposta de: " . $row['nome'] . "\nE-mail: " . $row['email'] . "\nDetalhes: " . $row['detalhes'];
    
    // Enviar o e-mail
    if(mail($para, $titulo, $mensagem)) {
        echo "E-mail enviado com sucesso!";
    } else {
        echo "Falha ao enviar o e-mail.";
    }
} else {
    echo "Nenhuma proposta encontrada.";
}

$con->close();
?>
