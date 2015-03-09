<?php

use Phinx\Migration\AbstractMigration;

class TableSiteTipus extends AbstractMigration
{
    public function up()
    {
        $sql = "CREATE TABLE `site_tipus` (
            `site_tipus_id` tinyint unsigned NOT NULL AUTO_INCREMENT,
            `site_tipus_nev` varchar(64) COLLATE utf8_hungarian_ci NOT NULL,
            `site_tipus_torolt` tinyint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`site_tipus_id`),
            UNIQUE KEY `site_tipus_nev_UNIQUE` (`site_tipus_nev`),
            KEY `site_tipus_torolt_INDEX` (`site_tipus_torolt`)
        )  ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE = utf8_hungarian_ci COMMENT='Oldal típusokat tartalmazó tábla.';";
        $this->execute($sql);
    }
    
    public function down()
    {
        $this->dropTable('site_tipus');
    }
}