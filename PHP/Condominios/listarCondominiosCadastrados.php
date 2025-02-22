<?php
$servidor = "154.56.48.204";
$usuario = "u400048496_brunosilva";
$senha = "Bru@1989";
$banco = "u400048496_BdAcoAdm";

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT * FROM Condominios");
    $stmt->execute();

    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($resultado as $key => $condominio) {
        echo "<tr>";
        echo "<th scope='row'>" . ($key + 1) . "</th>";        
        echo "<td>" . htmlspecialchars($condominio['nome']) . "</td>";
        echo "<td>" . htmlspecialchars($condominio['endereco']) . "</td>";
        echo "<td>" . htmlspecialchars($condominio['cep']) . "</td>";
        echo "<td>" . htmlspecialchars($condominio['cidade']) . "</td>";
        echo "<td>" . htmlspecialchars($condominio['estado']) . "</td>";
        echo "<td>" . htmlspecialchars($condominio['numeroUnidades']) . "</td>";
        echo "<td>" . htmlspecialchars($condominio['areasComuns']) . "</td>";        
        echo "<td>"
            . "<button class='btn btn-outline-primary btn-sm me-4' onclick='window.location.href=\"/acoAlterarCondominio.html?id=" . htmlspecialchars($condominio['id']) . "\"'>Alterar&nbsp;</button><br>"
            . "<button class='btn btn-outline-primary btn-sm me-2' onclick='deleteCondominio(" . htmlspecialchars($condominio['id']) . ")'>Apagar</button>"
            . "</td>";
        echo "</tr>";
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}

$conn = null;
?>