<?php

use Phinx\Migration\AbstractMigration;

class TableUgyfelAttrProjekt extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `ugyfel_attr_projekt` (
            `ugyfel_attr_projekt_id` int unsigned NOT NULL AUTO_INCREMENT, 
            `projekt_id` int unsigned NOT NULL,
            `ugyfel_id` int unsigned NOT NULL,
            `megjegyzes` varchar(255) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
            `letrehozo_id` int unsigned NOT NULL,
            `modosito_id` int unsigned NOT NULL,
            `letrehozas_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modositas_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `modositas_szama` smallint unsigned NOT NULL DEFAULT '0',
            `ugyfel_attr_projekt_aktiv` tinyint unsigned NOT NULL DEFAULT '1',
            `ugyfel_attr_projekt_torolt` tinyint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`ugyfel_attr_projekt_id`),
            KEY `ugyfel_id_INDEX` (`ugyfel_id`),
            KEY `projekt_id_INDEX` (`projekt_id`), 
            KEY `letrehozo_id_INDEX` (`letrehozo_id`),
            KEY `modosito_id_INDEX` (`modosito_id`),
            KEY `record_status_INDEX` (`ugyfel_attr_projekt_aktiv`,`ugyfel_attr_projekt_torolt`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci COMMENT='Projektek és felhasználók közi kapcsolatot leíró tábla.';";
        $fkSql = "ALTER TABLE `ugyfel_attr_projekt`
        ADD CONSTRAINT `ugyfel_attr_projekt_ugyfel_id_fk` 
        FOREIGN KEY (`ugyfel_id`) 
        REFERENCES `ugyfel` (`ugyfel_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `projekt_attr_projekt_projekt_id_fk` 
        FOREIGN KEY (`projekt_id`) 
        REFERENCES `projekt` (`projekt_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_projekt_letrehozo_id_fk` 
        FOREIGN KEY (`letrehozo_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_projekt_modosito_id_fk` 
        FOREIGN KEY (`modosito_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        $this->dropTable('ugyfel_attr_projekt');
    }
}