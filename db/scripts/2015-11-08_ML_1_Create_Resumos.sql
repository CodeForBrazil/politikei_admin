alter table `users` MODIFY `id` INT  NOT NULL AUTO_INCREMENT;

alter table `proposicoes` ADD `descricao` varchar(255) NULL;
alter table `proposicoes` ADD `colaborador_id` int NULL;
alter table `proposicoes` ADD CONSTRAINT `fk_proposicoes_colaborador` FOREIGN KEY (`colaborador_id`) REFERENCES users(`id`);