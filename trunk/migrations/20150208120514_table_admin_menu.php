<?php

use Phinx\Migration\AbstractMigration;

class TableAdminMenu extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `admin_menu` (
            `admin_menu_id` int NOT NULL AUTO_INCREMENT,
            `nyelv_id` tinyint unsigned NOT NULL DEFAULT '0',
            `szint` int NOT NULL DEFAULT '0',
            `baloldal` int NOT NULL DEFAULT '0',
            `jobboldal` int NOT NULL DEFAULT '0',
            `menu_nev` varchar(255) COLLATE utf8_hungarian_ci DEFAULT NULL,
            `menu_link` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
            `modul_function_id` int unsigned NOT NULL DEFAULT '0',
            `admin_menu_aktiv` tinyint unsigned NOT NULL DEFAULT '1',
            `admin_menu_torolt` tinyint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`admin_menu_id`,`nyelv_id`),
            /*UNIQUE KEY `menu_link_UNIQUE` (`menu_link`), */
            KEY `szint_INDEX` (`szint`),
            KEY `baloldal_INDEX` (`baloldal`),
            KEY `jobboldal_INDEX` (`jobboldal`),
            KEY `modul_function_id_INDEX` (`modul_function_id`),
            KEY `record_status_INDEX` (`admin_menu_aktiv`, `admin_menu_torolt`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci ;";
        $fkSql = "ALTER TABLE `admin_menu` 
        ADD CONSTRAINT `admin_menu_nyelv_id_fk`
        FOREIGN KEY (`nyelv_id`)
        REFERENCES `nyelv` (`nyelv_id`)
        ON DELETE NO ACTION
        ON UPDATE CASCADE,
        ADD CONSTRAINT `admin_menu_modul_function_id_fk`
        FOREIGN KEY (`modul_function_id`)
        REFERENCES `modul_function` (`modul_function_id`)
        ON DELETE NO ACTION
        ON UPDATE CASCADE;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        $this->dropTable('admin_menu');
    }
}