<?php

use Phinx\Migration\AbstractMigration;

class TableUgyfelAttrCim extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `ugyfel_attr_cim` (
            `ugyfel_attr_cim_id` int unsigned NOT NULL AUTO_INCREMENT,
            `ugyfel_id` int unsigned NOT NULL,
            `ugyfel_cim_tipus_id` tinyint unsigned NOT NULL,
            `cim_orszag_id` smallint unsigned DEFAULT NULL,
            `cim_megye_id` smallint unsigned DEFAULT NULL,
            `cim_varos_id` int unsigned DEFAULT NULL,
            `cim_iranyitoszam_id` int unsigned DEFAULT NULL,
            `orszag` varchar(255) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
            `megye` varchar(255) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
            `varos` varchar(255) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
            `iranyitoszam` varchar(255) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
            `utca` varchar(255) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
            `hazszam` varchar(32) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
            `letrehozo_id` int unsigned NOT NULL,
            `modosito_id` int unsigned NOT NULL,
            `modositas_szama` smallint unsigned NOT NULL DEFAULT '0',
            `letrehozas_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modositas_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `ugyfel_attr_cim_aktiv` tinyint unsigned NOT NULL DEFAULT '1',
            `ugyfel_attr_cim_torolt` tinyint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`ugyfel_attr_cim_id`),
            KEY `ugyfel_id_INDEX` (`ugyfel_id`),
            KEY `ugyfel_cim_tipus_id_INDEX` (`ugyfel_cim_tipus_id`),
            KEY `cim_orszag_id_INDEX` (`cim_orszag_id`),
            KEY `cim_megye_id_INDEX` (`cim_megye_id`),
            KEY `cim_varos_id_INDEX` (`cim_varos_id`),
            KEY `cim_iranyitoszam_id_INDEX` (`cim_iranyitoszam_id`),
            KEY `letrehozo_id_INDEX` (`letrehozo_id`),
            KEY `modosito_id_INDEX` (`modosito_id`),
            KEY `record_status_INDEX` (`ugyfel_attr_cim_aktiv`,`ugyfel_attr_cim_torolt`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci COMMENT='Ügyfelek címeit tartalmazó tábla.' ;";
        $fkSql = "ALTER TABLE `ugyfel_attr_cim`
        ADD CONSTRAINT `ugyfel_attr_cim_cim_iranyitoszam_id_fk` 
        FOREIGN KEY (`cim_iranyitoszam_id`) 
        REFERENCES `cim_iranyitoszam` (`cim_iranyitoszam_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_cim_cim_megye_id_fk` 
        FOREIGN KEY (`cim_megye_id`) 
        REFERENCES `cim_megye` (`cim_megye_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_cim_cim_orszag_id_fk` 
        FOREIGN KEY (`cim_orszag_id`) 
        REFERENCES `cim_orszag` (`cim_orszag_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_cim_cim_varos_id_fk` 
        FOREIGN KEY (`cim_varos_id`) 
        REFERENCES `cim_varos` (`cim_varos_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_cim_letrehozo_id_fk` 
        FOREIGN KEY (`letrehozo_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_cim_modosito_id_fk` 
        FOREIGN KEY (`modosito_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_cim_ugyfel_cim_tipus_id_fk` 
        FOREIGN KEY (`ugyfel_cim_tipus_id`) 
        REFERENCES `ugyfel_cim_tipus` (`ugyfel_cim_tipus_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_cim_ugyfel_id_fk` 
        FOREIGN KEY (`ugyfel_id`) 
        REFERENCES `ugyfel` (`ugyfel_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        $this->dropTable('ugyfel_attr_cim');
    }
}