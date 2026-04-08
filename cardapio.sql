-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17/03/2026 às 15:05
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
(2, 'Sashimis'),
(3, 'Sushis e Niguiris'),
(4, 'Rolls & Especiais'),
(5, 'Experiência Wabi Sabi'),
(6, 'Pratos Quentes'),
(7, 'Bebidas');

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
(1, 'samuwl', 'Pepino japonês laminado marinado em molho agridoce artesanal, finalizado com gergelim tostado.', 1, 'Porção individual', 24),
(2, 'Sunomono Especial', 'Pepino japonês, kani selecionado e camarões levemente cozidos em marinada cítrica equilibrada.', 1, 'Porção individual', 38),
(3, 'Missoshiru Tradicional', 'Caldo leve à base de missô, tofu delicado, cebolinha fresca e alga wakame.', 1, '300ml', 22),
(4, 'Shimeji na Manteiga', 'Cogumelos frescos salteados lentamente na manteiga e shoyu especial.', 1, 'Porção individual', 42),
(5, 'Sashimi de Salmão', 'Cortes frescos de salmão selecionado diariamente.', 2, '8 unidades', 68),
(6, 'Sashimi de Atum', 'Atum fresco com corte preciso e sabor marcante.', 2, '8 unidades', 79),
(7, 'Sashimi Peixe Branco', 'Peixe branco fresco conforme sazonalidade.', 2, '8 unidades', 72),
(8, 'Niguiri de Salmão', 'Salmão fresco sobre arroz temperado artesanalmente.', 3, '2 unidades', 28),
(9, 'Niguiri de Atum', 'Atum selecionado sobre arroz moldado à mão.', 3, '2 unidades', 32),
(10, 'Joe de Salmão', 'Arroz envolto em salmão e finalizado com cream cheese.', 3, '2 unidades', 34),
(11, 'Philadelphia Especial', 'Salmão fresco e cream cheese com acabamento delicado.', 4, '8 unidades', 64),
(12, 'Hot Roll da Casa', 'Salmão e cream cheese empanados e fritos levemente.', 4, '8 unidades', 58),
(13, 'Uramaki Especial Wabi Sabi', 'Combinação exclusiva da casa equilibrando textura e frescor.', 4, '8 unidades', 72),
(14, 'Seleção do Itamae', 'Seleção especial do chef com cortes variados e frescos.', 5, '20 peças', 129),
(15, 'Seleção Especial', 'Variedade refinada ideal para compartilhar.', 5, '30 peças', 189),
(16, 'Degustação Wabi Sabi', 'Experiência completa com destaques da casa.', 5, '50 peças', 299);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Índices de tabela `pratos`
--
ALTER TABLE `pratos`
  ADD PRIMARY KEY (`id_prato`),
  ADD KEY `fk_pratos_categoria` (`id_categoria`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `pratos`
--
ALTER TABLE `pratos`
  MODIFY `id_prato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
