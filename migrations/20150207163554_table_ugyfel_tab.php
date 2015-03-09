<?php

use Phinx\Migration\AbstractMigration;

class TableUgyfelTab extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `ugyfel_tab` (
            `ugyfel_tab_id` tinyint unsigned NOT NULL AUTO_INCREMENT,
            `nev` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
            `letrehozo_id` int unsigned NOT NULL,
            `modosito_id` int unsigned NOT NULL,
            `modositas_szama` smallint unsigned NOT NULL,
            `ugyfel_tab_aktiv` tinyint unsigned NOT NULL DEFAULT '1',
            `ugyfel_tab_torolt` tinyint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`ugyfel_tab_id`),
            UNIQUE KEY `nev_UNIQUE` (`nev`),
            KEY `letrehozo_id_INDEX` (`letrehozo_id`),
            KEY `modosito_id_INDEX` (`modosito_id`)
        )  ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE = utf8_hungarian_ci COMMENT='Az ügyfélkezelő tab-ok neveit tartalmazó tábla.';";
        $fkSql = "ALTER TABLE `ugyfel_tab`
	ADD CONSTRAINT `ugyfel_tab_modosito_id_fk` 
            FOREIGN KEY (`modosito_id`) 
            REFERENCES `user` (`user_id`) 
            ON DELETE NO ACTION 
            ON UPDATE CASCADE,
	ADD CONSTRAINT `ugyfel_tab_letrehozo_id_fk` 
            FOREIGN KEY (`letrehozo_id`) 
            REFERENCES `user` (`user_id`) 
            ON DELETE NO ACTION 
	ON UPDATE CASCADE;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        $this->dropTable('ugyfel_tab');
    }
}