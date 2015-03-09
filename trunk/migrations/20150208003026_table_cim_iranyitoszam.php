<?php

use Phinx\Migration\AbstractMigration;

class TableCimIranyitoszam extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `cim_iranyitoszam` (
            `cim_iranyitoszam_id` int unsigned NOT NULL AUTO_INCREMENT,
            `cim_varos_id` int unsigned NOT NULL,
            `iranyitoszam` varchar(32) COLLATE utf8_hungarian_ci NOT NULL,
            `letrehozo_id` int unsigned NOT NULL,
            `modosito_id` int unsigned NOT NULL,
            `modositas_szama` smallint unsigned NOT NULL DEFAULT '0',
            `letrehozas_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modositas_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `cim_iranyitoszam_aktiv` tinyint unsigned NOT NULL DEFAULT '1',
            `cim_iranyitoszam_torolt` tinyint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`cim_iranyitoszam_id`),
            KEY `cim_varos_id_INDEX` (`cim_varos_id`),
            KEY `letrehozo_id_INDEX` (`letrehozo_id`),
            KEY `modosito_id_INDEX` (`modosito_id`),
            KEY `record_status_INDEX` (`cim_iranyitoszam_aktiv`,`cim_iranyitoszam_torolt`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci COMMENT='Irányítószámokat tartalmazó tábla.' ;";
        $fkSql = "ALTER TABLE `cim_iranyitoszam`
        ADD CONSTRAINT `cim_iranyitoszam_letrehozo_id_fk` 
        FOREIGN KEY (`letrehozo_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `cim_iranyitoszam_modosito_id_fk` 
        FOREIGN KEY (`modosito_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `cim_iranyitoszam_cim_varos_id_fk` 
        FOREIGN KEY (`cim_varos_id`) 
        REFERENCES `cim_varos` (`cim_varos_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        $this->dropTable('cim_iranyitoszam');
    }
}