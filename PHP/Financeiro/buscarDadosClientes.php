<?php

function fetchClientesData()
{
    $servidor = "154.56.48.204";
    $usuario = "u400048496_brunosilva";
    $senha = "Bru@1989";
    $banco = "u400048496_BdAcoAdm";

    try {
        $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->query("SELECT * FROM clientes");
        return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (PDOException $e) {
        return "Erro: " . $e->getMessage();
    }
}
?>