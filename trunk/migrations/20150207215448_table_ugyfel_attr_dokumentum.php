<?php

use Phinx\Migration\AbstractMigration;

class TableUgyfelAttrDokumentum extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `ugyfel_attr_dokumentum` (
            `ugyfel_attr_dokumentum_id` int unsigned NOT NULL AUTO_INCREMENT,
            `ugyfel_id` int unsigned NOT NULL,
            `nev` varchar(64) NOT NULL,
            `dokumentum_nev` varchar(255) NOT NULL,
            `letrehozo_id` int unsigned NOT NULL,
            `modosito_id` int unsigned NOT NULL,
            `letrehozas_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modositas_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `modositas_szama` smallint unsigned NOT NULL DEFAULT '0',
            `ugyfel_attr_dokumentum_aktiv` tinyint unsigned NOT NULL DEFAULT '1',
            `ugyfel_attr_dokumentum_torolt` tinyint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`ugyfel_attr_dokumentum_id`),
            UNIQUE KEY `nev_UNIQUE` (`nev`),
            KEY `ugyfel_id_INDEX` (`ugyfel_id`),
            KEY `letrehozo_id_INDEX` (`letrehozo_id`),
            KEY `modosito_id_INDEX` (`modosito_id`),
            KEY `record_status_INDEX` (`ugyfel_attr_dokumentum_aktiv`,`ugyfel_attr_dokumentum_torolt`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Ügyfélhez tartozó dokumentumokat tartalmazó tábla.' ;";
        $fkSql = "ALTER TABLE `ugyfel_attr_dokumentum`
        ADD CONSTRAINT `ugyfel_attr_dokumentum_ugyfel_id_fk` 
        FOREIGN KEY (`ugyfel_id`) 
        REFERENCES `ugyfel` (`ugyfel_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_dokumentum_letrehozo_id_fk` 
        FOREIGN KEY (`letrehozo_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_dokumentum_modosito_id_fk` 
        FOREIGN KEY (`modosito_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        $this->dropTable('ugyfel_attr_dokumentum');
    }
}