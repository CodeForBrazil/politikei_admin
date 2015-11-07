ALTER TABLE `proposicoes` CHANGE `projeto` `ementa` varchar(255)  NOT NULL;
ALTER TABLE `proposicoes` ADD `nome` varchar(45)  NOT NULL;
ALTER TABLE `proposicoes` ADD `camara_id` int  NOT NULL;



--Ainda não temos caterogiras e parlamentares implementados
ALTER TABLE `proposicoes` DROP FOREIGN KEY `fk_Projetos_Categorias1`;
ALTER TABLE `proposicoes` DROP FOREIGN KEY `fk_Projetos_Parlamentares1`;

ALTER TABLE `proposicoes` MODIFY `parlamentar_id` int  NULL;
ALTER TABLE `proposicoes` MODIFY `categoria_id` int  NULL;


--Resumo pode ser nullable
ALTER TABLE `proposicoes` MODIFY `resumo` longtext NULL;