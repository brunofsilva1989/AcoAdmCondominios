<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cobrança Financeira</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.css">

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
                                <ul class="submenu ">
                                    <li class="submenu-item ">
                                        <a href="acoCadastrarCondominio.html">Cad. Condomínios</a>
                                    </li>
                                    <li class="submenu-item ">
                                        <a href="acoCadastrarCondominio.html">Cad. Clientes</a>
                                    </li>
                                    <li class="submenu-item ">
                                        <a href="acoSolicitacoesPrediais.html">Sol. Prediais</a>
                                    </li>
                                    <li class="submenu-item ">
                                        <a href="acoHistoricoManutencoes.html">Hist. Manutenções</a>
                                    </li>
                                </ul>
                            </ul>
                        </li>
                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-calculator"></i>
                                <span>Financeiro</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="acoCobrancaFinanceira.php">Cobranças</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="acoRelatoriosGeraisFin.html">Rel. Financeiros</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="acoSistemaEnvio.html">Sistema de Envio</a>
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

            <!--Emissão dos Boletos.-->
            <section id="multiple-column-form">
                <div class="row match-height">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h1>Solicitar Boleto</h1>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form action="geraBoleto.php" method="post">
                                        <!-- Dados do Boleto -->
                                        <h3>Dados do Boleto</h3>
                                        <label for="seuNumero">Seu Número:</label>
                                        <input type="text" class="form-control" name="seuNumero" required>

                                        <label for="valorNominal">Valor Nominal:</label>
                                        <input type="text" class="form-control" name="valorNominal" required>

                                        <label for="dataVencimento">Data de Vencimento:</label>
                                        <input type="date" class="form-control" name="dataVencimento" required><br>

                                        <!-- Dados do Pagador -->
                                        <h3>Dados do Pagador</h3>
                                        <label for="cliente_id">Cliente:</label>
                                        <select id="clienteSelect" class="form-control" name="cliente_id" required onchange="preencherCampos()">
                                            <?php include 'PHP/Financeiro/buscarClientes.php'; ?>
                                        </select>

                                        <!-- Campos que serão preenchidos automaticamente -->
                                        <label for="nome">Nome:</label>
                                        <input type="text" id="nomePagador" class="form-control" name="nome" value="<?php echo $cliente['nome']; ?>" required>

                                        <label for="endereco">Endereco:</label>
                                        <input type="text" id="logradouroPagador" class="form-control" name="endereco" value="<?php echo $cliente['endereco']; ?>" required><br>

                                        <label for="numero">Número:</label>
                                        <input type="text" class="form-control" name="numero" value="<?php echo $cliente['numero']; ?>" required><br>

                                        <label for="bairro">Bairro:</label>
                                        <input type="text" class="form-control" name="bairro" value="<?php echo $cliente['bairro']; ?>" required><br>

                                        <label for="cidade">Cidade:</label>
                                        <input type="text" class="form-control" name="cidade" value="<?php echo $cliente['cidade']; ?>" required><br>

                                        <label for="estado">Estado (UF):</label>
                                        <input type="text" class="form-control" name="estado" maxlength="2" value="<?php echo $cliente['estado']; ?>" required><br>

                                        <label for="cep">CEP:</label>
                                        <input type="text" class="form-control" name="cep" value="<?php echo $cliente['cep']; ?>" required><br>

                                        <input type="submit" class="btn btn-light-secondary me-1 mb-1" value="Gerar Boleto">
                                    </form>

                                    <!-- Este input armazena os dados dos clientes em formato JSON -->
                                    <input type="hidden" id="clientesData" value='<?php echo fetchClientesData(); ?>'>

                                    <div class="card">
                                        <div class="card-header text-center">
                                            <h1>Boletos Gerados</h1>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-striped" id="dados-boletos">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Nome</th>
                                                        <th>Valor</th>
                                                        <th>Descrição</th>
                                                        <th>Data Vencimento</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="dados-boletos">
                                                    <!--Aqui vai ser carregado os dados do condominio cadastrado-->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div id="mensagem"></div>
            <!--Padrão Fim-->

            <!--Tabela com condominios Cadastrados-->

            <!--Fim da Tabela com condominios Cadastrados-->



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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="assets/js/main.js"></script>

    <script>
        function preencherCampos() {
            var clientes = JSON.parse(document.getElementById("clientesData").value);
            var clienteSelecionado = document.getElementById("clienteSelect").value;

            for (var i = 0; i < clientes.length; i++) {
                if (clientes[i].id == clienteSelecionado) {
                    // Aqui, ajuste de acordo com os campos da sua tabela Cliente
                    document.getElementById("nomePagador").value = clientes[i].nome;
                    document.getElementById("logradouroPagador").value = clientes[i].logradouro;
                    //... Continue preenchendo os outros campos
                }
            }
        }

        //Integração API para os Boletos
        // document.getElementById('gerarBoletoForm').addEventListener('submit', async (e) => {
        //     e.preventDefault();

        //     const nome = document.getElementById('nome').value;
        //     const valor = document.getElementById('valor').value;
        //     const vencimento = document.getElementById('vencimento').value;
        //     const mensagemDiv = document.getElementById('mensagem');

        //     try {
        //         const response = await fetch('/PHP/Financeiro/criarBoleto.php', {
        //             method: 'POST',
        //             headers: {
        //                 'Content-Type': 'application/json',
        //             },
        //             body: JSON.stringify({
        //                 nome,
        //                 valor,
        //                 vencimento
        //             }),
        //         });

        //         const data = await response.json();
        //         console.log(data);

        //         if (response.ok) {
        //             if (data.sucesso) {
        //                 mensagemDiv.textContent = 'Boleto criado com sucesso!';
        //                 mensagemDiv.style.color = 'green';

        //                 // Limpar o formulário ou outras ações necessárias
        //                 document.getElementById('gerarBoletoForm').reset();
        //             } else {
        //                 mensagemDiv.textContent = 'Erro: ' + data.mensagem;
        //                 mensagemDiv.style.color = 'red';
        //             }
        //         } else {
        //             console.error('Erro na resposta do servidor:', data);
        //             mensagemDiv.textContent = 'Erro ao comunicar com o servidor. Por favor, tente novamente mais tarde.';
        //             mensagemDiv.style.color = 'red';
        //         }
        //     } catch (error) {
        //         console.error('Erro ao fazer a requisição:', error);
        //         mensagemDiv.textContent = 'Ocorreu um erro inesperado. Por favor, tente novamente mais tarde.';
        //         mensagemDiv.style.color = 'red';
        //     }
        // });

        // //Integração API para os Boletos com Jquery
        $(document).ready(function() {
            $('#gerarBoletoForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: '/PHP/Financeiro/criarBoleto.php',
                    type: 'POST',
                    dataType: 'json',
                    data: $('#gerarBoletoForm').serialize(),
                    success: function(data) {
                        console.log(data);
                        if (data.sucesso) {
                            $('#mensagem').html('Boleto criado com sucesso!');
                            $('#mensagem').css('color', 'green');
                            $('#gerarBoletoForm').trigger('reset');
                        } else {
                            $('#mensagem').html('Erro: ' + data.mensagem);
                            $('#mensagem').css('color', 'red');
                        }
                    },
                    error: function(data) {
                        console.error('Erro na resposta do servidor:', data);
                        $('#mensagem').html('Erro ao comunicar com o servidor. Por favor, tente novamente mais tarde.');
                        $('#mensagem').css('color', 'red');
                    }
                });
            });
        });


        //Chamar os boletos na tela 
        $(document).ready(function() {
            function renderTable() {
                $.ajax({
                    url: '/PHP/Financeiro/listarBoletos.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var tbody = $('#dados-boletos tbody');
                        tbody.empty();
                        data.forEach(function(boletos) {
                            const row = `<tr>
                            <td>${boletos.id}</td>                                                                
                            <td>${boletos.nome}</td>
                            <td>${boletos.valor}</td>
                            <td>${boletos.vencimento}</td>                            
                            <td>
                                <button class="btn btn-primary btn-sm" onclick="imprimir(${boletos.id})">Imprimir</button>
                                <button class="btn btn-secondary btn-sm" onclick="salvar(${boletos.id})">Salvar</button>                                
                            </td>
                        </tr>`;
                            tbody.append(row);
                        });
                    },
                    error: function(error) {
                        console.error('Erro na solicitação AJAX:', error);
                        window.location.href = '/acoCobrancaFinanceira.html';
                    }
                });
            }
            renderTable();
        });


        //Imprimir Boleto

        $(document).ready(function() {
            function imprimir(id) {
                // Supondo que cada boleto tem um ID único e você pode obter os detalhes via AJAX
                $.ajax({
                    url: '/PHP/Financeiro/getBoleto.php', // Ajuste a URL conforme necessário
                    type: 'POST',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(data) {
                        const mywindow = window.open('', 'PRINT', 'height=400,width=600');
                        mywindow.document.write('<html><head><title>' + document.title + '</title>');
                        mywindow.document.write('</head><body >');
                        mywindow.document.write('<h1>' + document.title + '</h1>');
                        mywindow.document.write(data); // Supondo que data contém os detalhes do boleto formatados para impressão
                        mywindow.document.write('</body></html>');

                        mywindow.document.close(); // necessário para IE >= 10
                        mywindow.focus(); // necessário para IE >= 10*/

                        mywindow.print();
                        mywindow.close();
                    },
                    error: function(error) {
                        console.error('Não foi possível recuperar os detalhes do boleto', error);
                    }
                });
            }

            function salvar(id) {
                // Aqui, por exemplo, você pode enviar uma solicitação para o servidor para salvar o boleto como um arquivo PDF ou algo semelhante
                window.location.href = '/PHP/Financeiro/salvarBoleto.php?id=' + id; // Supondo que salvarBoleto.php gere um arquivo e inicie um download
            }

            function renderTable() {
                // O seu código existente...
            }

            renderTable();
        });
    </script>
</body>

</html>