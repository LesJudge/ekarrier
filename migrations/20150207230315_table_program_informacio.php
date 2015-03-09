<?php

use Phinx\Migration\AbstractMigration;

class TableProgramInformacio extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `program_informacio` (
            `program_informacio_id` int unsigned NOT NULL AUTO_INCREMENT,
            `nev` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
            `has_field` tinyint unsigned NOT NULL DEFAULT '0',
            `letrehozo_id` int unsigned NOT NULL,
            `modosito_id` int unsigned NOT NULL,
            `letrehozas_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modositas_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `modositas_szama` smallint unsigned NOT NULL DEFAULT '0',
            `program_informacio_aktiv` tinyint unsigned NOT NULL DEFAULT '1',
            `program_informacio_torolt` tinyint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`program_informacio_id`),
            UNIQUE KEY `_nev_UNIQUE` (`nev`),
            KEY `letrehozo_id_INDEX` (`letrehozo_id`),
            KEY `modosito_id_INDEX` (`modosito_id`),
            KEY `record_status_INDEX` (`program_informacio_aktiv`,`program_informacio_torolt`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci COMMENT='Program információkat tartalmazó tábla.' ;";
        $fkSql = "ALTER TABLE `program_informacio`
        ADD CONSTRAINT `program_informacio_letrehozo_id_fk` 
        FOREIGN KEY (`letrehozo_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `program_informacio_modosito_id_fk` 
        FOREIGN KEY (`modosito_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('program_informacio');
    }
}