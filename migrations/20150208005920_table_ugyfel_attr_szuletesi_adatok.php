<?php

use Phinx\Migration\AbstractMigration;

class TableUgyfelAttrSzuletesiAdatok extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `ugyfel_attr_szuletesi_adatok` (
            `ugyfel_id` int unsigned NOT NULL,
            `vezeteknev` varchar(128) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
            `keresztnev` varchar(128) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
            `orszag_id` smallint unsigned DEFAULT NULL,
            `varos_id` int unsigned DEFAULT NULL,
            `szuletesi_ido` date DEFAULT NULL,
            `letrehozo_id` int unsigned NOT NULL,
            `modosito_id` int unsigned NOT NULL,
            `letrehozas_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modositas_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `modositas_szama` smallint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`ugyfel_id`),
            KEY `orszag_id_INDEX` (`orszag_id`),
            KEY `varos_id_INDEX` (`varos_id`),
            KEY `letrehozo_id_INDEX` (`letrehozo_id`),
            KEY `modosito_id_INDEX` (`modosito_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci COMMENT='Ügyfél születési adatai.';";
        $fkSql = "ALTER TABLE `ugyfel_attr_szuletesi_adatok`
        ADD CONSTRAINT `ugyfel_attr_szuletesi_adatok_orszag_id_fk` 
        FOREIGN KEY (`orszag_id`) 
        REFERENCES `cim_orszag` (`cim_orszag_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_szuletesi_adatok_varos_id_fk` 
        FOREIGN KEY (`varos_id`) 
        REFERENCES `cim_varos` (`cim_varos_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_szuletesi_adatok_letrehozo_id_fk` 
        FOREIGN KEY (`letrehozo_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_szuletesi_adatok_modosito_id_fk` 
        FOREIGN KEY (`modosito_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_id_fk` 
        FOREIGN KEY (`ugyfel_id`) 
        REFERENCES `ugyfel` (`ugyfel_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        $this->dropTable('ugyfel_attr_szuletesi_adatok');
    }
}