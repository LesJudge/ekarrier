<?php

use Phinx\Migration\AbstractMigration;

class TableNyelvSzotar extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `nyelv_szotar` (
            `nyelv_szotar_id` int unsigned NOT NULL AUTO_INCREMENT,
            `nyelv_id` tinyint unsigned NOT NULL,
            `modul_id` tinyint unsigned NOT NULL,
            `nyelv_szotar_azon` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
            `nyelv_szotar_szo` text COLLATE utf8_hungarian_ci NOT NULL,
            `nyelv_szotar_torolt` tinyint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`nyelv_szotar_id`,`nyelv_id`),
            KEY `modul_id` (`modul_id`),
            KEY `nyelv_szotar_torolt` (`nyelv_szotar_torolt`),
            KEY `nyelv_szotar_azon` (`nyelv_szotar_azon`),
            KEY `nyelv_szotar_szo` (`nyelv_szotar_szo`(255)),
            KEY `nyelv_id` (`nyelv_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci ;";
        $fkSql = "ALTER TABLE `nyelv_szotar`
        ADD CONSTRAINT `nyelv_szotar_nyelv_id_fk` 
        FOREIGN KEY (`nyelv_id`) 
        REFERENCES `nyelv` (`nyelv_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE/*,
        ADD CONSTRAINT `nyelv_szotar_modul_id_fk` 
        FOREIGN KEY (`modul_id`) 
        REFERENCES `modul` (`modul_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE*/;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        $this->dropTable('nyelv_szotar');
    }
}