<?php

use Phinx\Migration\AbstractMigration;

class TableUgyfelStatusz extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `ugyfel_statusz` (
            `ugyfel_statusz_id` tinyint unsigned NOT NULL AUTO_INCREMENT,
            `nev` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
            `letrehozo_id` int unsigned NOT NULL,
            `modosito_id` int unsigned NOT NULL,
            `letrehozas_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modositas_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `modositas_szama` smallint unsigned NOT NULL DEFAULT '0',
            `ugyfel_statusz_aktiv` tinyint unsigned NOT NULL DEFAULT '1',
            `ugyfel_statusz_torolt` tinyint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`ugyfel_statusz_id`),
            UNIQUE KEY `nev_UNIQUE` (`nev`),
            KEY `letrehozo_id_INDEX` (`letrehozo_id`),
            KEY `modosito_id_INDEX` (`modosito_id`),
            KEY `status_INDEX` (`ugyfel_statusz_aktiv` , `ugyfel_statusz_torolt`)
        )  ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE = utf8_hungarian_ci COMMENT='Az ügyfél státuszokat tartalmazó tábla.';";
        $fkSql = "ALTER TABLE `ugyfel_statusz`
        ADD CONSTRAINT `ugyfel_statusz_modosito_id_fk` 
            FOREIGN KEY (`modosito_id`) 
            REFERENCES `user` (`user_id`) 
            ON DELETE NO ACTION 
            ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_statusz_letrehozo_id_fk` 
            FOREIGN KEY (`letrehozo_id`) 
            REFERENCES `user` (`user_id`) 
            ON DELETE NO ACTION 
            ON UPDATE CASCADE;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        $this->dropTable('ugyfel_statusz');
    }
}