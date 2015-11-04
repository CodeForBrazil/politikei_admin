-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema politikei
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema politikei
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `politikei` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `politikei` ;

-- -----------------------------------------------------
-- Table `politikei`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `politikei`.`usuarios` (
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
-- Table `politikei`.`partidos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `politikei`.`partidos` (
  `sigla` VARCHAR(8) NOT NULL COMMENT '',
  `nome` VARCHAR(100) NOT NULL COMMENT '',
  PRIMARY KEY (`sigla`)  COMMENT '')
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_general_ci;


-- -----------------------------------------------------
-- Table `politikei`.`parlamentares`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `politikei`.`parlamentares` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `nome` VARCHAR(100) NOT NULL COMMENT '',
  `estado` VARCHAR(2) NULL COMMENT '',
  `partido_sigla` VARCHAR(8) NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '',
  INDEX `fk_Parlamentares_Partidos_idx` (`partido_sigla` ASC)  COMMENT '',
  CONSTRAINT `fk_Parlamentares_Partidos`
    FOREIGN KEY (`partido_sigla`)
    REFERENCES `politikei`.`partidos` (`sigla`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_general_ci;


-- -----------------------------------------------------
-- Table `politikei`.`coligacoes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `politikei`.`coligacoes` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `nome` VARCHAR(60) NULL COMMENT '',
  `uf` VARCHAR(2) NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '')
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_general_ci;


-- -----------------------------------------------------
-- Table `politikei`.`partidos_coligacoes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `politikei`.`partidos_coligacoes` (
  `sigla` VARCHAR(8) NOT NULL COMMENT '',
  `id_coligacao` INT NOT NULL COMMENT '',
  PRIMARY KEY (`sigla`, `id_coligacao`)  COMMENT '',
  INDEX `fk_Partidos_has_Coligacao_Coligacao1_idx` (`id_coligacao` ASC)  COMMENT '',
  INDEX `fk_Partidos_has_Coligacao_Partidos1_idx` (`sigla` ASC)  COMMENT '',
  CONSTRAINT `fk_Partidos_has_Coligacao_Partidos1`
    FOREIGN KEY (`sigla`)
    REFERENCES `politikei`.`partidos` (`sigla`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Partidos_has_Coligacao_Coligacao1`
    FOREIGN KEY (`id_coligacao`)
    REFERENCES `politikei`.`coligacoes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_general_ci;


-- -----------------------------------------------------
-- Table `politikei`.`palamentares_favoritos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `politikei`.`palamentares_favoritos` (
  `usuario_id` INT NOT NULL COMMENT '',
  `id_parlamentar` INT NOT NULL COMMENT '',
  PRIMARY KEY (`usuario_id`, `id_parlamentar`)  COMMENT '',
  INDEX `fk_Usuario_has_Parlamentares_Parlamentares1_idx` (`id_parlamentar` ASC)  COMMENT '',
  INDEX `fk_Usuario_has_Parlamentares_Usuario1_idx` (`usuario_id` ASC)  COMMENT '',
  CONSTRAINT `fk_Usuario_has_Parlamentares_Usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `politikei`.`usuarios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Parlamentares_Parlamentares1`
    FOREIGN KEY (`id_parlamentar`)
    REFERENCES `politikei`.`parlamentares` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_general_ci;


-- -----------------------------------------------------
-- Table `politikei`.`categorias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `politikei`.`categorias` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `nome` VARCHAR(50) NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '')
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_general_ci;


-- -----------------------------------------------------
-- Table `politikei`.`projetos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `politikei`.`projetos` (
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
    REFERENCES `politikei`.`parlamentares` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Projetos_Categorias1`
    FOREIGN KEY (`categoria_id`)
    REFERENCES `politikei`.`categorias` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_general_ci;


-- -----------------------------------------------------
-- Table `politikei`.`votos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `politikei`.`votos` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `usuario_id` INT NOT NULL COMMENT '',
  `projeto_id` INT NOT NULL COMMENT '',
  `voto` VARCHAR(1) NOT NULL COMMENT '',
  `data_voto` VARCHAR(10) NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '',
  INDEX `fk_Votos_Usuario1_idx` (`usuario_id` ASC)  COMMENT '',
  INDEX `fk_Votos_Projetos1_idx` (`projeto_id` ASC)  COMMENT '',
  CONSTRAINT `fk_Votos_Usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `politikei`.`usuarios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Votos_Projetos1`
    FOREIGN KEY (`projeto_id`)
    REFERENCES `politikei`.`projetos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_general_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
