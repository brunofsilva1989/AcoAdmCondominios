<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Colete os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $unidades = $_POST['units'];
    $telefone = $_POST['phone'];
    $cidade_estado = $_POST['cityState'];
    $plano = $_POST['plan'];
    $como_conheceu = $_POST['reference'];
    // ... coleciona todos os campos necessários

    // Insira os dados em seu banco de dados
    $conn = new mysqli('31.170.167.102', 'u682077517_brunosilva', 'Bru@1989', 'u682077517_acodb');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $conn->set_charset("utf8mb4");

    $nome = mysqli_real_escape_string($conn, $nome);
    $email = mysqli_real_escape_string($conn, $email);
    $unidades = mysqli_real_escape_string($conn, $unidades);
    $telefone = mysqli_real_escape_string($conn, $telefone);
    $cidade_estado = mysqli_real_escape_string($conn, $cidade_estado);
    $plano = mysqli_real_escape_string($conn, $plano);
    $como_conheceu = mysqli_real_escape_string($conn, $como_conheceu);

    $sql = "INSERT INTO propostas (nome, email, unidades, telefone, cidade_estado, como_conheceu, plano, mensagem)
    VALUES ('$nome', '$email', '$unidades', '$telefone', '$cidade_estado', '$como_conheceu', '$plano', '$mensagem')";

    // if ($conn->query($sql) === TRUE) {
    //     echo "Proposta recebida com sucesso!";
    // } else {
    //     echo "Error: " . $sql . "<br>" . $conn->error;
    // }

    if ($conn->query($sql) === TRUE) {
        // Se quiser mostrar a mensagem e depois redirecionar, descomente as próximas três linhas
        echo "Proposta recebida com sucesso!";
        sleep(5); // espera 5 segundos antes de redirecionar
        header("Location: index.html"); // redireciona para index.html
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    // Envie um e-mail de confirmação para o cliente
    $mensagemCliente = "Obrigado por enviar sua proposta. Entraremos em contato em breve!";
    mail($email, "Recebemos sua proposta", $mensagemCliente);

    // Envia o email da proposta Gravada
    $para = 'brunosilva@bfsilva.com.br';
    $assunto = 'Nova Proposta Recebida';

    $corpoDoEmail = "Detalhes da Proposta:\n\n".
        "Nome: $nome\n".
        "Email: $email\n".
        "Unidades: $unidades\n".
        "Telefone: $telefone\n".
        "Cidade/Estado: $cidade_estado\n".
        "Plano: $plano\n".
        "Como Conheceu: $como_conheceu\n";

    // Envie o e-mail com os detalhes da proposta para o seu e-mail
    mail($para, $assunto, $corpoDoEmail);
}
?>
