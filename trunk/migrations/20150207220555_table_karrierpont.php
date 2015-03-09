<?php

use Phinx\Migration\AbstractMigration;

class TableKarrierpont extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `karrierpont` (
            `karrierpont_id` tinyint unsigned NOT NULL AUTO_INCREMENT,
            `nev` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
            `letrehozo_id` int unsigned NOT NULL,
            `modosito_id` int unsigned NOT NULL,
            `letrehozas_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modositas_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `modositas_szama` smallint unsigned NOT NULL DEFAULT '0',
            `karrierpont_aktiv` tinyint unsigned NOT NULL DEFAULT '1',
            `karrierpont_torolt` tinyint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`karrierpont_id`),
            UNIQUE KEY `nev_UNIQUE` (`nev`),
            KEY `nev_INDEX` (`nev`),
            KEY `letrehozo_id_INDEX` (`letrehozo_id`),
            KEY `modosito_id_INDEX` (`modosito_id`),
            KEY `record_status_INDEX` (`karrierpont_aktiv`,`karrierpont_torolt`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci ;";
        $fkSql = "ALTER TABLE `karrierpont`
        ADD CONSTRAINT `karrierpont_letrehozo_id_fk` 
        FOREIGN KEY (`letrehozo_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `karrierpont_modosito_id_fk` 
        FOREIGN KEY (`modosito_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        $this->dropTable('karrierpont');
    }
}