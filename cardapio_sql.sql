-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Tempo de geração: 15/05/2026 às 12:40
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `cardapio`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `nome_categoria` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nome_categoria`) VALUES
(1, 'Entradas'),
(2, 'Sushis Tradicionais'),
(3, 'Hossomaki'),
(4, 'Uramaki'),
(5, 'Sashimis'),
(6, 'Temakis'),
(7, 'Hot Rolls'),
(8, 'Pratos Renomados'),
(9, 'Supremos'),
(10, 'Sem álcool'),
(11, 'Alcoólicas'),
(12, 'Combinados');

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id_funcionario` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cargo` varchar(50) DEFAULT 'cozinheiro',
  `senha` varchar(255) NOT NULL,
  `ativo` tinyint(4) DEFAULT 1,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `funcionarios`
--

INSERT INTO `funcionarios` (`id_funcionario`, `nome`, `email`, `cargo`, `senha`, `ativo`, `data_cadastro`) VALUES
(4, 'Chef Administrador', 'chef@wabisabi.com', 'chef', '$2y$10$/55LWrcGb/Nkr/.QZC1hbOKzq5cE84/NN9wb2Dnr30ly6G6ZgUzz.', 1, '2026-05-15 10:15:42'),
(5, 'Cozinheiro', 'matheus@wabisabi.com', 'cozinheiro', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, '2026-05-15 10:15:42');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `numero_pedido` varchar(20) NOT NULL,
  `itens` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`itens`)),
  `subtotal` decimal(10,2) NOT NULL,
  `desconto` decimal(10,2) DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL,
  `forma_pagamento` varchar(50) DEFAULT NULL,
  `status` varchar(30) DEFAULT 'pendente',
  `observacoes` text DEFAULT NULL,
  `data_pedido` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `id_usuario`, `numero_pedido`, `itens`, `subtotal`, `desconto`, `total`, `forma_pagamento`, `status`, `observacoes`, `data_pedido`) VALUES
(4, 5, 'PED-6A0225D671E08', '[{\"nome\":\"Teppan de salm\\u00e3o, +Cebolinha, +Teriaki, Troca: Camar\\u00e3o\",\"quantidade\":1,\"preco\":115},{\"nome\":\"Mega supremo 700g, +Shoyu, +Teriaki\",\"quantidade\":1,\"preco\":129}]', 244.00, 12.20, 231.80, 'Pix', 'pendente', '', '2026-05-11 18:54:14');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedido_status_log`
--

