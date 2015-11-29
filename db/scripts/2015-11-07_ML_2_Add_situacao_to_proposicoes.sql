ALTER TABLE `proposicoes` ADD `situacao` int  NULL;
-- UPDATE `proposicoes` set `situacao` = 0;
ALTER TABLE `proposicoes` MODIFY `situacao` int  NOT NULL;