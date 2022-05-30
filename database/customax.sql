/* CRIA O BANCO DE DADOS SE NÃO EXISTIR */
CREATE DATABASE IF NOT EXISTS customax; 

/* CRIA A TABELA SE NÃO EXISTIR */
CREATE TABLE IF NOT EXISTS `usuarios` (
  `email` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `goleiro` varchar(4) NOT NULL,
  `presenca` varchar(100) NOT NULL,
  `adm` int(1) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `usuarios` (`email`, `senha`, `nome`, `goleiro`, `presenca`, `adm`, `id`) VALUES
('adm@customax.com', 'admin', 'Herickson Cordeiro', 'adm', '', 1, 25),
('player1@customax.com', 'player1', 'Player 1', 'nÃ£o', '', 0, 45),
('player2@customax.com', 'player2', 'Player 2', 'nÃ£o', '', 0, 46),
('player3@customax.com', 'player3', 'Player 3', 'nÃ£o', '', 0, 47),
('player4@customax.com', 'player4', 'Player 4', 'nÃ£o', '', 0, 48),
('player5@customax.com', 'player5', 'Player 5', 'nÃ£o', '', 0, 49),
('player6@customax.com', 'player6', 'Player 6', 'sim', '', 0, 50),
('player7@customax.com', 'player7', 'Player 7', 'nÃ£o', '', 0, 51),
('player8@customax.com', 'player8', 'Player 8', 'nÃ£o', '', 0, 52),
('player9@customax.com', 'player9', 'Player 9', 'nÃ£o', '', 0, 54),
('player10@customax.com', 'player10', 'Player 10', 'nÃ£o', '', 0, 55),
('player11@customax.com', 'player11', 'Player 11', 'nÃ£o', '', 0, 56),
('player12@customax.com', 'player12', 'Player 12', 'sim', '', 0, 57);

ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
