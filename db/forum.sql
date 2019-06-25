-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 20-Nov-2018 às 00:24
-- Versão do servidor: 10.1.36-MariaDB
-- versão do PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `forum`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `amigos`
--

CREATE TABLE `amigos` (
  `id` int(20) NOT NULL,
  `id_de` varchar(200) NOT NULL,
  `id_para` varchar(200) NOT NULL,
  `status` int(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `amigos`
--

INSERT INTO `amigos` (`id`, `id_de`, `id_para`, `status`) VALUES
(1, 'thsales061', 'rafael065', 1),
(2, 'demo', 'thsales061', 1),
(3, 'rafael065', 'demo', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(20) NOT NULL,
  `categoria` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`) VALUES
(1, 'Primeira Categoria'),
(2, 'Segunda Categoria'),
(3, 'Terceira Categoria');

-- --------------------------------------------------------

--
-- Estrutura da tabela `chatbox`
--

CREATE TABLE `chatbox` (
  `id` int(11) NOT NULL,
  `regras` text NOT NULL,
  `min_permission` int(200) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `chatbox`
--

INSERT INTO `chatbox` (`id`, `regras`, `min_permission`) VALUES
(1, '<h5 align=\"left\">Regras do ChatBox</h5>\r\n<p>1&ordm; Flood {mensagens seguidas}: Evite floodar.<br />2&ordm; Links: Proibido links de outros sites.<br />3&ordm; Conversas: Modere nas conversas.<br />4&ordm; &Eacute; permitido somente links de imagens com o link direto.<br />5&ordm; V&iacute;deos: Somente videos relacionados ao assunto do momento.<br />6&ordm; Banimento: Postagens de links com conte&uacute;do pornogr&aacute;fico, mensagens ofensivas (palavr&otilde;es),mensagens preconceituosas, acarretar&aacute; em avalia&ccedil;&atilde;o do moderador e pode causar expuls&atilde;o do f&oacute;rum..</p>', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `chatbox_mensagens`
--

CREATE TABLE `chatbox_mensagens` (
  `id` int(20) NOT NULL,
  `id_de` varchar(200) NOT NULL,
  `mensagem` text NOT NULL,
  `data` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `chatbox_mensagens`
--

INSERT INTO `chatbox_mensagens` (`id`, `id_de`, `mensagem`, `data`) VALUES
(35, 'thsales061', 'Oi!', '12-11-2018 13:53:54'),
(36, 'demo', 'Oi :)', '12-11-2018 13:55:58'),
(37, 'rafael065', 'Eai', '12-11-2018 13:56:11');

-- --------------------------------------------------------

--
-- Estrutura da tabela `configs_site`
--

CREATE TABLE `configs_site` (
  `id` int(20) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `pontos_por_curtidas` int(20) NOT NULL DEFAULT '1',
  `description` varchar(200) DEFAULT NULL,
  `keywords` varchar(200) DEFAULT NULL,
  `banner` varchar(200) DEFAULT NULL,
  `icon` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `configs_site`
--

INSERT INTO `configs_site` (`id`, `titulo`, `pontos_por_curtidas`, `description`, `keywords`, `banner`, `icon`) VALUES
(1, 'FÃ³rum com PHP', 2, 'A', 'B', '../images/uploads/1478804343_topheaderlogo.png', '../images/uploads/1827506936_img_icon_site.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `forums`
--

CREATE TABLE `forums` (
  `id` int(20) NOT NULL,
  `categoria` varchar(200) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `descricao` varchar(200) NOT NULL,
  `status` int(200) NOT NULL,
  `permissao` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `forums`
--

INSERT INTO `forums` (`id`, `categoria`, `titulo`, `descricao`, `status`, `permissao`) VALUES
(1, '1', 'My First Forum', 'This is my first forum', 1, 0),
(2, '1', 'MY secound forum', 'This is my second forum', 1, 1),
(3, '2', 'My First FORUM of me secound category', 'Description of my secound category post', 1, 1),
(4, '3', 'Primeiro fÃ³rum da terceira categoria', 'Este Ã© o primeiro fÃ³rum da terceira categoria', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `messages_private`
--

CREATE TABLE `messages_private` (
  `id` int(20) NOT NULL,
  `id_de` varchar(200) NOT NULL,
  `id_para` varchar(200) NOT NULL,
  `data` varchar(200) NOT NULL,
  `mensagem` varchar(200) NOT NULL,
  `lido` int(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `messages_private`
--

INSERT INTO `messages_private` (`id`, `id_de`, `id_para`, `data`, `mensagem`, `lido`) VALUES
(8, 'thsales061', 'rafael065', '09-11-2018 08:44:05', 'Oi?', 1),
(9, 'thsales061', 'rafael065', '09-11-2018 08:44:16', 'Como vocÃª estÃ¡?', 1),
(10, 'thsales061', 'rafael065', '09-11-2018 08:45:48', 'DÃ¡ o papo menÃ³', 1),
(11, 'thsales061', 'rafael065', '09-11-2018 08:46:31', '........', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `notifications`
--

CREATE TABLE `notifications` (
  `id` int(20) NOT NULL,
  `id_para` varchar(200) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `data` varchar(200) NOT NULL,
  `lido` int(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `notifications`
--

INSERT INTO `notifications` (`id`, `id_para`, `titulo`, `data`, `lido`) VALUES
(1, 'thsales061', 'Sua PUBLICAÇÃO FOI ALTERADA!', 'alguma ai', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `reputacao_niveis`
--

CREATE TABLE `reputacao_niveis` (
  `id` int(20) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `pontos` int(200) NOT NULL,
  `cor` varchar(200) DEFAULT NULL,
  `bg_cor` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `reputacao_niveis`
--

INSERT INTO `reputacao_niveis` (`id`, `nome`, `pontos`, `cor`, `bg_cor`) VALUES
(1, 'Novato', 1, 'gold', '#696969'),
(2, 'Iniciante', 5, 'gold', '#555'),
(3, 'Aprendiz', 10, 'green', 'purple'),
(4, 'Membro Avançado', 15, '', 'gold');

-- --------------------------------------------------------

--
-- Estrutura da tabela `respostas`
--

CREATE TABLE `respostas` (
  `id` int(20) NOT NULL,
  `id_topico` int(20) NOT NULL,
  `id_forum` int(200) NOT NULL,
  `id_categoria` int(200) NOT NULL,
  `postador` varchar(200) NOT NULL,
  `resposta` text NOT NULL,
  `data` varchar(200) NOT NULL,
  `curtidas` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `respostas`
--

INSERT INTO `respostas` (`id`, `id_topico`, `id_forum`, `id_categoria`, `postador`, `resposta`, `data`, `curtidas`) VALUES
(17, 3, 1, 1, 'rafael065', 'Achei legal!', '14-09-2018 23:19:04', 1),
(20, 3, 1, 1, 'thsales061', 'Eu também! kkk', '15-09-2018 00:59:26', 1),
(21, 5, 3, 2, 'thsales061', 'Achei legal !', '15-09-2018 01:05:16', 0),
(24, 4, 1, 1, 'thsales061', '<p>QUALQUER COISA!!</p>', '01-10-2018 06:18:36', 2),
(25, 4, 1, 1, 'rafael065', 'Estamos ai :)', '17-10-2018 06:04:08', 1),
(31, 4, 1, 1, 'thsales061', '<p>Sim.. claro...</p>\n<p>&nbsp;</p>\n<pre class=\"language-php\"><code>public function update_likes_topicos($id, $curtidas, $usuario){\n		$likesAtualizados = ($curtidas) + 1;\n\n		$stmt = $this-&gt;con-&gt;prepare(\"UPDATE topicos SET curtidas = ? WHERE id = ?\");\n		$stmt-&gt;bind_param(\"ss\", $likesAtualizados, $id);\n		$stmt-&gt;execute();\n		$this-&gt;update_points_reputation($usuario);\n\n		$this-&gt;alert(false, false, true, \"topico\".$id);\n	}</code></pre>', '19-10-2018 08:28:16', 0),
(32, 4, 1, 1, 'rafael065', '<p>Legal... gostei, ficou bom! Funcionou certinho :)</p>', '20-10-2018 07:50:11', 0),
(34, 4, 1, 1, 'demo', '<p>E esse aqui:</p>\r\n<p>&nbsp;</p>\r\n<pre class=\\\"language-php\\\"><code>public function carrega_pagina($con){\r\n			$url = (isset($_GET[\\\'pagina\\\'])) ? $_GET[\\\'pagina\\\'] : \\\'inicio\\\';\r\n			$explode = explode(\\\'/\\\', $url);\r\n			$dir = \\\"pags/\\\";\r\n			$ext = \\\".php\\\";\r\n\r\n			if(file_exists($dir.$explode[\\\'0\\\'].$ext)){\r\n			  require_once($dir.$explode[\\\'0\\\'].$ext);\r\n			}else{\r\n			  echo \\\'&lt;div class=\\\"alert alert-danger\\\"&gt;P&aacute;gina n&atilde;o encontrada!&lt;/div&gt;\\\';\r\n			}\r\n		}</code></pre>', '21-10-2018 18:21:09', 0),
(35, 16, 4, 3, 'thsales061', '<p>dsadsad</p>', '29-10-2018 10:38:21', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `topicos`
--

CREATE TABLE `topicos` (
  `id` int(20) NOT NULL,
  `forum` int(20) NOT NULL,
  `categoria` int(200) NOT NULL,
  `visitas` int(200) NOT NULL DEFAULT '0',
  `titulo` varchar(200) NOT NULL,
  `mensagem` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `postador` varchar(200) NOT NULL,
  `data` varchar(200) NOT NULL,
  `status` int(20) NOT NULL DEFAULT '1',
  `curtidas` int(200) DEFAULT '0',
  `resolvido` int(20) NOT NULL DEFAULT '0',
  `fixo` int(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `topicos`
--

INSERT INTO `topicos` (`id`, `forum`, `categoria`, `visitas`, `titulo`, `mensagem`, `postador`, `data`, `status`, `curtidas`, `resolvido`, `fixo`) VALUES
(3, 1, 3, 394, 'My first topic', 'This is my first tipic, i\'m so happy. Are we happy?', 'thsales061', '14-09-2018 15:35:22', 0, 15, 1, 1),
(4, 1, 1, 918, 'Minha segunda publicação', '<p>Esta &eacute; a minha <strong>descri&ccedil;&atilde;o</strong></p>', 'thsales061', '14-09-2018 16:11:03', 1, 12, 0, 0),
(5, 3, 2, 49, 'O que acha?', '<p>Voc&ecirc; gostou?</p>', 'rafael065', '15-09-2018 22:34:54', 1, 1, 0, 0),
(16, 4, 3, 11, 'Testando a terceira categoria', '<p>hahahahahahahha :v :V:V :V:V:V:V:V:V</p>', 'thsales061', '21-10-2018 07:41:33', 1, 0, 0, 0),
(17, 1, 1, 265, 'Estou com um problema', '<pre class=\\\"language-php\\\"><code>public function carrega_pagina($con){\r\n	$url = (isset($_GET[\\\'pagina\\\'])) ? $_GET[\\\'pagina\\\'] : \\\'inicio\\\';\r\n	$explode = explode(\\\'/\\\', $url);\r\n	$dir = \\\"pags/\\\";\r\n	$ext = \\\".php\\\";\r\n\r\n	if(file_exists($dir.$explode[\\\'0\\\'].$ext)){\r\n		require_once($dir.$explode[\\\'0\\\'].$ext);\r\n	}else{\r\n		echo \\\'&lt;div class=\\\"alert alert-danger\\\"&gt;P&aacute;gina n&atilde;o encontrada!&lt;/div&gt;\\\';\r\n   }\r\n}</code></pre>\r\n<p>&nbsp;</p>\r\n<p>Edited by moderator.</p>', 'demo', '21-10-2018 17:13:43', 1, 0, 0, 0),
(19, 3, 2, 82, 'Rise of tomb raider', '<p><img src=\\\"https://i.imgur.com/XXJGv33.jpg\\\" /></p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>Pega essa</p>', 'thsales061', '12-11-2018 12:35:56', 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(20) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `usuario` varchar(200) NOT NULL,
  `foto` varchar(200) NOT NULL,
  `senha` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `nivel` int(200) NOT NULL DEFAULT '0',
  `pontos` int(200) NOT NULL DEFAULT '1',
  `ativo` int(20) NOT NULL DEFAULT '1',
  `ativo_chat` int(20) NOT NULL DEFAULT '1',
  `nascimento` varchar(200) DEFAULT NULL,
  `sexo` int(20) DEFAULT NULL,
  `pais` varchar(200) DEFAULT NULL,
  `estado` varchar(200) DEFAULT NULL,
  `sobre` varchar(200) DEFAULT NULL,
  `hobbies` varchar(200) DEFAULT NULL,
  `skills` varchar(200) DEFAULT NULL,
  `data_cadastro` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `usuario`, `foto`, `senha`, `email`, `nivel`, `pontos`, `ativo`, `ativo_chat`, `nascimento`, `sexo`, `pais`, `estado`, `sobre`, `hobbies`, `skills`, `data_cadastro`) VALUES
(1, 'Thiago Sales', 'thsales061', 'images/uploads/profile/1789316002_IMG_20180505_173547_685.jpg', '00a99367148fcd2d0d307853ae170683', 'thiago_salests@hotmail.com', 2, 19, 1, 1, '1997-04-29', 0, 'Brasil', 'RJ', 'Fala cmgg', '', 'HTML,PHP,Bootstrap,CSS,Jquery,Ajax,C#,C++,Phyton', '21-08-2018 10:00:00'),
(2, 'Rafael', 'rafael065', 'images/uploads/profile/1306798238_tenor.gif', '202cb962ac59075b964b07152d234b70', 'rafaelsilva006@hotmail.com', 1, 1, 1, 1, '', 0, 'Brasil', 'Prefiro nÃ£o dizer (Atual)', '', '', '', NULL),
(3, 'Usuário Demo', 'demo', 'https://www.edupics.com/image-robot-dm27198.jpg', 'fe01ce2a7fbac8fafaed7c982a04e229', 'demo@demo.com', 0, 5, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '21-10-2018 12:13:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios_online`
--

CREATE TABLE `usuarios_online` (
  `id` int(20) NOT NULL,
  `tempo` varchar(200) NOT NULL,
  `ip` varchar(200) NOT NULL,
  `sessao` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuarios_online`
--

INSERT INTO `usuarios_online` (`id`, `tempo`, `ip`, `sessao`) VALUES
(69, '1542669964', '::1', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `amigos`
--
ALTER TABLE `amigos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chatbox`
--
ALTER TABLE `chatbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chatbox_mensagens`
--
ALTER TABLE `chatbox_mensagens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `configs_site`
--
ALTER TABLE `configs_site`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forums`
--
ALTER TABLE `forums`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages_private`
--
ALTER TABLE `messages_private`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reputacao_niveis`
--
ALTER TABLE `reputacao_niveis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `respostas`
--
ALTER TABLE `respostas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topicos`
--
ALTER TABLE `topicos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios_online`
--
ALTER TABLE `usuarios_online`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `amigos`
--
ALTER TABLE `amigos`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `chatbox`
--
ALTER TABLE `chatbox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chatbox_mensagens`
--
ALTER TABLE `chatbox_mensagens`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `configs_site`
--
ALTER TABLE `configs_site`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `forums`
--
ALTER TABLE `forums`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `messages_private`
--
ALTER TABLE `messages_private`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reputacao_niveis`
--
ALTER TABLE `reputacao_niveis`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `respostas`
--
ALTER TABLE `respostas`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `topicos`
--
ALTER TABLE `topicos`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `usuarios_online`
--
ALTER TABLE `usuarios_online`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
