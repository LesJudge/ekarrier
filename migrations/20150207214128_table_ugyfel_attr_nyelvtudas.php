<?php

use Phinx\Migration\AbstractMigration;

class TableUgyfelAttrNyelvtudas extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `ugyfel_attr_nyelvtudas` (
            `ugyfel_attr_nyelvtudas_id` int unsigned NOT NULL AUTO_INCREMENT,
            `ugyfel_id` int unsigned NOT NULL,
            `nyelvtudas_nyelv_id` tinyint unsigned NOT NULL,
            `nyelvtudas_szint_id` tinyint unsigned NOT NULL,
            `letrehozo_id` int unsigned NOT NULL,
            `modosito_id` int unsigned NOT NULL,
            `letrehozas_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modositas_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `modositas_szama` smallint unsigned NOT NULL DEFAULT '0',
            `ugyfel_attr_nyelvtudas_aktiv` tinyint unsigned NOT NULL DEFAULT '1',
            `ugyfel_attr_nyelvtudas_torolt` tinyint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`ugyfel_attr_nyelvtudas_id`),
            KEY `ugyfel_id_INDEX` (`ugyfel_id`),
            KEY `nyelvtudas_nyelv_id_INDEX` (`nyelvtudas_nyelv_id`),
            KEY `nyelvtudas_szint_id_INDEX` (`nyelvtudas_szint_id`),
            KEY `letrehozo_id_INDEX` (`letrehozo_id`),
            KEY `modosito_id_INDEX` (`modosito_id`),
            KEY `record_status_INDEX` (`ugyfel_attr_nyelvtudas_aktiv`,`ugyfel_attr_nyelvtudas_torolt`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci ;";
        $fkSql = "ALTER TABLE `ugyfel_attr_nyelvtudas`
        ADD CONSTRAINT `ugyfel_attr_nyelvtudas_ugyfel_id_fk` 
        FOREIGN KEY (`ugyfel_id`) 
        REFERENCES `ugyfel` (`ugyfel_id`) 
        ON DELETE NO ACTION ON 
        UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_nyelvtudas_nyelvtudas_nyelv_id_fk` 
        FOREIGN KEY (`nyelvtudas_nyelv_id`) 
        REFERENCES `nyelvtudas_nyelv` (`nyelvtudas_nyelv_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_nyelvtudas_nyelvtudas_szint_id_fk` 
        FOREIGN KEY (`nyelvtudas_szint_id`) 
        REFERENCES `nyelvtudas_szint` (`nyelvtudas_szint_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_nyelvtudas_letrehozo_id_fk` 
        FOREIGN KEY (`letrehozo_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_nyelvtudas_modosito_id_fk` 
        FOREIGN KEY (`modosito_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        $this->dropTable('ugyfel_attr_nyelvtudas');
    }
}