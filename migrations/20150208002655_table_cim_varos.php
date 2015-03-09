<?php

use Phinx\Migration\AbstractMigration;

class TableCimVaros extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `cim_varos` (
            `cim_varos_id` int unsigned NOT NULL AUTO_INCREMENT,
            `cim_orszag_id` smallint unsigned NOT NULL,
            `cim_megye_id` smallint unsigned NOT NULL,
            `cim_varos_nev` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
            `letrehozo_id` int unsigned NOT NULL,
            `modosito_id` int unsigned NOT NULL,
            `modositas_szama` smallint unsigned NOT NULL DEFAULT '0',
            `letrehozas_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modositas_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `cim_varos_aktiv` tinyint unsigned NOT NULL DEFAULT '1',
            `cim_varos_torolt` tinyint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`cim_varos_id`),
            KEY `cim_orszag_id_INDEX` (`cim_orszag_id`),
            KEY `cim_megye_id_INDEX` (`cim_megye_id`),
            KEY `letrehozo_id_INDEX` (`letrehozo_id`),
            KEY `modosito_id_INDEX` (`modosito_id`),
            KEY `record_status_INDEX` (`cim_varos_aktiv`,`cim_varos_torolt`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci COMMENT='Városokat tartalmazó tábla.' ;";
        $fkSql = "ALTER TABLE `cim_varos`
        ADD CONSTRAINT `cim_varos_letrehozo_id_fk` 
        FOREIGN KEY (`letrehozo_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `cim_varos_modosito_id_fk` 
        FOREIGN KEY (`modosito_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `cim_varos_cim_orszag_id_fk` 
        FOREIGN KEY (`cim_orszag_id`) 
        REFERENCES `cim_orszag` (`cim_orszag_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `cim_varos_cim_megye_id_fk` 
        FOREIGN KEY (`cim_megye_id`) 
        REFERENCES `cim_megye` (`cim_megye_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        $this->dropTable('cim_varos');
    }
}