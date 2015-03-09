<?php

use Phinx\Migration\AbstractMigration;

class TableCimOrszag extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `cim_orszag` (
            `cim_orszag_id` smallint unsigned NOT NULL AUTO_INCREMENT,
            `kod` char(2) COLLATE utf8_hungarian_ci NOT NULL,
            `nev` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
            `letrehozo_id` int unsigned NOT NULL,
            `modosito_id` int unsigned NOT NULL,
            `letrehozas_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modositas_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `modositas_szama` smallint unsigned NOT NULL DEFAULT '0',
            `cim_orszag_aktiv` tinyint unsigned NOT NULL DEFAULT '1',
            `cim_orszag_torolt` tinyint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`cim_orszag_id`),
            UNIQUE KEY `kod_UNIQUE` (`kod`),
            UNIQUE KEY `nev_UNIQUE` (`nev`),
            KEY `letrehozo_id_INDEX` (`letrehozo_id`),
            KEY `modosito_id_INDEX` (`modosito_id`),
            KEY `record_status_INDEX` (`cim_orszag_aktiv`,`cim_orszag_torolt`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci ;";
        $fkSql = "ALTER TABLE `cim_orszag`
        ADD CONSTRAINT `cim_orszag_letrehozo_id_fk` 
        FOREIGN KEY (`letrehozo_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `cim_orszag_modosito_id_fk` 
        FOREIGN KEY (`modosito_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        $this->dropTable('cim_orszag');
    }
}