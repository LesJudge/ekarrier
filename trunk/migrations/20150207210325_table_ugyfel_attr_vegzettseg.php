<?php

use Phinx\Migration\AbstractMigration;

class TableUgyfelAttrVegzettseg extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `ugyfel_attr_vegzettseg` (
            `ugyfel_attr_vegzettseg_id` int unsigned NOT NULL AUTO_INCREMENT,
            `ugyfel_id` int unsigned NOT NULL,
            `vegzettseg_id` int unsigned NOT NULL,
            `iskola` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
            `kezdet` year(4) DEFAULT NULL,
            `veg` year(4) DEFAULT NULL,
            `szak` varchar(255) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
            `megnevezes` varchar(255) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
            `letrehozo_id` int unsigned NOT NULL,
            `modosito_id` int unsigned NOT NULL,
            `letrehozas_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modositas_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `modositas_szama` smallint unsigned NOT NULL DEFAULT '0',
            `ugyfel_attr_vegzettseg_aktiv` tinyint unsigned NOT NULL DEFAULT '1',
            `ugyfel_attr_vegzettseg_torolt` tinyint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`ugyfel_attr_vegzettseg_id`),
            KEY `ugyfel_id_INDEX` (`ugyfel_id`),
            KEY `vegzettseg_id_INDEX` (`vegzettseg_id`),
            KEY `letrehozo_id_INDEX` (`letrehozo_id`),
            KEY `modosito_id_INDEX` (`modosito_id`),
            KEY `record_status_INDEX` (`ugyfel_attr_vegzettseg_aktiv`,`ugyfel_attr_vegzettseg_torolt`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci COMMENT='Felhasználókhoz tartozó végzettségek' ;";
        $fkSql = "ALTER TABLE `ugyfel_attr_vegzettseg`
        ADD CONSTRAINT `ugyfel_attr_vegzettseg_letrehozo_id_fk` 
        FOREIGN KEY (`letrehozo_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_vegzettseg_modosito_id_fk` 
        FOREIGN KEY (`modosito_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_vegzettseg_ugyfel_id_fk` 
        FOREIGN KEY (`ugyfel_id`) 
        REFERENCES `ugyfel` (`ugyfel_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_vegzettseg_vegzettseg_id_fk` 
        FOREIGN KEY (`vegzettseg_id`) 
        REFERENCES `vegzettseg` (`vegzettseg_id`) 
        ON DELETE NO ACTION 
        ON UPDATE NO ACTION;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        $this->dropTable('ugyfel_attr_vegzettseg');
    }
}