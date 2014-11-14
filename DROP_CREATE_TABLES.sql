SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `wintertourtennis` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `wintertourtennis` ;


-- -----------------------------------------------------
-- Drop tables
-- -----------------------------------------------------

DROP TABLE IF EXISTS `wintertourtennis_incontri`, `wintertourtennis_circoli`, `wintertourtennis_iscritti_newsletter`, `wintertourtennis_risultati`, `wintertourtennis_soci`, `wintertourtennis_socio_partecipa_torneo`, `wintertourtennis_tessere`, `wintertourtennis_tipologie_soci`, `wintertourtennis_tornei`, `wintertourtennis_punteggi`, `wintertourtennis_turni`;


-- -----------------------------------------------------
-- Table `wintertourtennis`.`wintertourtennis_tipologie_soci`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wintertourtennis`.`wintertourtennis_tipologie_soci` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(35) NOT NULL,
  `descrizione` VARCHAR(125) NULL,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wintertourtennis`.`wintertourtennis_circoli`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wintertourtennis`.`wintertourtennis_circoli` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(70) NOT NULL,
  `indirizzo` VARCHAR(64) NOT NULL,
  `citta` VARCHAR(64) NOT NULL,
  `cap` CHAR(5) NOT NULL,
  `provincia` CHAR(2) NOT NULL,
  `referente` INT NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_wintertour_circoli_wintertour_soci1_idx` (`referente` ASC),
  CONSTRAINT `fk_wintertour_circoli_wintertour_soci1`
    FOREIGN KEY (`referente`)
    REFERENCES `wintertourtennis`.`wintertourtennis_soci` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wintertourtennis`.`wintertourtennis_soci`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wintertourtennis`.`wintertourtennis_soci` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(35) NOT NULL,
  `cognome` VARCHAR(35) NOT NULL,
  `email` VARCHAR(254) NULL,
  `tipologia` INT NULL,
  `saldo` DOUBLE NULL DEFAULT 0,
  `indirizzo` VARCHAR(64) NOT NULL,
  `citta` VARCHAR(64) NOT NULL,
  `cap` CHAR(5) NOT NULL,
  `provincia` CHAR(2) NOT NULL,
  `telefono` VARCHAR(16) NULL,
  `cellulare` VARCHAR(16) NULL,
  `statoattivo` TINYINT(1) NULL DEFAULT 0,
  `datanascita` DATE NOT NULL,
  `cittanascita` VARCHAR(64) NULL,
  `dataiscrizione` DATE NULL,
  `codicefiscale` CHAR(16) NULL,
  `dataimmissione` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `certificatomedico` TINYINT(1) NULL DEFAULT 0,
  `domandaassociazione` DATE NULL,
  `circolo` INT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_wintertour_soci_wintertour_tipologie_soci_idx` (`tipologia` ASC),
  INDEX `fk_wintertour_soci_wintertour_circoli1_idx` (`circolo` ASC),
  CONSTRAINT `fk_wintertour_soci_wintertour_tipologie_soci`
    FOREIGN KEY (`tipologia`)
    REFERENCES `wintertourtennis`.`wintertourtennis_tipologie_soci` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_wintertour_soci_wintertour_circoli1`
    FOREIGN KEY (`circolo`)
    REFERENCES `wintertourtennis`.`wintertourtennis_circoli` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wintertourtennis`.`wintertourtennis_tornei`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wintertourtennis`.`wintertourtennis_tornei` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `datainizio` DATE NOT NULL,
  `datafine` DATE NOT NULL,
  `circolo` INT NOT NULL,
  `nometorneo` VARCHAR(75) NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_wintertour_tornei_wintertour_circoli1_idx` (`circolo` ASC),
  CONSTRAINT `fk_wintertour_tornei_wintertour_circoli1`
    FOREIGN KEY (`circolo`)
    REFERENCES `wintertourtennis`.`wintertourtennis_circoli` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wintertourtennis`.`wintertourtennis_iscritti_newsletter`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wintertourtennis`.`wintertourtennis_iscritti_newsletter` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(254) NULL,
  `nome` VARCHAR(35) NULL,
  `cognome` VARCHAR(35) NULL,
  `socio` INT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_wintertourtennis_iscritti_newsletter_wintertourtennis_so_idx` (`socio` ASC),
  CONSTRAINT `fk_wintertourtennis_iscritti_newsletter_wintertourtennis_soci1`
    FOREIGN KEY (`socio`)
    REFERENCES `wintertourtennis`.`wintertourtennis_soci` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wintertourtennis`.`wintertourtennis_incontri`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wintertourtennis`.`wintertourtennis_incontri` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `torneo` INT NOT NULL,
  `giocatore1` INT NOT NULL,
  `giocatore2` INT NOT NULL,
  `giocatore3` INT NULL,
  `giocatore4` INT NULL,
  `arbitro` INT NULL,
  `dataeorainizio` DATETIME NOT NULL,
  `scontrodoppio` TINYINT(1) NULL,
  `almegliodicinque` TINYINT(1) NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_wintertour_incontri_wintertour_tornei1_idx` (`torneo` ASC),
  INDEX `fk_wintertour_incontri_wintertour_soci1_idx` (`giocatore1` ASC),
  INDEX `fk_wintertour_incontri_wintertour_soci2_idx` (`giocatore2` ASC),
  INDEX `fk_wintertour_incontri_wintertour_soci3_idx` (`arbitro` ASC),
  INDEX `fk_wintertour_incontri_wintertour_soci4_idx` (`giocatore3` ASC),
  INDEX `fk_wintertour_incontri_wintertour_soci5_idx` (`giocatore4` ASC),
  CONSTRAINT `fk_wintertour_incontri_wintertour_tornei1`
    FOREIGN KEY (`torneo`)
    REFERENCES `wintertourtennis`.`wintertourtennis_tornei` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_wintertour_incontri_wintertour_soci1`
    FOREIGN KEY (`giocatore1`)
    REFERENCES `wintertourtennis`.`wintertourtennis_soci` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_wintertour_incontri_wintertour_soci2`
    FOREIGN KEY (`giocatore2`)
    REFERENCES `wintertourtennis`.`wintertourtennis_soci` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_wintertour_incontri_wintertour_soci3`
    FOREIGN KEY (`arbitro`)
    REFERENCES `wintertourtennis`.`wintertourtennis_soci` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_wintertour_incontri_wintertour_soci4`
    FOREIGN KEY (`giocatore3`)
    REFERENCES `wintertourtennis`.`wintertourtennis_soci` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_wintertour_incontri_wintertour_soci5`
    FOREIGN KEY (`giocatore4`)
    REFERENCES `wintertourtennis`.`wintertourtennis_soci` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wintertourtennis`.`wintertourtennis_risultati`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wintertourtennis`.`wintertourtennis_risultati` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `incontro` INT NOT NULL,
  `punteggio1e3` INT NOT NULL,
  `punteggio2e4` INT NOT NULL,
  `numeroset` INT NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_wintertour_risultati_wintertour_incontri1_idx` (`incontro` ASC),
  CONSTRAINT `fk_wintertour_risultati_wintertour_incontri1`
    FOREIGN KEY (`incontro`)
    REFERENCES `wintertourtennis`.`wintertourtennis_incontri` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wintertourtennis`.`wintertourtennis_socio_partecipa_torneo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wintertourtennis`.`wintertourtennis_socio_partecipa_torneo` (
  `socio` INT NOT NULL,
  `torneo` INT NOT NULL,
  PRIMARY KEY (`socio`, `torneo`),
  INDEX `fk_wintertourtennis_soci_has_wintertourtennis_tornei_winter_idx` (`torneo` ASC),
  INDEX `fk_wintertourtennis_soci_has_wintertourtennis_tornei_winter_idx1` (`socio` ASC),
  CONSTRAINT `fk_wintertourtennis_soci_has_wintertourtennis_tornei_winterto1`
    FOREIGN KEY (`socio`)
    REFERENCES `wintertourtennis`.`wintertourtennis_soci` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_wintertourtennis_soci_has_wintertourtennis_tornei_winterto2`
    FOREIGN KEY (`torneo`)
    REFERENCES `wintertourtennis`.`wintertourtennis_tornei` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wintertourtennis`.`wintertourtennis_tessere`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wintertourtennis`.`wintertourtennis_tessere` (
  `numerotessera` VARCHAR(75) NOT NULL,
  `socio` INT NOT NULL,
  INDEX `fk_wintertourtennis_tessere_wintertourtennis_soci1_idx` (`socio` ASC),
  PRIMARY KEY (`numerotessera`),
  CONSTRAINT `fk_wintertourtennis_tessere_wintertourtennis_soci1`
    FOREIGN KEY (`socio`)
    REFERENCES `wintertourtennis`.`wintertourtennis_soci` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wintertourtennis`.`wintertourtennis_turni`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wintertourtennis`.`wintertourtennis_turni` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `dataeora` DATETIME NOT NULL,
  `circolo` INT NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_wintertour_turni_wintertourtennis_circoli1_idx` (`circolo` ASC),
  CONSTRAINT `fk_wintertour_turni_wintertourtennis_circoli1`
    FOREIGN KEY (`circolo`)
    REFERENCES `wintertourtennis`.`wintertourtennis_circoli` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wintertourtennis`.`wintertourtennis_punteggi`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wintertourtennis`.`wintertourtennis_punteggi` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `punteggio` INT NOT NULL,
  `socio` INT NOT NULL,
  `turno` INT NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_wintertourtennis_punteggi_wintertourtennis_soci1_idx` (`socio` ASC),
  INDEX `fk_wintertourtennis_punteggi_wintertourtennis_turni1_idx` (`turno` ASC),
  CONSTRAINT `fk_wintertourtennis_punteggi_wintertourtennis_soci1`
    FOREIGN KEY (`socio`)
    REFERENCES `wintertourtennis`.`wintertourtennis_soci` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_wintertourtennis_punteggi_wintertourtennis_turni1`
    FOREIGN KEY (`turno`)
    REFERENCES `wintertourtennis`.`wintertourtennis_turni` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
