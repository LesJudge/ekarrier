<?php

use Phinx\Migration\AbstractMigration;

class TableMenu extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `menu` (
            `menu_id` int NOT NULL AUTO_INCREMENT,
            `nyelv_id` tinyint unsigned NOT NULL DEFAULT '0',
            `szint` int NOT NULL DEFAULT '0',
            `baloldal` int NOT NULL DEFAULT '0',
            `jobboldal` int NOT NULL DEFAULT '0',
            `menu_nev` varchar(255) COLLATE utf8_hungarian_ci DEFAULT NULL,
            `menu_link` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
            `kapcsolodo_id` varchar(128) COLLATE utf8_hungarian_ci DEFAULT NULL,
            `jogcsoport_id` tinyint unsigned NOT NULL DEFAULT '0',
            `menu_aktiv` tinyint unsigned NOT NULL DEFAULT '1',
            `menu_torolt` tinyint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`menu_id`,`nyelv_id`),
            /*UNIQUE KEY (`menu_link`), */
            KEY `baloldal_INDEX` (`baloldal`),
            KEY `jobboldal_INDEX` (`jobboldal`),
            KEY `jogcsoport_id_INDEX` (`jogcsoport_id`),
            KEY `szint_INDEX` (`szint`),
            KEY `kapcsolodo_id_INDEX` (`kapcsolodo_id`),
            KEY `record_status_INDEX` (`menu_aktiv`, `menu_torolt`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci ;";
        $fkSql = "ALTER TABLE `menu` 
        ADD CONSTRAINT `menu_nyelv_id_fk`
        FOREIGN KEY (`nyelv_id`)
        REFERENCES `nyelv` (`nyelv_id`)
        ON DELETE NO ACTION
        ON UPDATE CASCADE,
        ADD CONSTRAINT `menu_jogcsoport_id_fk`
        FOREIGN KEY (`jogcsoport_id`)
        REFERENCES `jogcsoport` (`jogcsoport_id`)
        ON DELETE NO ACTION
        ON UPDATE CASCADE;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        $this->dropTable('menu');
    }
}