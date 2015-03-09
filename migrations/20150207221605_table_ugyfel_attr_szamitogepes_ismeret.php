<?php

use Phinx\Migration\AbstractMigration;

class TableUgyfelAttrSzamitogepesIsmeret extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `ugyfel_attr_szamitogepes_ismeret` (
            `ugyfel_attr_szamitogepes_ismeret_id` int unsigned NOT NULL AUTO_INCREMENT,
            `ugyfel_id` int unsigned NOT NULL,
            `ismeret` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
            `letrehozo_id` int unsigned NOT NULL,
            `modosito_id` int unsigned NOT NULL,
            `letrehozas_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modositas_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `modositas_szama` smallint unsigned NOT NULL DEFAULT '0',
            `ugyfel_attr_szamitogepes_ismeret_aktiv` tinyint unsigned NOT NULL DEFAULT '1',
            `ugyfel_attr_szamitogepes_ismeret_torolt` tinyint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`ugyfel_attr_szamitogepes_ismeret_id`),
            KEY `ugyfel_id_INDEX` (`ugyfel_id`),
            KEY `ismeret_INDEX` (`ismeret`),
            KEY `letrehozo_id_INDEX` (`letrehozo_id`),
            KEY `modosito_id_INDEX` (`modosito_id`),
            KEY `record_status_INDEX` (`ugyfel_attr_szamitogepes_ismeret_aktiv`,`ugyfel_attr_szamitogepes_ismeret_torolt`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci COMMENT='Felhasználóhoz tartozó számítógépes ismereteket tároló tábla' ;";
        $fkSql = "ALTER TABLE `ugyfel_attr_szamitogepes_ismeret`
        ADD CONSTRAINT `ugyfel_attr_szamitogepes_ismeret_letrehozo_id` 
        FOREIGN KEY (`letrehozo_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_szamitogepes_ismeret_modosito_id` 
        FOREIGN KEY (`modosito_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_szamitogepes_ismeret_ugyfel_id` 
        FOREIGN KEY (`ugyfel_id`) 
        REFERENCES `ugyfel` (`ugyfel_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        $this->dropTable('ugyfel_attr_szamitogepes_ismeret');
    }
}