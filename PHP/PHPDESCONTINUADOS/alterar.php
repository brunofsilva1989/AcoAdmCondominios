<?php
// Conectar ao banco de dados
$servidor = "31.170.167.102";
$usuario = "u682077517_brunosilva";
$senha = "Bru@1989";
$banco = "u682077517_acodb";

// Inicializando variáveis
$nome = $endereco = $numeroUnidades = $areasComuns = "";

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$id) {
    die('ID inválido');
}

$conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebendo e sanitizando dados do formulário
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING);
    $numeroUnidades = filter_input(INPUT_POST, 'numeroUnidades', FILTER_SANITIZE_NUMBER_INT);
    $areasComuns = filter_input(INPUT_POST, 'areasComuns', FILTER_SANITIZE_STRING);
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Atualizando dados no banco de dados
    $sql = "UPDATE Condominios SET nome=:nome, endereco=:endereco, numeroUnidades=:numeroUnidades, areasComuns=:areasComuns WHERE id=:id";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':endereco', $endereco);
    $stmt->bindParam(':numeroUnidades', $numeroUnidades, PDO::PARAM_INT);
    $stmt->bindParam(':areasComuns', $areasComuns);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    $stmt->execute();
    header("Location: ../listarCondominiosCadastrados.html");
    exit;
} else {
    // Buscando os dados atuais do condomínio para preencher o formulário
    $stmt = $conn->prepare("SELECT * FROM Condominios WHERE id=:id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    
    $condominio = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($condominio) {
        $nome = $condominio['nome'];
        $endereco = $condominio['endereco'];
        $numeroUnidades = $condominio['numeroUnidades'];
        $areasComuns = $condominio['areasComuns'];
    } else {
        die('Condomínio não encontrado');
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Condomínios</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-between">
                        <div class="logo">
                            <a href="painelindex.html">ACO ADM <br> &nbsp;&nbsp;&nbsp;&nbsp;Panel</a>
                        </div>
                        <div class="toggler">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <!--Menu Lateral da Página-->
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>

                        <li class="sidebar-item active ">
                            <a href="painelindex.html" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-building"></i>
                                <span>Condomínios</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="acoCadastrarCondominio.html">Cad. Condomínios</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="acoSolicitacoesPrediais.html">Sol. Prediais</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="acoHistoricoManutencoes.html">Hist. Manutenções</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-calculator"></i>
                                <span>Financeiro</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="component-alert.html">Cad. Condomínios</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="component-badge.html">Sol. Pediais</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="component-breadcrumb.html">Hist. Manutenções</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-mic"></i>
                                <span>Comunicação</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="component-alert.html">Cad. Condomínios</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="component-badge.html">Sol. Pediais</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="component-breadcrumb.html">Hist. Manutenções</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-title">Outras Opções</li>
                    </ul>
                </div>
                <!--Fim do Menu Lateral da Página-->
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <section>
                <!-- <div class="row g-4">
                    <h2>Alterar Cadastro de Condomínio</h2>
                    <div class="form-control mb-3">
                        <form method="post">
                            <label for="nome">Nome do Condomínio:</label><br>
                            <input class="form-control" type="text" id="nome" name="nome" value=" "><br><br>

                            <label for="endereco">Endereço:</label><br>
                            <input class="form-control" type="text" id="endereco" name="endereco" value=""><br><br>

                            <label for="numeroUnidades">Número de Unidades:</label><br>
                            <input class="form-control" type="number" id="numeroUnidades" name="numeroUnidades" value=""><br><br>

                            <text for="areasComuns">Áreas Comuns:</text><br>
                            <textarea class="form-control" id="areasComuns" name="areasComuns"></textarea><br><br>

                            <input class="btn btn-primary" type="submit" value="Alterar">
                        </form>
                    </div>
                </div> -->


                <section id="multiple-column-form">
                <div class="row match-height">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h1>Cadastro de Condomínios</h1>
                                <h4>&nbsp;Cadastre aqui os dados do novo condomínio.</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form class="form" method="post">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="first-name-column">Nome do Condomínio:</label>
                                                    <input type="text" id="first-name-column" class="form-control"
                                                        placeholder="Nome Condomínio" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="last-name-column">Endereço:</label>
                                                    <input type="text" id="last-name-column" class="form-control"
                                                        placeholder="Endereço" name="endereco" value="<?php echo htmlspecialchars($endereco); ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="city-column">Número de Unidades:</label>
                                                    <input type="number" id="city-column" class="form-control"
                                                        placeholder="N° de Unidades" name="unidades" value="<?php echo htmlspecialchars($numeroUnidades); ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group mb-3">
                                                    <label for="exampleFormControlTextarea1" class="form-label">Áreas
                                                        Comuns
                                                    </label>
                                                    <textarea class="form-control" name="areasComuns"
                                                        placeholder="Digite as áreas" id="exampleFormControlTextarea1"
                                                        rows="3"><?php echo htmlspecialchars($areasComuns); ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-end">
                                                <input class="btn btn-primary" type="submit"
                                                    value="Alterar">                                                
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            </section>

                <footer>
                    <div class="footer clearfix mb-0 text-muted">
                        <div class="float-start">
                            <p>2023 All Rigts Reserved &copy; <a href="https://www.acoadmcondominios.com.br" target="_blank">ACO Adm Condomínios</a></p>
                        </div>
                        <div class="float-end">
                            <p>Create <span class="text-primary"><i class="bi bi-house-door"></i></span> by <a href="www.bfsilva.com.br">Bruno Silva</a></p>
                        </div>
                    </div>
                </footer>
        </div>
    </div>
    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="assets/js/main.js"></script>
</body>

</html>