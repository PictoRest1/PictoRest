SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `pictorest` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `pictorest` ;

-- -----------------------------------------------------
-- Table `pictorest`.`Utilisateur` lolilolol
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pictorest`.`Utilisateur` (
  `idutil` INT NOT NULL,
  `nomutil` VARCHAR(45) NULL,
  `prenomutil` VARCHAR(45) NULL,
  `mailutil` VARCHAR(45) NULL,
  `idutilsuivi` INT NOT NULL,
  `idutilabonne` INT NOT NULL,
  `mdputil` VARCHAR(45) NOT NULL,
  `sale` VARCHAR(254) NOT NULL,
  PRIMARY KEY (`idutil`),
  INDEX `fk_Utilisateur_Utilisateur_idx` (`idutilsuivi` ASC),
  INDEX `fk_Utilisateur_Utilisateur1_idx` (`idutilabonne` ASC),
  CONSTRAINT `fk_Utilisateur_Utilisateur`
    FOREIGN KEY (`idutilsuivi`)
    REFERENCES `pictorest`.`Utilisateur` (`idutil`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Utilisateur_Utilisateur1`
    FOREIGN KEY (`idutilabonne`)
    REFERENCES `pictorest`.`Utilisateur` (`idutil`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pictorest`.`Album`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pictorest`.`Album` (
  `idAlbum` INT NOT NULL,
  `idutil` INT NOT NULL,
  `libelalbum` VARCHAR(45) NULL,
  `datecreaalbum` DATE NULL,
  PRIMARY KEY (`idAlbum`),
  INDEX `fk_Album_Utilisateur1_idx` (`idutil` ASC),
  CONSTRAINT `fk_Album_Utilisateur1`
    FOREIGN KEY (`idutil`)
    REFERENCES `pictorest`.`Utilisateur` (`idutil`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pictorest`.`Photo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pictorest`.`Photo` (
  `idPhoto` INT NOT NULL,
  `urlphoto` VARCHAR(45) NULL,
  `libelphoto` VARCHAR(45) NULL,
  `idAlbum` INT NOT NULL,
  `datecreaphoto` DATE NULL,
  PRIMARY KEY (`idPhoto`),
  INDEX `fk_Photo_Album1_idx` (`idAlbum` ASC),
  CONSTRAINT `fk_Photo_Album1`
    FOREIGN KEY (`idAlbum`)
    REFERENCES `pictorest`.`Album` (`idAlbum`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pictorest`.`Abonne`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pictorest`.`Abonne` (
  `idAbonne` INT NOT NULL,
  `idAlbum` INT NOT NULL,
  `idutil` INT NOT NULL,
  PRIMARY KEY (`idAbonne`),
  INDEX `fk_Abonne_Utilisateur1_idx` (`idutil` ASC),
  CONSTRAINT `fk_Abonne_Album1`
    FOREIGN KEY (`idAlbum`)
    REFERENCES `pictorest`.`Album` (`idAlbum`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Abonne_Utilisateur1`
    FOREIGN KEY (`idutil`)
    REFERENCES `pictorest`.`Utilisateur` (`idutil`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;