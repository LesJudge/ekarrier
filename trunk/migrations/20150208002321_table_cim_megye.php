<?php

use Phinx\Migration\AbstractMigration;

class TableCimMegye extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `cim_megye` (
            `cim_megye_id` smallint unsigned NOT NULL AUTO_INCREMENT,
            `cim_megye_nev` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
            `letrehozo_id` int unsigned NOT NULL,
            `modosito_id` int unsigned NOT NULL,
            `modositas_szama` smallint unsigned NOT NULL DEFAULT '0',
            `letrehozas_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modositas_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `cim_megye_aktiv` tinyint unsigned NOT NULL DEFAULT '1',
            `cim_megye_torolt` tinyint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`cim_megye_id`),
            UNIQUE KEY `cim_megye_nev_UNIQUE` (`cim_megye_nev`),
            KEY `letrehozo_id_INDEX` (`letrehozo_id`),
            KEY `modosito_id_INDEX` (`modosito_id`),
            KEY `record_status_INDEX` (`cim_megye_aktiv`,`cim_megye_torolt`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci COMMENT='Megyéket tartalmazó tábla.' ;";
        $fkSql = "ALTER TABLE `cim_megye`
        ADD CONSTRAINT `cim_megye_letrehozo_id_fk` 
        FOREIGN KEY (`letrehozo_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `cim_megye_modosito_id_fk` 
        FOREIGN KEY (`modosito_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        $this->dropTable('cim_megye');
    }
}