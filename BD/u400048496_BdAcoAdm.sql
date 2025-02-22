-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 20/02/2025 às 00:53
-- Versão do servidor: 10.11.10-MariaDB
-- Versão do PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `u400048496_BdAcoAdm`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `balancetes`
--

CREATE TABLE `balancetes` (
  `id` int(11) NOT NULL,
  `condominio_id` int(11) DEFAULT NULL,
  `mes` int(11) DEFAULT NULL,
  `ano` int(11) DEFAULT NULL,
  `saldo_inicial` decimal(10,2) DEFAULT NULL,
  `saldo_final` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `boletos`
--

CREATE TABLE `boletos` (
  `id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','in_process','approved','cancelled','rejected') DEFAULT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_vencimento` date DEFAULT NULL,
  `boleto_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `caixa_condominios`
--

CREATE TABLE `caixa_condominios` (
  `id` int(11) NOT NULL,
  `condominio_id` int(11) DEFAULT NULL,
  `caixa_mes_anterior` decimal(10,2) DEFAULT NULL,
  `mes_referencia` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `cpf_cnpj` varchar(20) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `complemento` varchar(255) DEFAULT NULL,
  `bairro` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `estado` varchar(2) NOT NULL,
  `cep` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `condominio_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Condominios`
--

CREATE TABLE `condominios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `numeroUnidades` int(11) NOT NULL,
  `areasComuns` text NOT NULL,
  `cidade` varchar(255) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `documentos`
--

CREATE TABLE `documentos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `caminho` varchar(255) DEFAULT NULL,
  `data_upload` timestamp NOT NULL DEFAULT current_timestamp(),
  `condominio_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `documentos`
--

INSERT INTO `documentos` (`id`, `nome`, `tipo`, `caminho`, `data_upload`, `condominio_id`) VALUES
(55, '1703210845_Profile', 'application/pdf', './arquivos/1703210845_Profile.pdf', '2023-12-22 02:07:42', NULL),
(56, '1703213106_proposta', 'application/pdf', 'C:\\xampp\\htdocs\\PHP\\Documentos\\arquivos/1703213106_proposta.pdf', '2023-12-22 02:45:23', NULL),
(57, '1703381446_Relatório', 'application/pdf', 'C:\\xampp\\htdocs\\PHP\\Documentos\\arquivos/1703381446_Relatório.pdf', '2023-12-23 20:24:32', NULL),
(58, '1703381852_Relatório2', 'application/pdf', '../../arquivos/1703381852_Relatório2.pdf', '2023-12-23 20:31:18', NULL),
(59, '1703363747_Relatório3', 'application/pdf', '../../arquivos/1703363747_Relatório3.pdf', '2023-12-23 20:35:47', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `entradas`
--

CREATE TABLE `entradas` (
  `id` int(11) NOT NULL,
  `condominio_id` int(11) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `data_entrada` date DEFAULT NULL,
  `tipo_pagamento` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `categoria` varchar(255) DEFAULT NULL,
  `data_pagamento` date DEFAULT NULL,
  `posicao_boleto` varchar(255) DEFAULT NULL,
  `valor_recebido` decimal(10,2) DEFAULT NULL,
  `observacao` varchar(500) DEFAULT NULL,
  `morador_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `fluxo_caixa`
--

CREATE TABLE `fluxo_caixa` (
  `id` int(11) NOT NULL,
  `condominio_id` int(11) NOT NULL,
  `saldo_mes_anterior` decimal(10,2) NOT NULL,
  `saldo_atual` decimal(10,2) NOT NULL,
  `data_referencia` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `HistoricoManutencoes`
--

CREATE TABLE `HistoricoManutencoes` (
  `id` int(11) NOT NULL,
  `dataManutencao` date NOT NULL,
  `responsavel` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `custo` decimal(10,2) NOT NULL,
  `dataConclusao` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `HistoricoManutencoes`
--

INSERT INTO `HistoricoManutencoes` (`id`, `dataManutencao`, `responsavel`, `descricao`, `custo`, `dataConclusao`) VALUES
(1, '0000-00-00', 'Bruno Silva', 'Serviço de troca de lâmpadas, do salão de festas.', 150.00, '0000-00-00'),
(2, '0000-00-00', 'Bruno ', 'Troca de torneira entrada principal ', 100.00, '0000-00-00'),
(3, '0000-00-00', 'BEAN', 'Troca de computador da recepção', 250.00, '0000-00-00'),
(4, '0000-00-00', 'Pedro Henrique', 'Precisa de ajustes na iluminação da área de beleza, a pedidos a esteticista Jessica Silva', 0.00, '0000-00-00'),
(5, '0000-00-00', 'Bruno', 'Arrumar Câmeras', 50.00, '0000-00-00'),
(6, '0000-00-00', 'Ferreira Martins', 'Teste de Solicitação', 200.00, '0000-00-00'),
(7, '0000-00-00', 'Bruno', 'Teste', 150.00, '0000-00-00'),
(8, '0000-00-00', 'Bruno', 'Teste', 15.00, '0000-00-00'),
(9, '2023-10-12', 'Mario', 'Rede elétrica da quadra, irá ser trocada', 500.00, '0000-00-00'),
(10, '2023-10-13', 'Mario', 'Rede eletrica quadra', 500.00, '0000-00-00'),
(11, '2023-10-13', 'Arthur', '', 0.00, '0000-00-00'),
(15, '2023-10-21', 'Bruno Silva', 'Troca de galões de agua', 600.00, '0000-00-00'),
(16, '2023-10-14', 'Pedro', 'Trocar porta da entrada', 500.00, '0000-00-00'),
(17, '2023-10-21', 'Diego', 'Troca do azulejo da piscina', 200.00, '0000-00-00'),
(19, '2023-11-04', 'Bruno Silva', 'Troca de torneira do Cond. Lar 1', 50.00, '0000-00-00'),
(20, '2023-10-31', 'Rodolfo', 'Troca do extintor da Ap 1 cond novo lar', 100.00, '0000-00-00'),
(24, '2023-11-30', 'Rodrigo Silva', 'Troca de Camera', 100.00, '0000-00-00'),
(25, '2023-11-24', 'Bruno Silva', 'Troca de Pc', 250.00, '0000-00-00'),
(27, '2023-11-28', 'Rodrigo Silva', 'troca de antena ', 100.00, '0000-00-00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `ManutencoesPrediais`
--

CREATE TABLE `ManutencoesPrediais` (
  `id` int(11) NOT NULL,
  `dataManutencao` date NOT NULL,
  `responsavel` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `custo` decimal(10,2) NOT NULL,
  `statusManutencao` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `ManutencoesPrediais`
--

INSERT INTO `ManutencoesPrediais` (`id`, `dataManutencao`, `responsavel`, `descricao`, `custo`, `statusManutencao`) VALUES
(28, '2023-12-18', 'Bruno Silva', 'Ajuste nas câmeras', 150.00, 'concluida');

-- --------------------------------------------------------

--
-- Estrutura para tabela `moradores`
--

CREATE TABLE `moradores` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `condominio_id` int(11) DEFAULT NULL,
  `unidade` varchar(255) DEFAULT NULL,
  `observacao` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(100) NOT NULL,
  `expira_em` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `propostas`
--

CREATE TABLE `propostas` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `unidades` int(11) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `cidade_estado` varchar(255) DEFAULT NULL,
  `como_conheceu` varchar(255) DEFAULT NULL,
  `plano` varchar(255) DEFAULT NULL,
  `mensagem` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `saidas`
--

CREATE TABLE `saidas` (
  `id` int(11) NOT NULL,
  `condominio_id` int(11) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `data_saida` date DEFAULT NULL,
  `tipo_pagamento` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `categoria` varchar(255) DEFAULT NULL,
  `observacao` varchar(500) DEFAULT NULL,
  `morador_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `transacoes_detalhadas`
--

CREATE TABLE `transacoes_detalhadas` (
  `id` int(11) NOT NULL,
  `tipo_transacao` enum('entrada','saida') NOT NULL,
  `condominio_id` int(11) NOT NULL,
  `morador_id` int(11) DEFAULT NULL,
  `categoria` varchar(255) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `valor_recebido` decimal(10,2) DEFAULT NULL,
  `valor_receber` decimal(10,2) DEFAULT NULL,
  `data_transacao` date NOT NULL,
  `atividades_admin` text DEFAULT NULL,
  `status_pagamento` enum('pendente','pago','parcial','cancelado') NOT NULL DEFAULT 'pendente',
  `data_vencimento` date DEFAULT NULL,
  `data_pagamento` date DEFAULT NULL,
  `caixa_mes_anterior` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `Users`
--

INSERT INTO `Users` (`id`, `username`, `password`, `createdAt`, `updatedAt`) VALUES
(1, 'testuser', '$2b$10$jKD4sXuCHYifPF2Ki69ue.3fa6eWnKH4xwNM1R7t2Lu.f4v2oWL/i', '2023-10-06 02:13:03', '2023-10-06 02:13:03'),
(2, 'brunosilva', '$2b$10$UrYbxNPiFf2BHL56/Fbtj.tWO4EpoP9.CA7aLdeWo/83ACUP30WNG', '2023-10-06 03:10:23', '2023-10-06 03:10:23');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `senha` varchar(255) DEFAULT NULL,
  `tipo` enum('admin','usuario','cliente') DEFAULT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `condominio_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `created_at`, `updated_at`, `senha`, `tipo`, `cliente_id`, `condominio_id`) VALUES
(1, 'Bruno Ferreira da Silva ', 'suporte.bfs@gmail.com', '2023-11-01 02:23:13', '2024-07-31 14:01:08', '123', 'admin', NULL, NULL),
(2, 'Ana Carolina', 'anacarolina@acoadmcondominios.com.br', '2023-11-07 02:07:16', '2023-11-07 02:07:16', '$2y$10$sbovGtI/tekN56xYMevLPe.uHgJxgaA9/t.jzK6uqQgwXcwv7cDh2', 'usuario', NULL, NULL),
(3, 'Aline', 'aline@acoadmcondominios.com.br', '2023-11-07 02:07:43', '2023-11-07 02:07:43', '$2y$10$0Rg3cbLreN77WuVbq7vX..ZNWRtA5fMBhbwJ.lQ2/n2EsETE2056i', 'usuario', NULL, NULL),
(4, 'Breno Silva', 'brenosilva@gmail.com', '2023-12-22 21:50:10', '2023-12-22 21:50:10', '$2y$10$KRwKml1jkc3MAqC8Xb9jReMIPKkyLLY/VP2FDRcKfQS5XXifuYNMC', 'usuario', NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `balancetes`
--
ALTER TABLE `balancetes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_condominio_balancetes` (`condominio_id`);

--
-- Índices de tabela `boletos`
--
ALTER TABLE `boletos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `caixa_condominios`
--
ALTER TABLE `caixa_condominios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `condominio_id` (`condominio_id`);

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `Condominios`
--
ALTER TABLE `Condominios`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `entradas`
--
ALTER TABLE `entradas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_condominio_entradas` (`condominio_id`),
  ADD KEY `morador_id` (`morador_id`);

--
-- Índices de tabela `fluxo_caixa`
--
ALTER TABLE `fluxo_caixa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `condominio_id` (`condominio_id`);

--
-- Índices de tabela `HistoricoManutencoes`
--
ALTER TABLE `HistoricoManutencoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `ManutencoesPrediais`
--
ALTER TABLE `ManutencoesPrediais`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `moradores`
--
ALTER TABLE `moradores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `condominio_id` (`condominio_id`);

--
-- Índices de tabela `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `propostas`
--
ALTER TABLE `propostas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `saidas`
--
ALTER TABLE `saidas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_condominio_saidas` (`condominio_id`),
  ADD KEY `morador_id` (`morador_id`);

--
-- Índices de tabela `transacoes_detalhadas`
--
ALTER TABLE `transacoes_detalhadas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `condominio_id` (`condominio_id`),
  ADD KEY `morador_id` (`morador_id`);

--
-- Índices de tabela `Users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `condominio_id` (`condominio_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `balancetes`
--
ALTER TABLE `balancetes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `boletos`
--
ALTER TABLE `boletos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `caixa_condominios`
--
ALTER TABLE `caixa_condominios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de tabela `Condominios`
--
ALTER TABLE `condominios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de tabela `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de tabela `entradas`
--
ALTER TABLE `entradas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `fluxo_caixa`
--
ALTER TABLE `fluxo_caixa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `HistoricoManutencoes`
--
ALTER TABLE `historico_manutencoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `ManutencoesPrediais`
--
ALTER TABLE `manutencoes_prediais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `moradores`
--
ALTER TABLE `moradores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `propostas`
--
ALTER TABLE `propostas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `saidas`
--
ALTER TABLE `saidas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `transacoes_detalhadas`
--
ALTER TABLE `transacoes_detalhadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `Users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `balancetes`
--
ALTER TABLE `balancetes`
  ADD CONSTRAINT `fk_condominio_balancetes` FOREIGN KEY (`condominio_id`) REFERENCES `Condominios` (`id`);

--
-- Restrições para tabelas `caixa_condominios`
--
ALTER TABLE `caixa_condominios`
  ADD CONSTRAINT `caixa_condominios_ibfk_1` FOREIGN KEY (`condominio_id`) REFERENCES `Condominios` (`id`);

--
-- Restrições para tabelas `entradas`
--
ALTER TABLE `entradas`
  ADD CONSTRAINT `entradas_ibfk_1` FOREIGN KEY (`morador_id`) REFERENCES `moradores` (`id`),
  ADD CONSTRAINT `fk_condominio_entradas` FOREIGN KEY (`condominio_id`) REFERENCES `Condominios` (`id`);

--
-- Restrições para tabelas `fluxo_caixa`
--
ALTER TABLE `fluxo_caixa`
  ADD CONSTRAINT `fluxo_caixa_ibfk_1` FOREIGN KEY (`condominio_id`) REFERENCES `Condominios` (`id`);

--
-- Restrições para tabelas `moradores`
--
ALTER TABLE `moradores`
  ADD CONSTRAINT `moradores_ibfk_1` FOREIGN KEY (`condominio_id`) REFERENCES `Condominios` (`id`);

--
-- Restrições para tabelas `saidas`
--
ALTER TABLE `saidas`
  ADD CONSTRAINT `fk_condominio_saidas` FOREIGN KEY (`condominio_id`) REFERENCES `Condominios` (`id`),
  ADD CONSTRAINT `saidas_ibfk_1` FOREIGN KEY (`morador_id`) REFERENCES `moradores` (`id`);

--
-- Restrições para tabelas `transacoes_detalhadas`
--
ALTER TABLE `transacoes_detalhadas`
  ADD CONSTRAINT `transacoes_detalhadas_ibfk_1` FOREIGN KEY (`condominio_id`) REFERENCES `Condominios` (`id`),
  ADD CONSTRAINT `transacoes_detalhadas_ibfk_2` FOREIGN KEY (`morador_id`) REFERENCES `moradores` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
