# Tanácsadó mező hozzáadása a felhasználó táblához.

ALTER TABLE `uniweb_ekarrier`.`user` 
ADD COLUMN `tanacsado` TINYINT NOT NULL DEFAULT 0 AFTER `nyelv_id`;

------------------------------------------------------------------

# Tanácsadó azonosító mező hozzáadása az ügyfél táblához.

ALTER TABLE `uniweb_ekarrier`.`ugyfel` 
ADD COLUMN `tanacsado_id` INT UNSIGNED NULL DEFAULT NULL AFTER `vegzettseg_id`;

------------------------------------------------------------------

# Tanácsadó index hozzáadása az ügyfél táblához.

ALTER TABLE `uniweb_ekarrier`.`ugyfel` 
ADD INDEX `tanacsado_id` (`tanacsado_id` ASC);

------------------------------------------------------------------

# Tanácsadó azonosító idegen kulcs.

ALTER TABLE `uniweb_ekarrier`.`ugyfel` 
ADD CONSTRAINT `ugyfel_tanacsado_id_fk`
  FOREIGN KEY (`tanacsado_id`)
  REFERENCES `uniweb_ekarrier`.`user` (`user_id`)
  ON DELETE SET NULL
  ON UPDATE CASCADE;

------------------------------------------------------------------

# Sorrend mező hozzáadása a munkakör táblához.

ALTER TABLE `uniweb_ekarrier`.`munkarend` 
ADD COLUMN `sorrend` TINYINT UNSIGNED NOT NULL DEFAULT 0 AFTER `has_field`;

------------------------------------------------------------------

# Munkakörök sorrendjének frissítése.

UPDATE `uniweb_ekarrier`.`munkarend` SET `sorrend`='1' WHERE `munkarend_id`='1';
UPDATE `uniweb_ekarrier`.`munkarend` SET `sorrend`='2' WHERE `munkarend_id`='3';
UPDATE `uniweb_ekarrier`.`munkarend` SET `sorrend`='3' WHERE `munkarend_id`='7';
UPDATE `uniweb_ekarrier`.`munkarend` SET `sorrend`='4' WHERE `munkarend_id`='4';
UPDATE `uniweb_ekarrier`.`munkarend` SET `sorrend`='5' WHERE `munkarend_id`='5';
UPDATE `uniweb_ekarrier`.`munkarend` SET `sorrend`='6' WHERE `munkarend_id`='11';
UPDATE `uniweb_ekarrier`.`munkarend` SET `sorrend`='7' WHERE `munkarend_id`='10';
UPDATE `uniweb_ekarrier`.`munkarend` SET `sorrend`='8' WHERE `munkarend_id`='2';
UPDATE `uniweb_ekarrier`.`munkarend` SET `sorrend`='9' WHERE `munkarend_id`='6';
UPDATE `uniweb_ekarrier`.`munkarend` SET `sorrend`='100' WHERE `munkarend_id`='9';

------------------------------------------------------------------

# Mikor regisztált mező törlése az ügyfél munkaerőpiaci helyzet táblából.

ALTER TABLE `uniweb_ekarrier`.`ugyfel_attr_munkaeropiaci_helyzet` 
DROP COLUMN `mikor_regisztralt`;

------------------------------------------------------------------

# Mikor regisztrált érték évre, hónapra, napre lebontva.

ALTER TABLE `uniweb_ekarrier`.`ugyfel_attr_munkaeropiaci_helyzet` 
ADD COLUMN `mikor_regisztralt_ev` YEAR NULL DEFAULT NULL AFTER `modositas_szama`,
ADD COLUMN `mikor_regisztralt_honap` TINYINT UNSIGNED ZEROFILL NULL DEFAULT NULL AFTER `mikor_regisztralt_ev`,
ADD COLUMN `mikor_regisztralt_nap` TINYINT UNSIGNED ZEROFILL NULL DEFAULT NULL AFTER `mikor_regisztralt_honap`;

ALTER TABLE `uniweb_ekarrier`.`ugyfel_attr_munkaeropiaci_helyzet` 
CHANGE COLUMN `mikor_regisztralt_ev` `mikor_regisztralt_ev` YEAR NULL DEFAULT NULL AFTER `regisztralt_munkanelkuli`,
CHANGE COLUMN `mikor_regisztralt_honap` `mikor_regisztralt_honap` TINYINT(2) UNSIGNED ZEROFILL NULL DEFAULT NULL AFTER `mikor_regisztralt_ev`,
CHANGE COLUMN `mikor_regisztralt_nap` `mikor_regisztralt_nap` TINYINT(2) UNSIGNED ZEROFILL NULL DEFAULT NULL AFTER `mikor_regisztralt_honap`;

------------------------------------------------------------------

# A város táblában lehet NULL is a megye azonosító.

ALTER TABLE `uniweb_ekarrier`.`cim_varos` 
DROP FOREIGN KEY `cim_varos_cim_megye_id_fk`;
ALTER TABLE `uniweb_ekarrier`.`cim_varos` 
CHANGE COLUMN `cim_megye_id` `cim_megye_id` SMALLINT(5) UNSIGNED NULL ;
ALTER TABLE `uniweb_ekarrier`.`cim_varos` 
ADD CONSTRAINT `cim_varos_cim_megye_id_fk`
  FOREIGN KEY (`cim_megye_id`)
  REFERENCES `uniweb_ekarrier`.`cim_megye` (`cim_megye_id`)
  ON DELETE NO ACTION
  ON UPDATE CASCADE;

------------------------------------------------------------------





