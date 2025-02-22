<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACO ADM CONDOMÍNIOS</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.css">


    <link rel="stylesheet" href="assets/vendors/iconly/bold.css">

    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="shortcut icon" href="aco.ico" type="image/x-icon">
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
                            <a href="painelindex.html" class='sidebar-link'>
                                <i class="bi bi-building"></i>
                                <span>Condomínios</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="acoCadastrarCondominio.html">Cad. Condomínios</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="acoCadastrarClientes.html">Cad. Clientes</a>
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
                                    <a href="acoCobrancaFinanceira.php">Boletos</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="acoCobrancaBoletoPix.php">Boletos com Pix</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="acoRelatoriosGeraisFin.html">Relatórios</a>

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
                                    <a href="acoDocumentosCondomínio.html">Cad. Condomínios</a>
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
                                <i class="bi bi-cloud-arrow-up-fill"></i>
                                <span>Documentos</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="acoDocumentosCondominio.html">Docs. Condomínio</a>
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
                <button class="sidebar-toggler btn x">TESTE<i data-feather="x"></i></button>
            </div>
        </div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>



            <section id="multiple-column-form">
                <div class="row match-height">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h1>Cadastro de Clientes</h1>
                                <h4>Cadastro de cliente para emissão de Boletos</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <h2>Gerar Boleto com Pix</h2>
                                    <form action="gerar_boleto.php" method="post">
                                        <div>
                                            <label for="seuNumero">Seu Número:</label>
                                            <input type="text" id="seuNumero" class="form-control" name="seuNumero" required>
                                        </div>
                                        <div>
                                            <label for="valorNominal">Valor Nominal:</label>
                                            <input type="number" id="valorNominal" class="form-control" name="valorNominal" step="0.01" required>
                                        </div>
                                        <div>
                                            <label for="dataVencimento">Data de Vencimento:</label>
                                            <input type="date" id="dataVencimento" class="form-control" name="dataVencimento" required>
                                        </div>
                                        <div>
                                            <label for="numDiasAgenda">Número de Dias para Agenda:</label>
                                            <input type="number" id="numDiasAgenda" class="form-control" name="numDiasAgenda" required>
                                        </div>
                                        <!-- Incluir outros campos conforme necessário -->
                                        <div>
                                            <button type="submit">Gerar Boleto</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


















        </div>
    </div>

    <!--Footer-->
    <footer class="">
        <div class="footer clearfix mb-0 text-muted">
            <div class="float-start">
                <p>2021 &copy; Mazer</p>
            </div>
            <div class="float-end">
                <p>Create <span class="text-danger"><i class="bi bi-heart"></i></span> by <a href="www.bfsilva.com.br">Bruno Silva</a></p>
            </div>
        </div>
    </footer>
    <!--End Footer-->

    </div>
    </div>
    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script src="assets/vendors/apexcharts/apexcharts.js"></script>
    <script src="assets/js/pages/dashboard.js"></script>

    <script src="assets/js/main.js"></script>
</body>

</html>