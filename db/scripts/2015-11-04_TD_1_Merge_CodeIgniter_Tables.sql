CREATE TABLE `media` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `public_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varbinary(255) DEFAULT NULL,
  `avatar` int(11) DEFAULT NULL COMMENT 'media.id',
  `bio` text,
  `city` varchar(256) DEFAULT NULL,
  `alias` varchar(64) DEFAULT NULL,
  `roles` int(11) NOT NULL DEFAULT '0',
  `confirmation` varchar(32) DEFAULT NULL,
  `dateadd` datetime DEFAULT NULL,
  `dateupdate` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `user` (`id`, `name`, `email`, `password`, `avatar`, `bio`, `city`, `alias`, `roles`, `confirmation`, `dateadd`, `dateupdate`, `status`)
VALUES
	(1, 'Admin', 'admin@sand.box', X'1464A86EAB99', NULL, '', '', '', 1, NULL, '2015-09-17 12:22:12', '2015-09-17 14:06:57', 1);

ALTER TABLE `votos` CHANGE `usuario_id` `user_id` INT(11)  NOT NULL;

ALTER TABLE `partidos_coligacoes` CHANGE `id_coligacao` `coligacao_id` INT(11)  NOT NULL;

ALTER TABLE `palamentares_favoritos` CHANGE `usuario_id` `user_id` INT(11)  NOT NULL;

ALTER TABLE `palamentares_favoritos` CHANGE `parlamentar` `parlamentar_id` INT(11)  NOT NULL;

DROP TABLE `usuarios`;
