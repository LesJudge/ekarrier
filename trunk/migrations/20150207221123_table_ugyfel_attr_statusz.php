<?php

use Phinx\Migration\AbstractMigration;

class TableUgyfelAttrStatusz extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `ugyfel_attr_statusz` (
            `ugyfel_id` int unsigned NOT NULL,
            `aktualis_statusz` tinyint unsigned DEFAULT NULL,
            `kovetkezo_statusz` tinyint unsigned DEFAULT NULL,
            `idotartam` tinyint unsigned DEFAULT NULL,
            `letrehozo_id` int unsigned NOT NULL,
            `modosito_id` int unsigned NOT NULL,
            `letrehozas_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modositas_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `modositas_szama` smallint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`ugyfel_id`),
            KEY `aktualis_statusz_INDEX` (`aktualis_statusz`),
            KEY `kovetkezo_statusz_INDEX` (`kovetkezo_statusz`),
            KEY `letrehozo_id_INDEX` (`letrehozo_id`),
            KEY `modosito_id_INDEX` (`modosito_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci COMMENT='Ügyfél státusz adatokat tároló tábla.';";
        $fkSql = "ALTER TABLE `ugyfel_attr_statusz`
        ADD CONSTRAINT `ugyfel_attr_statusz_modosito_id_fk` 
        FOREIGN KEY (`modosito_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_statusz_aktualias_statusz_fk` 
        FOREIGN KEY (`aktualis_statusz`) 
        REFERENCES `ugyfel_statusz` (`ugyfel_statusz_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_statusz_kovetkezo_statusz_fk` 
        FOREIGN KEY (`kovetkezo_statusz`) 
        REFERENCES `ugyfel_statusz` (`ugyfel_statusz_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_statusz_letrehozo_id_fk` 
        FOREIGN KEY (`letrehozo_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_statusz_ugyfel_id_fk` 
        FOREIGN KEY (`ugyfel_id`) 
        REFERENCES `ugyfel` (`ugyfel_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        $this->dropTable('ugyfel_attr_statusz');
    }
}