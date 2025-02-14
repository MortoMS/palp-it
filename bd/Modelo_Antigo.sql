-- MySQL Script generated by MySQL Workbench
-- Wed Aug 25 14:33:16 2021
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema palpit
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema palpit
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `palpit` DEFAULT CHARACTER SET utf8 ;
USE `palpit` ;

-- -----------------------------------------------------
-- Table `palpit`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `palpit`.`usuario` (
  `id_usuario` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(200) NOT NULL,
  `email` VARCHAR(200) NOT NULL,
  `senha` VARCHAR(200) NOT NULL,
  `sobre` VARCHAR(200) NULL DEFAULT '',
  `cidade` VARCHAR(200) NULL DEFAULT '',
  `area` VARCHAR(100) NULL,
  `receber` VARCHAR(1) NULL,
  `confirmacao` VARCHAR(45) NULL,
  `foto_p` VARCHAR(245) NULL,
  `tipo_usuario` VARCHAR(20) NOT NULL DEFAULT 'C',
  `criado_usuario` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_usuario`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `palpit`.`arquivo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `palpit`.`arquivo` (
  `id_arquivo` INT NOT NULL AUTO_INCREMENT,
  `descricao` TEXT NOT NULL,
  `foto_v` VARCHAR(100) NOT NULL,
  `status` INT NOT NULL DEFAULT '0',
  `titulo` VARCHAR(45) NULL,
  `q_download` INT NULL,
  `q_acesso` INT NULL,
  `foto_t` VARCHAR(100) NULL,
  `id_usuario_fk` INT NOT NULL,
  `criado_arquivo` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_arquivo`),
  INDEX `fk_arquivo_usuario1_idx` (`id_usuario_fk` ASC) ,
  CONSTRAINT `fk_arquivo_usuario1`
    FOREIGN KEY (`id_usuario_fk`)
    REFERENCES `palpit`.`usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `palpit`.`tag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `palpit`.`tag` (
  `id_tag` INT NOT NULL AUTO_INCREMENT,
  `key_words` VARCHAR(50) NOT NULL,
  `id_arquivo_fk` INT NOT NULL,
  PRIMARY KEY (`id_tag`),
  INDEX `fk_tag_arquivo1_idx` (`id_arquivo_fk` ASC) ,
  CONSTRAINT `fk_tag_arquivo1`
    FOREIGN KEY (`id_arquivo_fk`)
    REFERENCES `palpit`.`arquivo` (`id_arquivo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `palpit`.`disciplina`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `palpit`.`disciplina` (
  `id_disciplina` INT NOT NULL AUTO_INCREMENT,
  `nome_disciplina` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`id_disciplina`),
  UNIQUE INDEX `nome_disciplina_UNIQUE` (`nome_disciplina` ASC) )
ENGINE = InnoDB;

INSERT INTO `palpit`.`disciplina` (`id_disciplina`, `nome_disciplina`) VALUES ('1', 'Todas');
INSERT INTO `palpit`.`disciplina` (`id_disciplina`, `nome_disciplina`) VALUES ('2', 'Física ');
INSERT INTO `palpit`.`disciplina` (`id_disciplina`, `nome_disciplina`) VALUES ('3', 'Geografia');
INSERT INTO `palpit`.`disciplina` (`id_disciplina`, `nome_disciplina`) VALUES ('4', 'Biologia');

-- -----------------------------------------------------
-- Table `palpit`.`area`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `palpit`.`area` (
  `id_area` INT NOT NULL AUTO_INCREMENT,
  `nome_area` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_area`),
  UNIQUE INDEX `nome_area_UNIQUE` (`nome_area` ASC) )
ENGINE = InnoDB;

INSERT INTO `palpit`.`area` (`id_area`, `nome_area`) VALUES ('1', 'Ciências Exatas');
INSERT INTO `palpit`.`area` (`id_area`, `nome_area`) VALUES ('2', 'Ciências Humanas');
INSERT INTO `palpit`.`area` (`id_area`, `nome_area`) VALUES ('3', 'Ciências Econômicas');
INSERT INTO `palpit`.`area` (`id_area`, `nome_area`) VALUES ('4', 'Ciências da Saúde');


-- -----------------------------------------------------
-- Table `palpit`.`escolaridade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `palpit`.`escolaridade` (
  `id_escolaridade` INT NOT NULL AUTO_INCREMENT,
  `nivel` VARCHAR(45) NULL,
  PRIMARY KEY (`id_escolaridade`))
ENGINE = InnoDB;

INSERT INTO `palpit`.`escolaridade` (`id_escolaridade`, `nivel`) VALUES ('1', 'Fundamental I');
INSERT INTO `palpit`.`escolaridade` (`id_escolaridade`, `nivel`) VALUES ('2', 'Fundamental II');
INSERT INTO `palpit`.`escolaridade` (`id_escolaridade`, `nivel`) VALUES ('3', 'Médio');
INSERT INTO `palpit`.`escolaridade` (`id_escolaridade`, `nivel`) VALUES ('4', 'Superior');


-- -----------------------------------------------------
-- Table `palpit`.`assoc_ed`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `palpit`.`assoc_ed` (
  `id_assoc_ed` INT NOT NULL AUTO_INCREMENT,
  `id_disciplina_fk` INT NOT NULL,
  `id_escolaridade_fk` INT NOT NULL,
  PRIMARY KEY (`id_assoc_ed`),
  INDEX `fk_assoc_ed_disciplina1_idx` (`id_disciplina_fk` ASC) ,
  INDEX `fk_assoc_ed_escolaridade1_idx` (`id_escolaridade_fk` ASC) ,
  CONSTRAINT `fk_assoc_ed_disciplina1`
    FOREIGN KEY (`id_disciplina_fk`)
    REFERENCES `palpit`.`disciplina` (`id_disciplina`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_assoc_ed_escolaridade1`
    FOREIGN KEY (`id_escolaridade_fk`)
    REFERENCES `palpit`.`escolaridade` (`id_escolaridade`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `palpit`.`assoc_arquivo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `palpit`.`assoc_arquivo` (
  `id_assoc_a` INT NOT NULL AUTO_INCREMENT,
  `id_arquivo_fk` INT NOT NULL,
  `id_assoc_ed_fk` INT NOT NULL,
  PRIMARY KEY (`id_assoc_a`),
  INDEX `fk_assoc_arquivo_arquivo1_idx` (`id_arquivo_fk` ASC) ,
  INDEX `fk_assoc_arquivo_assoc_ed1_idx` (`id_assoc_ed_fk` ASC) ,
  CONSTRAINT `fk_assoc_arquivo_arquivo1`
    FOREIGN KEY (`id_arquivo_fk`)
    REFERENCES `palpit`.`arquivo` (`id_arquivo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_assoc_arquivo_assoc_ed1`
    FOREIGN KEY (`id_assoc_ed_fk`)
    REFERENCES `palpit`.`assoc_ed` (`id_assoc_ed`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
