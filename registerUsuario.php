<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexão com o banco de dados
    $conn = new mysqli('localhost', 'root', 'Bru@1989', 'acodb');

    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Dados do formulário
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash da senha
    $email = $conn->real_escape_string($_POST['email']);

    // Inserção no banco de dados
    $query = "INSERT INTO usuarios (username, password, email) VALUES ('$username', '$password', '$email')";

    if ($conn->query($query) === TRUE) {
        echo "Usuário cadastrado com sucesso!";
    } else {
        echo "Erro: " . $query . "<br>" . $conn->error;
    }

    $conn->close();
}

?>

