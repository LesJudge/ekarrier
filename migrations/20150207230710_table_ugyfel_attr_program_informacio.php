<?php

use Phinx\Migration\AbstractMigration;

class TableUgyfelAttrProgramInformacio extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `ugyfel_attr_program_informacio` (
            `ugyfel_attr_program_informacio_id` int unsigned NOT NULL AUTO_INCREMENT,
            `ugyfel_id` int unsigned NOT NULL,
            `program_informacio_id` int unsigned NOT NULL,
            `egyeb` varchar(255) COLLATE utf8_hungarian_ci DEFAULT NULL,
            `letrehozo_id` int unsigned NOT NULL,
            `modosito_id` int unsigned NOT NULL,
            `letrehozas_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modositas_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `modositas_szama` smallint unsigned NOT NULL DEFAULT '0',
            `ugyfel_attr_program_informacio_aktiv` tinyint unsigned NOT NULL DEFAULT '1',
            `ugyfel_attr_program_informacio_torolt` tinyint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`ugyfel_attr_program_informacio_id`),
            KEY `ugyfel_id_INDEX` (`ugyfel_id`),
            KEY `program_informacio_id_INDEX` (`program_informacio_id`),
            KEY `letrehozo_id_INDEX` (`letrehozo_id`),
            KEY `modosito_id_INDEX` (`modosito_id`),
            KEY `record_status_INDEX` (`ugyfel_attr_program_informacio_aktiv`,`ugyfel_attr_program_informacio_torolt`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci ;";
        $fkSql = "ALTER TABLE `ugyfel_attr_program_informacio`
        ADD CONSTRAINT `ugyfel_attr_program_informacio_ugyfel_id_fk` 
        FOREIGN KEY (`ugyfel_id`) 
        REFERENCES `ugyfel` (`ugyfel_id`) 
        ON DELETE NO ACTION 
        ON UPDATE NO ACTION,
        ADD CONSTRAINT `ugyfel_attr_program_informacio_program_informacio_id_fk` 
        FOREIGN KEY (`program_informacio_id`) 
        REFERENCES `program_informacio` (`program_informacio_id`) 
        ON DELETE NO ACTION 
        ON UPDATE NO ACTION,
        ADD CONSTRAINT `ugyfel_attr_program_informacio_letrehozo_id_fk` 
        FOREIGN KEY (`letrehozo_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE NO ACTION,
        ADD CONSTRAINT `ugyfel_attr_program_informacio_modosito_id_fk` 
        FOREIGN KEY (`modosito_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE NO ACTION;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        $this->dropTable('ugyfel_attr_program_informacio');
    }
}