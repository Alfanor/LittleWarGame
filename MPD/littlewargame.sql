-- MySQL Script generated by MySQL Workbench
-- sam. 24 févr. 2018 18:34:43 CET
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `member`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `member` (
  `id` SMALLINT(2) UNSIGNED NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(20) NOT NULL,
  `password` CHAR(60) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  UNIQUE INDEX `name_UNIQUE` (`login` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `inventory`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventory` (
  `id` MEDIUMINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `area`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `area` (
  `id` MEDIUMINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `x` SMALLINT(2) NOT NULL,
  `y` SMALLINT(2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `village`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `village` (
  `id` MEDIUMINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `area_id` MEDIUMINT(3) UNSIGNED NOT NULL,
  `member_id` SMALLINT(2) UNSIGNED NOT NULL,
  `inventory_id` MEDIUMINT(3) UNSIGNED NOT NULL,
  `name` VARCHAR(30) NOT NULL,
  `population` SMALLINT(2) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_village_member1_idx` (`member_id` ASC),
  INDEX `fk_village_inventory1_idx` (`inventory_id` ASC),
  INDEX `fk_village_area1_idx` (`area_id` ASC),
  CONSTRAINT `fk_village_member1`
    FOREIGN KEY (`member_id`)
    REFERENCES `member` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_village_inventory1`
    FOREIGN KEY (`inventory_id`)
    REFERENCES `inventory` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_village_area1`
    FOREIGN KEY (`area_id`)
    REFERENCES `area` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `temple`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `temple` (
  `id` MEDIUMINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `village_id` MEDIUMINT(3) UNSIGNED NOT NULL,
  `inventory_id` MEDIUMINT(3) UNSIGNED NOT NULL,
  `name` VARCHAR(30) NOT NULL,
  `level` TINYINT(1) UNSIGNED NOT NULL,
  `worker` SMALLINT(2) UNSIGNED NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_temple_inventory1_idx` (`inventory_id` ASC),
  INDEX `fk_temple_village1_idx` (`village_id` ASC),
  CONSTRAINT `fk_temple_inventory1`
    FOREIGN KEY (`inventory_id`)
    REFERENCES `inventory` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_temple_village1`
    FOREIGN KEY (`village_id`)
    REFERENCES `village` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ressource`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ressource` (
  `id` TINYINT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `inventory_ressource`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventory_ressource` (
  `inventory_id` MEDIUMINT(3) UNSIGNED NOT NULL,
  `ressource_id` TINYINT(1) UNSIGNED NOT NULL,
  `amount` INT(4) UNSIGNED NOT NULL,
  INDEX `fk_inventory_ressource_inventory1_idx` (`inventory_id` ASC),
  CONSTRAINT `fk_member_ressource_ressource`
    FOREIGN KEY (`ressource_id`)
    REFERENCES `ressource` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_inventory_ressource_inventory1`
    FOREIGN KEY (`inventory_id`)
    REFERENCES `inventory` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `building`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `building` (
  `id` TINYINT(1) UNSIGNED NOT NULL,
  `inventory_id` MEDIUMINT(3) UNSIGNED NOT NULL,
  `temple_level` TINYINT(1) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_building_inventory1_idx` (`inventory_id` ASC),
  CONSTRAINT `fk_building_inventory1`
    FOREIGN KEY (`inventory_id`)
    REFERENCES `inventory` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `village_building`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `village_building` (
  `village_id` MEDIUMINT(3) UNSIGNED NOT NULL,
  `building_id` TINYINT(1) UNSIGNED NOT NULL,
  INDEX `fk_village_building_village1_idx` (`village_id` ASC),
  INDEX `fk_village_building_building1_idx` (`building_id` ASC),
  CONSTRAINT `fk_village_building_village1`
    FOREIGN KEY (`village_id`)
    REFERENCES `village` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_village_building_building1`
    FOREIGN KEY (`building_id`)
    REFERENCES `building` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `temple_cost_level`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `temple_cost_level` (
  `id` TINYINT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  `inventory_id` MEDIUMINT(3) UNSIGNED NOT NULL,
  INDEX `fk_temple_cost_level_inventory1_idx` (`inventory_id` ASC),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_temple_cost_level_inventory1`
    FOREIGN KEY (`inventory_id`)
    REFERENCES `inventory` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `temple_running_level`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `temple_running_level` (
  `temple_id` MEDIUMINT(3) UNSIGNED NOT NULL,
  `level_id` TINYINT(1) UNSIGNED NOT NULL,
  `inventory_id` MEDIUMINT(3) UNSIGNED NOT NULL,
  INDEX `fk_temple_level_temple1_idx` (`temple_id` ASC),
  INDEX `fk_temple_level_inventory1_idx` (`inventory_id` ASC),
  INDEX `fk_temple_running_level_temple_cost_level1_idx` (`level_id` ASC),
  CONSTRAINT `fk_temple_level_temple1`
    FOREIGN KEY (`temple_id`)
    REFERENCES `temple` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_temple_level_inventory1`
    FOREIGN KEY (`inventory_id`)
    REFERENCES `inventory` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_temple_running_level_temple_cost_level1`
    FOREIGN KEY (`level_id`)
    REFERENCES `temple_cost_level` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `area_ressource`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `area_ressource` (
  `id` INT(4) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ressource_id` TINYINT(1) UNSIGNED NOT NULL,
  `area_id` MEDIUMINT(3) UNSIGNED NOT NULL,
  INDEX `fk_area_ressources_ressource1_idx` (`ressource_id` ASC),
  INDEX `fk_area_ressources_area1_idx` (`area_id` ASC),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_area_ressources_ressource1`
    FOREIGN KEY (`ressource_id`)
    REFERENCES `ressource` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_area_ressources_area1`
    FOREIGN KEY (`area_id`)
    REFERENCES `area` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `village_farmer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `village_farmer` (
  `village_id` MEDIUMINT(3) UNSIGNED NOT NULL,
  `area_ressource_id` INT(4) UNSIGNED NOT NULL,
  `worker` SMALLINT(2) UNSIGNED NOT NULL,
  INDEX `fk_village_farmer_village1_idx` (`village_id` ASC),
  INDEX `fk_village_farmer_area_ressource1_idx` (`area_ressource_id` ASC),
  CONSTRAINT `fk_village_farmer_village1`
    FOREIGN KEY (`village_id`)
    REFERENCES `village` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_village_farmer_area_ressource1`
    FOREIGN KEY (`area_ressource_id`)
    REFERENCES `area_ressource` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
