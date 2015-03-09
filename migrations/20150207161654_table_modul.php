<?php

use Phinx\Migration\AbstractMigration;

class TableModul extends AbstractMigration
{
    public function up()
    {
        $sql = "CREATE TABLE `modul` (
            `modul_id` tinyint unsigned NOT NULL AUTO_INCREMENT,
            `modul_azon` varchar(64) COLLATE utf8_hungarian_ci NOT NULL,
            `modul_nev` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
            `modul_aktiv` tinyint unsigned NOT NULL DEFAULT '1',
            `modul_torolt` tinyint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`modul_id`),
            UNIQUE KEY `modul_azon_UNIQUE` (`modul_azon`),
            UNIQUE KEY `modul_nev_UNIQUE` (`modul_nev`),
            KEY `record_status_INDEX` (`modul_aktiv` , `modul_torolt`)
        )  ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE = utf8_hungarian_ci COMMENT='Modulokat tartalmazó tábla.';";
        $this->execute($sql);
    }
    
    public function down()
    {
        $this->dropTable('modul');
    }
}