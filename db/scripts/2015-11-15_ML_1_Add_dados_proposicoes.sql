alter table `proposicoes` ADD `tipo` varchar(255) NULL;
alter table `proposicoes` ADD `tema` varchar(255) NULL;
alter table `proposicoes` ADD `autor` varchar(255) NULL;
alter table `proposicoes` ADD `data_apresentacao` date NULL;
alter table `proposicoes` ADD `regime_tramitacao` varchar(255) NULL;
alter table `proposicoes` ADD `apreciacao` varchar(255) NULL;
alter table `proposicoes` ADD `situacao_camara` varchar(255) NULL;
alter table `proposicoes` ADD `xml` LONGTEXT NULL;
alter table `proposicoes` ADD `explicacao_ementa` LONGTEXT NULL;
alter table `proposicoes` ADD `link` varchar(255) NULL;