CREATE TABLE `pedido_status_log` (
  `id_log` int(11) NOT NULL,
  `id_pedido` int(11) DEFAULT NULL,
  `status_anterior` varchar(30) DEFAULT NULL,
  `status_novo` varchar(30) DEFAULT NULL,
  `alterado_por` varchar(100) DEFAULT NULL,
  `data_alteracao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pedido_status_log`
--

INSERT INTO `pedido_status_log` (`id_log`, `id_pedido`, `status_anterior`, `status_novo`, `alterado_por`, `data_alteracao`) VALUES
(6, 4, NULL, 'pendente', 'Nivea', '2026-05-11 18:54:14');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pratos`
--

CREATE TABLE `pratos` (
  `id_prato` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `quantidade` varchar(20) NOT NULL,
  `preco` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pratos`
--

INSERT INTO `pratos` (`id_prato`, `nome`, `descricao`, `id_categoria`, `quantidade`, `preco`) VALUES
(1, 'Sunomono', 'Pepino, molho agridoce e gergelim', 1, 'Porção individual', 16),
(2, 'Edamame', 'Vagem de soja cozida e sal', 1, 'Porção individual', 14),
(3, 'Guioza', 'Massa oriental, recheio de carne ou frango e temperos', 1, '6 un', 22),
(4, 'Harumaki', 'Massa crocante, recheio de legumes, queijo ou camarão', 1, '6 un', 22),
(5, 'Shimeji na Manteiga', 'Cogumelos frescos salteados lentamente na manteiga e shoyu especial.', 1, 'Porção individual', 24),
(6, 'Nigiri de Salmão', 'Arroz japonês e fatia de salmão por cima', 2, '6 un', 18),
(7, 'Nigiri de Atum', 'Arroz japonês e fatia de atum por cima', 2, '6 un', 18),
(8, 'Joy Salmão', 'Arroz japonês e cream chease envolto de salmão fresco', 2, '8 un', 22),
(9, 'Gunkan Salmão', 'Arroz japonês e salmão cremoso envolto da alga nori', 2, '8 un', 20),
(10, 'Hossomaki de Salmão', 'Alga nori, arroz japonês e salmão', 3, '6 un', 28),
(11, 'Hossomaki de kani', 'Alga nori, arroz japonês e kani', 3, '6 un', 26),
(12, 'Hossomaki de Pepino', 'Alga nori, arroz japonês e pepino', 3, '6 un', 22),
(13, 'Uramaki de Salmão', 'Arroz por fora, alga nori por dentro e salmao', 4, '8 un', 32),
(14, 'Uramaki de Camarão', 'Arroz por fora, alga nori por dentro e camarão', 4, '8 un', 34),
(15, 'Uramaki de Kani', 'Arroz por fora, alga nori por dentro e kani', 4, '8 un', 30),
(16, 'Philadelphia', 'Arroz por fora, alga nori por dentro, salmão e cream chease', 4, '8 un', 38),
(17, 'Skin', 'Arroz por fora, alga nori por dentro, skin crocante e cream chease', 4, '8 un', 34),
(18, 'Sashimi de salmão', 'Fatias de salmão cru', 5, '5 uni', 32),
(19, 'Sashimi de atum', 'Fatias de atum cru', 5, '5 uni', 34),
(20, 'Sashimi misto', '3 fatias de salmão cru, 3 fatias de atum cru e 3 fatias de peixe branco cru', 5, '9 uni', 48),
(21, 'Temaki de salmão', 'Alga nori, arroz japonês e cubos de salmão', 6, '1 uni', 22),
(22, 'Temaki de salmão cream cheese', 'Alga nori, arroz japonês, salmão e cream cheese', 6, '1 uni', 24),
(23, 'Temaki de camarão', 'Alga nori, arroz japonês e camarão', 6, '1 uni', 24),
(24, 'Temaki de kani', 'Alga nori, arroz japonês, kani e cream cheese', 6, '1 uni', 22),
(25, 'Temaki skin', 'Alga nori, arroz japonês , skin crocante e cream cheese', 6, '1 uni', 24),
(26, 'Temaki califórnia', 'Alga nori, arroz japonês, manga, pepino e kani', 6, '1 uni', 22),
(27, 'Hot roll salmão', 'Alga nori, arroz japonês e salmão, empanado na farinha panko e frito no óleo', 7, '8 uni', 32),
(28, 'Hot roll camarão', 'Arroz japonês, alga nori e camarão, empanado na farinha panko e frito no óleo', 7, '8 uni', 34),
(29, 'Hot roll kani', 'Arroz japonês, alga nori e kani, empanado na farinha panko e frito no óleo', 7, '8 uni', 32),
(30, 'Teppan de salmão', 'Salmão grelhado, legumes e molho especial', 8, 'Porção individual', 52),
(31, 'Teppan de camarão', 'Camarão grelhado, legumes e molho especial', 8, 'Porção individual', 54),
(32, 'Yakissoba', 'Macarrão oriental, legumes e proteína à escolha', 8, 'Porção individual', 38),
(33, 'Mega supremo 1,5kg', 'Manta de salmão maçaricado recheada com pasta de kani, mix de peixes fritos, cream cheese, arroz, camarão empanado, regado ao molho teriyaki, gergelim e cebolinha.', 9, '1,5 kg', 89),
(34, 'Mega supremo 700g', 'Manta de salmão maçaricado recheada com pasta de kani, mix de peixes fritos, cream cheese, arroz, camarão empanado, regado ao molho teriyaki, gergelim e cebolinha.', 9, '700g', 63),
(35, 'Super Ebi 1,5kg', 'Manta de salmão maçaricado recheada com camarão empanado, cream cheese, arroz japonês e cebolinha, regado ao molho teriyaki.', 9, '1,5kg', 89),
(36, 'Super Ebi 700g', 'Manta de salmão maçaricado recheado com camarão empanado, cream cheese, arroz e cebolinha, regado ao molho teriyaki e gergelim.', 9, '700g', 63),
(37, 'Água mineral', 'Água sem gás', 10, '500ml', 4.5),
(38, 'Água gaseificada', 'Água com gás', 10, '500ml', 5),
(39, 'Refrigerantes Lata', 'Coca-cola; Guaraná; Antarctica; Fanta; Schweppes; Pepsi', 10, '350ml', 9),
(40, 'Sucos naturais', 'Maracujá; Limão; Laranja; Abacaxi; Acerola; Goiaba; Manga', 10, '350ml', 7),
(41, 'H2O', 'Limão ou Limoneto', 10, '500ml', 9),
(42, 'Saquê tradicional', 'Bebida japonesa de arroz fermentado', 11, '750ml', 24),
(43, 'Saquê Importado', 'Saquê premium japonês importado', 11, '750ml', 38),
(44, 'Heineken', 'Cerveja long neck', 11, '330ml', 12),
(45, 'Vinho branco', 'vinho reservado Sauvignon Blanc', 11, '750ml', 36),
(46, 'Vinho Rosé', 'Vinho reservado Sweet Rosé suave', 11, '750ml', 36),
(47, 'Sake Bomb Drink', 'Saquê, limão, xarope de gengibre e gelo', 11, '250ml', 26),
(48, 'Yuzu Spritz drink', 'Licor yuzu, espumante e fatia de limão', 11, '250ml', 28),
(49, 'Monte os seu - 20 peças', '5 uramaki + 5 hossomaki + 5 nigiris + 5 hot rolls', 12, '20 peças', 43),
(50, 'Monte o seu - 30 peças', '10 uramaki + 10 hot rolls + 5 nigiris + 5 hossomaki', 12, '30 peças', 54),
(51, 'Monte o seu - 40 peças + 1 Temaki', '10 Uramaki + 10 Hot Roll + 10 Hossomaki + 5 Joy + 5 Gunkan + 1 Temaki', 12, '40 peças', 75),
(52, 'Monte o seu - 50 peças + 2 Temakis', '10 Uramaki + 10 Hot Roll + 10 Hossomaki + 10 Philadelphia + 5 Joy + 5 Nigiri + 2 Temakis', 12, '50 peças', 115);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `endereco` text DEFAULT NULL,
  `senha` varchar(255) NOT NULL,
  `ativo` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome`, `email`, `telefone`, `endereco`, `senha`, `ativo`) VALUES
(5, 'Nivea', '12345678@gmail.com', '81999999999', 'Rua Amarela, Nº450', '$2y$10$6DrjTroZAyt930lOGQ0jEOhPtQohY7IgoscZ27LBCNXjDrLa7p5qO', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Índices de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id_funcionario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD UNIQUE KEY `numero_pedido` (`numero_pedido`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `pedido_status_log`
--
ALTER TABLE `pedido_status_log`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_pedido` (`id_pedido`);

--
-- Índices de tabela `pratos`
--
ALTER TABLE `pratos`
  ADD PRIMARY KEY (`id_prato`),
  ADD KEY `fk_pratos_categoria` (`id_categoria`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id_funcionario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `pedido_status_log`
--
ALTER TABLE `pedido_status_log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `pratos`
--
ALTER TABLE `pratos`
  MODIFY `id_prato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Restrições para tabelas `pedido_status_log`
--
ALTER TABLE `pedido_status_log`
  ADD CONSTRAINT `pedido_status_log_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
