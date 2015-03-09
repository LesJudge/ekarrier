<?php

use Phinx\Migration\AbstractMigration;

class TableSzolgaltatas extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `szolgaltatas` (
            `szolgaltatas_id` int unsigned NOT NULL AUTO_INCREMENT,
            `nev` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
            `leiras` text COLLATE utf8_hungarian_ci NOT NULL,
            `letrehozo_id` int unsigned NOT NULL,
            `modosito_id` int unsigned NOT NULL,
            `letrehozas_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modositas_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `modositas_szama` smallint unsigned NOT NULL DEFAULT '0',
            `szolgaltatas_aktiv` tinyint unsigned NOT NULL DEFAULT '1',
            `szolgaltatas_torolt` tinyint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`szolgaltatas_id`),
            UNIQUE KEY `nev_UNIQUE` (`nev`),
            KEY `letrehozo_id_INDEX` (`letrehozo_id`),
            KEY `modosito_id_INDEX` (`modosito_id`),
            KEY `record_status_INDEX` (`szolgaltatas_aktiv`,`szolgaltatas_torolt`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci COMMENT='Szolgáltatásokat tartalmazó tábla.' ;";
        $fkSql = "ALTER TABLE `szolgaltatas`
        ADD CONSTRAINT `szolgaltatas_letrehozo_id_fk` 
        FOREIGN KEY (`letrehozo_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `szolgaltatas_modosito_id_fk` 
        FOREIGN KEY (`modosito_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        //$this->execute('SET FOREIGN_KEY_CHECKS = 0;');
        $this->dropTable('szolgaltatas');
        //$this->execute('SET FOREIGN_KEY_CHECKS = 1;');
    }
}