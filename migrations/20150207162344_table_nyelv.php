<?php

use Phinx\Migration\AbstractMigration;

class TableNyelv extends AbstractMigration
{
    public function up()
    {
        $sql = "CREATE TABLE `nyelv` (
            `nyelv_id` tinyint unsigned NOT NULL AUTO_INCREMENT,
            `nyelv_nev` varchar(32) COLLATE utf8_hungarian_ci NOT NULL,
            `nyelv_azon` varchar(3) COLLATE utf8_hungarian_ci NOT NULL,
            `nyelv_zaszlo_nev` varchar(255) COLLATE utf8_hungarian_ci DEFAULT NULL,
            `nyelv_aktiv` tinyint unsigned NOT NULL DEFAULT 1,
            `nyelv_torolt` tinyint unsigned NOT NULL DEFAULT 0,
            PRIMARY KEY (`nyelv_id`),
                UNIQUE KEY `nyelv_nev_UNIQUE` (`nyelv_nev`), 
                UNIQUE KEY `nyelv_azon_UNIQUE` (`nyelv_azon`), 
            KEY `record_status_INDEX` (`nyelv_aktiv` , `nyelv_torolt`)
        )  ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE = utf8_hungarian_ci COMMENT='Nyelveket tartalmazó tábla.';";
        $this->execute($sql);
    }
    
    public function down()
    {
        $this->dropTable('nyelv');
    }
}