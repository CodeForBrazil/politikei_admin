-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema politikei
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `nome` VARCHAR(100) NOT NULL COMMENT '',
  `email` VARCHAR(100) NOT NULL COMMENT '',
  `senha` VARCHAR(100) NOT NULL COMMENT '',
  `cidade` VARCHAR(100) NULL COMMENT '',
  `uf` VARCHAR(2) NULL COMMENT '',
  `sexo` VARCHAR(2) NULL COMMENT '',
  `dataNascimento` VARCHAR(10) NULL COMMENT '',
  `facebook` VARCHAR(45) NULL COMMENT '',
  `googleplus` VARCHAR(45) NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '',
  UNIQUE INDEX `id_UNIQUE` (`id` ASC)  COMMENT '')
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_general_ci;


-- -----------------------------------------------------
-- Table `partidos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `partidos` (
  `sigla` VARCHAR(8) NOT NULL COMMENT '',
  `nome` VARCHAR(100) NOT NULL COMMENT '',
  PRIMARY KEY (`sigla`)  COMMENT '')
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_general_ci;


-- -----------------------------------------------------
-- Table `parlamentares`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `parlamentares` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `nome` VARCHAR(100) NOT NULL COMMENT '',
  `estado` VARCHAR(2) NULL COMMENT '',
  `partido_sigla` VARCHAR(8) NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '',
  INDEX `fk_Parlamentares_Partidos_idx` (`partido_sigla` ASC)  COMMENT '',
  CONSTRAINT `fk_Parlamentares_Partidos`
    FOREIGN KEY (`partido_sigla`)
    REFERENCES `partidos` (`sigla`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_general_ci;


-- -----------------------------------------------------
-- Table `coligacoes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `coligacoes` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `nome` VARCHAR(60) NULL COMMENT '',
  `uf` VARCHAR(2) NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '')
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_general_ci;


-- -----------------------------------------------------
-- Table `partidos_coligacoes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `partidos_coligacoes` (
  `sigla` VARCHAR(8) NOT NULL COMMENT '',
  `id_coligacao` INT NOT NULL COMMENT '',
  PRIMARY KEY (`sigla`, `id_coligacao`)  COMMENT '',
  INDEX `fk_Partidos_has_Coligacao_Coligacao1_idx` (`id_coligacao` ASC)  COMMENT '',
  INDEX `fk_Partidos_has_Coligacao_Partidos1_idx` (`sigla` ASC)  COMMENT '',
  CONSTRAINT `fk_Partidos_has_Coligacao_Partidos1`
    FOREIGN KEY (`sigla`)
    REFERENCES `partidos` (`sigla`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Partidos_has_Coligacao_Coligacao1`
    FOREIGN KEY (`id_coligacao`)
    REFERENCES `coligacoes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_general_ci;


-- -----------------------------------------------------
-- Table `palamentares_favoritos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `palamentares_favoritos` (
  `usuario_id` INT NOT NULL COMMENT '',
  `id_parlamentar` INT NOT NULL COMMENT '',
  PRIMARY KEY (`usuario_id`, `id_parlamentar`)  COMMENT '',
  INDEX `fk_Usuario_has_Parlamentares_Parlamentares1_idx` (`id_parlamentar` ASC)  COMMENT '',
  INDEX `fk_Usuario_has_Parlamentares_Usuario1_idx` (`usuario_id` ASC)  COMMENT '',
  CONSTRAINT `fk_Usuario_has_Parlamentares_Usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `usuarios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Parlamentares_Parlamentares1`
    FOREIGN KEY (`id_parlamentar`)
    REFERENCES `parlamentares` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_general_ci;


-- -----------------------------------------------------
-- Table `categorias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `nome` VARCHAR(50) NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '')
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_general_ci;


-- -----------------------------------------------------
-- Table `proposicoes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `proposicoes` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `parlamentar_id` INT NOT NULL COMMENT '',
  `categoria_id` INT NOT NULL COMMENT '',
  `projeto` VARCHAR(45) NOT NULL COMMENT '',
  `resumo` LONGTEXT NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '',
  INDEX `fk_Projetos_Parlamentares1_idx` (`parlamentar_id` ASC)  COMMENT '',
  INDEX `fk_Projetos_Categorias1_idx` (`categoria_id` ASC)  COMMENT '',
  CONSTRAINT `fk_Projetos_Parlamentares1`
    FOREIGN KEY (`parlamentar_id`)
    REFERENCES `parlamentares` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Projetos_Categorias1`
    FOREIGN KEY (`categoria_id`)
    REFERENCES `categorias` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_general_ci;


-- -----------------------------------------------------
-- Table `votos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `votos` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `usuario_id` INT NOT NULL COMMENT '',
  `proposicao_id` INT NOT NULL COMMENT '',
  `voto` VARCHAR(1) NOT NULL COMMENT '',
  `data_voto` VARCHAR(10) NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '',
  INDEX `fk_Votos_Usuario1_idx` (`usuario_id` ASC)  COMMENT '',
  INDEX `fk_Votos_Projetos1_idx` (`proposicao_id` ASC)  COMMENT '',
  CONSTRAINT `fk_Votos_Usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `usuarios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Votos_Projetos1`
    FOREIGN KEY (`proposicao_id`)
    REFERENCES `proposicoes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_general_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
