-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2025 at 09:13 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projeto_estagios_2`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrativo`
--

CREATE TABLE `administrativo` (
  `utilizador_id` int(11) NOT NULL,
  `funcao` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administrativo`
--

INSERT INTO `administrativo` (`utilizador_id`, `funcao`) VALUES
(6, 'Secretariado'),
(7, 'Direção');

-- --------------------------------------------------------

--
-- Table structure for table `aluno`
--

CREATE TABLE `aluno` (
  `turma_id` int(11) NOT NULL,
  `utilizador_id` int(11) NOT NULL,
  `numero` int(11) DEFAULT NULL,
  `observacoes` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aluno`
--

INSERT INTO `aluno` (`turma_id`, `utilizador_id`, `numero`, `observacoes`) VALUES
(1, 1, 10, NULL),
(1, 2, 11, NULL),
(2, 3, 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `classificacao`
--

CREATE TABLE `classificacao` (
  `estabelecimento_empresa_id` int(11) NOT NULL,
  `estabelecimento_id` int(11) NOT NULL,
  `classificacao_id` int(11) NOT NULL,
  `ano_letivo` varchar(150) DEFAULT NULL,
  `media` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classificacao`
--

INSERT INTO `classificacao` (`estabelecimento_empresa_id`, `estabelecimento_id`, `classificacao_id`, `ano_letivo`, `media`) VALUES
(1, 1, 1, '2023/2024', 4.3),
(2, 1, 2, '2023/2024', 4),
(3, 1, 3, '2023/2024', 3.9);

-- --------------------------------------------------------

--
-- Table structure for table `comercializa`
--

CREATE TABLE `comercializa` (
  `estabelecimento_empresa_id` int(11) NOT NULL,
  `estabelecimento_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comercializa`
--

INSERT INTO `comercializa` (`estabelecimento_empresa_id`, `estabelecimento_id`, `produto_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `curso`
--

CREATE TABLE `curso` (
  `curso_id` int(11) NOT NULL,
  `codigo` varchar(150) DEFAULT NULL,
  `designacao` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `curso`
--

INSERT INTO `curso` (`curso_id`, `codigo`, `designacao`) VALUES
(1, 'INF01', 'Informática'),
(2, 'GEST01', 'Gestão'),
(3, 'CONT01', 'Contabilidade'),
(4, 'MKT01', 'Marketing'),
(5, 'DIR01', 'Direito'),
(6, 'SAU01', 'Saúde'),
(7, 'EDI01', 'Edificações');

-- --------------------------------------------------------

--
-- Table structure for table `disponibilidade`
--

CREATE TABLE `disponibilidade` (
  `empresa_id` int(11) NOT NULL,
  `disponibilidade_id` int(11) NOT NULL,
  `ano` int(11) DEFAULT NULL,
  `num_estagios` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disponibilidade`
--

INSERT INTO `disponibilidade` (`empresa_id`, `disponibilidade_id`, `ano`, `num_estagios`) VALUES
(1, 1, 2024, 3),
(2, 2, 2024, 2),
(3, 3, 2024, 4);

-- --------------------------------------------------------

--
-- Table structure for table `empresa`
--

CREATE TABLE `empresa` (
  `responsavel_id` int(11) DEFAULT NULL,
  `empresa_id` int(11) NOT NULL,
  `num_contribuinte` char(9) DEFAULT NULL,
  `firma` varchar(150) DEFAULT NULL,
  `morada_sede` varchar(150) DEFAULT NULL,
  `localidade` varchar(150) DEFAULT NULL,
  `codigo_postal` char(8) DEFAULT NULL,
  `telefone` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `website` varchar(150) DEFAULT NULL,
  `tipo_organizacao` varchar(150) DEFAULT NULL,
  `observacoes` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `empresa`
--

INSERT INTO `empresa` (`responsavel_id`, `empresa_id`, `num_contribuinte`, `firma`, `morada_sede`, `localidade`, `codigo_postal`, `telefone`, `email`, `website`, `tipo_organizacao`, `observacoes`) VALUES
(1, 1, '123456789', 'TecSoft', 'Rua A', 'Lisboa', '1000-001', '210000001', 'info@tecsoft.com', NULL, 'Privada', NULL),
(2, 2, '234567890', 'MarketPlus', 'Rua B', 'Porto', '4000-002', '220000002', 'contact@marketplus.com', NULL, 'Privada', NULL),
(3, 3, '345678901', 'ContabPro', 'Rua C', 'Coimbra', '3000-003', '230000003', 'info@contabpro.com', NULL, 'Privada', NULL),
(4, 4, '456789012', 'HealthClinic', 'Rua D', 'Faro', '8000-004', '240000004', 'admin@healthclinic.com', NULL, 'Privada', NULL),
(5, 5, '567890123', 'BuilderCo', 'Rua E', 'Braga', '4700-005', '250000005', 'geral@builderco.com', NULL, 'Privada', NULL),
(6, 6, '678901234', 'LegalServices', 'Rua F', 'Évora', '7000-006', '260000006', 'info@legalservices.com', NULL, 'Privada', NULL),
(7, 7, '789012345', 'CreativeMedia', 'Rua G', 'Aveiro', '3800-007', '270000007', 'contact@creativemedia.com', NULL, 'Privada', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `estabelecimento`
--

CREATE TABLE `estabelecimento` (
  `empresa_id` int(11) NOT NULL,
  `responsavel_id` int(11) NOT NULL,
  `zona_id` int(11) NOT NULL,
  `estabelecimento_id` int(11) NOT NULL,
  `nome_comercial` varchar(150) DEFAULT NULL,
  `morada` varchar(150) DEFAULT NULL,
  `localidade` varchar(150) DEFAULT NULL,
  `codigo_postal` varchar(150) DEFAULT NULL,
  `telefone` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `foto` int(11) DEFAULT NULL,
  `horario_funcionamento` varchar(150) DEFAULT NULL,
  `data_surgimento` date DEFAULT NULL,
  `aceitou_estagiarios` varchar(150) DEFAULT NULL,
  `observacoes` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `estabelecimento`
--

INSERT INTO `estabelecimento` (`empresa_id`, `responsavel_id`, `zona_id`, `estabelecimento_id`, `nome_comercial`, `morada`, `localidade`, `codigo_postal`, `telefone`, `email`, `foto`, `horario_funcionamento`, `data_surgimento`, `aceitou_estagiarios`, `observacoes`) VALUES
(1, 1, 1, 1, 'TecSoft Lisboa', 'Rua A1', 'Lisboa', '1000-001', '210000101', NULL, NULL, NULL, NULL, 'sim', NULL),
(2, 2, 2, 1, 'MarketPlus Porto', 'Rua B1', 'Porto', '4000-002', '220000102', NULL, NULL, NULL, NULL, 'sim', NULL),
(3, 3, 3, 1, 'ContabPro Coimbra', 'Rua C1', 'Coimbra', '3000-003', '230000103', NULL, NULL, NULL, NULL, 'sim', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `estagio`
--

CREATE TABLE `estagio` (
  `estabelecimento_empresa_id` int(11) NOT NULL,
  `estabelecimento_id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `formador_id` int(11) NOT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL,
  `nota_empresa` double DEFAULT NULL,
  `nota_escola` double NOT NULL,
  `nota_relatorio` double NOT NULL,
  `nota_procura` double NOT NULL,
  `nota_final` double DEFAULT NULL,
  `classificacao` tinyint(1) DEFAULT NULL
) ;

--
-- Dumping data for table `estagio`
--

INSERT INTO `estagio` (`estabelecimento_empresa_id`, `estabelecimento_id`, `aluno_id`, `formador_id`, `data_inicio`, `data_fim`, `nota_empresa`, `nota_escola`, `nota_relatorio`, `nota_procura`, `nota_final`, `classificacao`) VALUES
(1, 1, 1, 4, '2024-02-01', '2024-05-01', 16, 0, 0, 0, 17, 4),
(2, 1, 2, 4, '2024-02-01', '2024-05-01', 14, 0, 0, 0, 15, 5),
(3, 1, 2, 5, '2025-11-02', '2025-11-28', 20, 19, 18, 18, 19, 5),
(3, 1, 3, 5, '2024-02-01', '2024-05-01', 18, 0, 0, 0, 17, 3);

-- --------------------------------------------------------

--
-- Table structure for table `formador`
--

CREATE TABLE `formador` (
  `utilizador_id` int(11) NOT NULL,
  `num_formador` int(11) DEFAULT NULL,
  `disciplina` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `formador`
--

INSERT INTO `formador` (`utilizador_id`, `num_formador`, `disciplina`) VALUES
(4, 101, 'Programação'),
(5, 102, 'Gestão de Projetos');

-- --------------------------------------------------------

--
-- Table structure for table `produto`
--

CREATE TABLE `produto` (
  `produto_id` int(11) NOT NULL,
  `nome_produto` varchar(150) DEFAULT NULL,
  `marca` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produto`
--

INSERT INTO `produto` (`produto_id`, `nome_produto`, `marca`) VALUES
(1, 'Software Gestão', 'TecSoft'),
(2, 'Serviço Consultoria', 'MarketPlus'),
(3, 'Software Contabilidade', 'ContabPro'),
(4, 'Serviço Clínico', 'HealthClinic'),
(5, 'Material Construção', 'BuilderCo'),
(6, 'Serviço Jurídico', 'LegalServices'),
(7, 'Campanha Publicitária', 'CreativeMedia');

-- --------------------------------------------------------

--
-- Table structure for table `ramo_atividade`
--

CREATE TABLE `ramo_atividade` (
  `ramo_atividade_id` int(11) NOT NULL,
  `codigo_cae` varchar(150) DEFAULT NULL,
  `descricao` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ramo_atividade`
--

INSERT INTO `ramo_atividade` (`ramo_atividade_id`, `codigo_cae`, `descricao`) VALUES
(1, '6201', 'Programação informática'),
(2, '4711', 'Comércio'),
(3, '6920', 'Contabilidade'),
(4, '8622', 'Clínicas'),
(5, '4120', 'Construção Civil'),
(6, '6910', 'Direito'),
(7, '7311', 'Publicidade');

-- --------------------------------------------------------

--
-- Table structure for table `responsavel`
--

CREATE TABLE `responsavel` (
  `responsavel_id` int(11) NOT NULL,
  `nome` varchar(150) DEFAULT NULL,
  `titulo` varchar(150) DEFAULT NULL,
  `cargo` varchar(150) DEFAULT NULL,
  `telefone_direto` varchar(150) DEFAULT NULL,
  `telemovel` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `observacoes` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `responsavel`
--

INSERT INTO `responsavel` (`responsavel_id`, `nome`, `titulo`, `cargo`, `telefone_direto`, `telemovel`, `email`, `observacoes`) VALUES
(1, 'José Pereira', 'Dr.', 'Gerente Geral', '212345678', '912345678', 'jose@empresa.com', NULL),
(2, 'Rita Costa', 'Eng.', 'Diretora', '212398888', '918888888', 'rita@empresa.com', NULL),
(3, 'Pedro Alves', NULL, 'Supervisor', NULL, '919191919', NULL, NULL),
(4, 'Mariana Ribeiro', 'Dr.', 'Administradora', NULL, NULL, NULL, NULL),
(5, 'Tiago Ramos', NULL, 'Chefe', NULL, NULL, NULL, NULL),
(6, 'Carlos Martins', NULL, 'Gestor', NULL, NULL, NULL, NULL),
(7, 'Sofia Duarte', NULL, 'Responsável', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `serve`
--

CREATE TABLE `serve` (
  `transporte_id` int(11) NOT NULL,
  `zona_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `serve`
--

INSERT INTO `serve` (`transporte_id`, `zona_id`) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `servido`
--

CREATE TABLE `servido` (
  `estabelecimento_empresa_id` int(11) NOT NULL,
  `estabelecimento_id` int(11) NOT NULL,
  `transporte_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `servido`
--

INSERT INTO `servido` (`estabelecimento_empresa_id`, `estabelecimento_id`, `transporte_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `trabalha`
--

CREATE TABLE `trabalha` (
  `empresa_id` int(11) NOT NULL,
  `ramo_atividade_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trabalha`
--

INSERT INTO `trabalha` (`empresa_id`, `ramo_atividade_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7);

-- --------------------------------------------------------

--
-- Table structure for table `transporte`
--

CREATE TABLE `transporte` (
  `transporte_id` int(11) NOT NULL,
  `meio_transporte` varchar(150) DEFAULT NULL,
  `linha` varchar(150) DEFAULT NULL,
  `observacoes` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transporte`
--

INSERT INTO `transporte` (`transporte_id`, `meio_transporte`, `linha`, `observacoes`) VALUES
(1, 'Autocarro', 'Linha 10', NULL),
(2, 'Metro', 'Linha Azul', NULL),
(3, 'Comboio', 'Linha Norte', NULL),
(4, 'Táxi', 'Linha 2', NULL),
(5, 'Uber', 'Linha Norte', NULL),
(6, 'Carrinha Empresa', NULL, NULL),
(7, 'Elétrico', 'Linha 28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `turma`
--

CREATE TABLE `turma` (
  `curso_id` int(11) NOT NULL,
  `turma_id` int(11) NOT NULL,
  `sigla` varchar(150) DEFAULT NULL,
  `ano` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `turma`
--

INSERT INTO `turma` (`curso_id`, `turma_id`, `sigla`, `ano`) VALUES
(1, 1, 'INF-A', 2024),
(1, 2, 'INF-B', 2024),
(2, 3, 'GEST-A', 2024),
(3, 4, 'CONT-A', 2024),
(4, 5, 'MKT-A', 2024),
(5, 6, 'DIR-A', 2024),
(6, 7, 'SAU-A', 2024);

-- --------------------------------------------------------

--
-- Table structure for table `utilizador`
--

CREATE TABLE `utilizador` (
  `utilizador_id` int(11) NOT NULL,
  `login` varchar(150) DEFAULT NULL,
  `password` varchar(150) DEFAULT NULL,
  `nome` varchar(150) DEFAULT NULL,
  `tipo` enum('aluno','formador','administrativo','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utilizador`
--

INSERT INTO `utilizador` (`utilizador_id`, `login`, `password`, `nome`, `tipo`) VALUES
(1, 'joao.silva', 'pass123', 'João Silva', 'aluno'),
(2, 'maria.lima', 'pass123', 'Maria Lima', 'aluno'),
(3, 'carlos.sousa', 'pass123', 'Carlos Sousa', 'aluno'),
(4, 'ana.mendes', 'pass123', 'Ana Mendes', 'formador'),
(5, 'ricardo.gomes', 'pass123', 'Ricardo Gomes', 'formador'),
(6, 'helena.alves', 'pass123', 'Helena Alves', 'administrativo'),
(7, 'paulo.rocha', 'pass123', 'Paulo Rocha', 'administrativo');

-- --------------------------------------------------------

--
-- Table structure for table `zona`
--

CREATE TABLE `zona` (
  `zona_id` int(11) NOT NULL,
  `designacao` varchar(150) DEFAULT NULL,
  `localidade` varchar(150) DEFAULT NULL,
  `mapa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zona`
--

INSERT INTO `zona` (`zona_id`, `designacao`, `localidade`, `mapa`) VALUES
(1, 'Centro', 'Lisboa', NULL),
(2, 'Norte', 'Porto', NULL),
(3, 'Centro', 'Coimbra', NULL),
(4, 'Sul', 'Faro', NULL),
(5, 'Minho', 'Braga', NULL),
(6, 'Alentejo', 'Évora', NULL),
(7, 'Beira', 'Aveiro', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrativo`
--
ALTER TABLE `administrativo`
  ADD PRIMARY KEY (`utilizador_id`);

--
-- Indexes for table `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`utilizador_id`),
  ADD KEY `fk_aluno_turma` (`turma_id`);

--
-- Indexes for table `classificacao`
--
ALTER TABLE `classificacao`
  ADD PRIMARY KEY (`classificacao_id`),
  ADD KEY `fk_classificacao_recebe_estabelecimento` (`estabelecimento_empresa_id`,`estabelecimento_id`);

--
-- Indexes for table `comercializa`
--
ALTER TABLE `comercializa`
  ADD PRIMARY KEY (`estabelecimento_empresa_id`,`estabelecimento_id`,`produto_id`),
  ADD KEY `fk_produto_comercializa_estabelecimento` (`produto_id`);

--
-- Indexes for table `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`curso_id`);

--
-- Indexes for table `disponibilidade`
--
ALTER TABLE `disponibilidade`
  ADD PRIMARY KEY (`disponibilidade_id`),
  ADD KEY `fk_disponibilidade_oferece_empresa` (`empresa_id`);

--
-- Indexes for table `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`empresa_id`),
  ADD KEY `fk_empresa_lidera_responsavel` (`responsavel_id`);

--
-- Indexes for table `estabelecimento`
--
ALTER TABLE `estabelecimento`
  ADD PRIMARY KEY (`empresa_id`,`estabelecimento_id`),
  ADD KEY `fk_estabelecimento_pertence_responsavel` (`responsavel_id`),
  ADD KEY `fk_estabelecimento_situado_zona` (`zona_id`);

--
-- Indexes for table `estagio`
--
ALTER TABLE `estagio`
  ADD PRIMARY KEY (`estabelecimento_empresa_id`,`estabelecimento_id`,`aluno_id`),
  ADD KEY `fk_aluno_estagio_estabelecimento` (`aluno_id`),
  ADD KEY `fk_estagio_acompanhado_formador` (`formador_id`);

--
-- Indexes for table `formador`
--
ALTER TABLE `formador`
  ADD PRIMARY KEY (`utilizador_id`);

--
-- Indexes for table `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`produto_id`);

--
-- Indexes for table `ramo_atividade`
--
ALTER TABLE `ramo_atividade`
  ADD PRIMARY KEY (`ramo_atividade_id`);

--
-- Indexes for table `responsavel`
--
ALTER TABLE `responsavel`
  ADD PRIMARY KEY (`responsavel_id`);

--
-- Indexes for table `serve`
--
ALTER TABLE `serve`
  ADD PRIMARY KEY (`transporte_id`,`zona_id`),
  ADD KEY `fk_zona_serve_transporte` (`zona_id`);

--
-- Indexes for table `servido`
--
ALTER TABLE `servido`
  ADD PRIMARY KEY (`estabelecimento_empresa_id`,`estabelecimento_id`,`transporte_id`),
  ADD KEY `fk_transporte_servido_estabelecimento` (`transporte_id`);

--
-- Indexes for table `trabalha`
--
ALTER TABLE `trabalha`
  ADD PRIMARY KEY (`empresa_id`,`ramo_atividade_id`),
  ADD KEY `fk_ramo_atividade_trabalha_empresa` (`ramo_atividade_id`);

--
-- Indexes for table `transporte`
--
ALTER TABLE `transporte`
  ADD PRIMARY KEY (`transporte_id`);

--
-- Indexes for table `turma`
--
ALTER TABLE `turma`
  ADD PRIMARY KEY (`turma_id`),
  ADD KEY `fk_turma_tem_curso` (`curso_id`);

--
-- Indexes for table `utilizador`
--
ALTER TABLE `utilizador`
  ADD PRIMARY KEY (`utilizador_id`);

--
-- Indexes for table `zona`
--
ALTER TABLE `zona`
  ADD PRIMARY KEY (`zona_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrativo`
--
ALTER TABLE `administrativo`
  ADD CONSTRAINT `fk_administrativo_utilizador` FOREIGN KEY (`utilizador_id`) REFERENCES `utilizador` (`utilizador_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `aluno`
--
ALTER TABLE `aluno`
  ADD CONSTRAINT `fk_aluno_turma` FOREIGN KEY (`turma_id`) REFERENCES `turma` (`turma_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_aluno_utilizador` FOREIGN KEY (`utilizador_id`) REFERENCES `utilizador` (`utilizador_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `classificacao`
--
ALTER TABLE `classificacao`
  ADD CONSTRAINT `fk_classificacao_recebe_estabelecimento` FOREIGN KEY (`estabelecimento_empresa_id`,`estabelecimento_id`) REFERENCES `estabelecimento` (`empresa_id`, `estabelecimento_id`) ON UPDATE CASCADE;

--
-- Constraints for table `comercializa`
--
ALTER TABLE `comercializa`
  ADD CONSTRAINT `fk_estabelecimento_comercializa_produto` FOREIGN KEY (`estabelecimento_empresa_id`,`estabelecimento_id`) REFERENCES `estabelecimento` (`empresa_id`, `estabelecimento_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_produto_comercializa_estabelecimento` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`produto_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `disponibilidade`
--
ALTER TABLE `disponibilidade`
  ADD CONSTRAINT `fk_disponibilidade_oferece_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`empresa_id`) ON UPDATE CASCADE;

--
-- Constraints for table `empresa`
--
ALTER TABLE `empresa`
  ADD CONSTRAINT `fk_empresa_lidera_responsavel` FOREIGN KEY (`responsavel_id`) REFERENCES `responsavel` (`responsavel_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `estabelecimento`
--
ALTER TABLE `estabelecimento`
  ADD CONSTRAINT `fk_estabelecimento_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`empresa_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_estabelecimento_pertence_responsavel` FOREIGN KEY (`responsavel_id`) REFERENCES `responsavel` (`responsavel_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_estabelecimento_situado_zona` FOREIGN KEY (`zona_id`) REFERENCES `zona` (`zona_id`) ON UPDATE CASCADE;

--
-- Constraints for table `estagio`
--
ALTER TABLE `estagio`
  ADD CONSTRAINT `fk_aluno_estagio_estabelecimento` FOREIGN KEY (`aluno_id`) REFERENCES `aluno` (`utilizador_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_estabelecimento_estagio_aluno` FOREIGN KEY (`estabelecimento_empresa_id`,`estabelecimento_id`) REFERENCES `estabelecimento` (`empresa_id`, `estabelecimento_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_estagio_acompanhado_formador` FOREIGN KEY (`formador_id`) REFERENCES `formador` (`utilizador_id`) ON UPDATE CASCADE;

--
-- Constraints for table `formador`
--
ALTER TABLE `formador`
  ADD CONSTRAINT `fk_formador_utilizador` FOREIGN KEY (`utilizador_id`) REFERENCES `utilizador` (`utilizador_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `serve`
--
ALTER TABLE `serve`
  ADD CONSTRAINT `fk_transporte_serve_zona` FOREIGN KEY (`transporte_id`) REFERENCES `transporte` (`transporte_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_zona_serve_transporte` FOREIGN KEY (`zona_id`) REFERENCES `zona` (`zona_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `servido`
--
ALTER TABLE `servido`
  ADD CONSTRAINT `fk_estabelecimento_servido_transporte` FOREIGN KEY (`estabelecimento_empresa_id`,`estabelecimento_id`) REFERENCES `estabelecimento` (`empresa_id`, `estabelecimento_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_transporte_servido_estabelecimento` FOREIGN KEY (`transporte_id`) REFERENCES `transporte` (`transporte_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `trabalha`
--
ALTER TABLE `trabalha`
  ADD CONSTRAINT `fk_empresa_trabalha_ramo_atividade` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`empresa_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ramo_atividade_trabalha_empresa` FOREIGN KEY (`ramo_atividade_id`) REFERENCES `ramo_atividade` (`ramo_atividade_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `turma`
--
ALTER TABLE `turma`
  ADD CONSTRAINT `fk_turma_tem_curso` FOREIGN KEY (`curso_id`) REFERENCES `curso` (`curso_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
