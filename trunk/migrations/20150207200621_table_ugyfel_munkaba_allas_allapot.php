<?php

use Phinx\Migration\AbstractMigration;

class TableUgyfelMunkabaAllasAllapot extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `ugyfel_munkaba_allas_allapot` (
            `ugyfel_munkaba_allas_allapot_id` int unsigned NOT NULL AUTO_INCREMENT,
            `nev` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
            `letrehozo_id` int unsigned NOT NULL,
            `modosito_id` int unsigned NOT NULL,
            `letrehozas_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modositas_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `modositas_szama` smallint unsigned NOT NULL DEFAULT '0',
            `ugyfel_munkaba_allas_allapot_aktiv` tinyint unsigned NOT NULL DEFAULT '1',
            `ugyfel_munkaba_allas_allapot_torolt` tinyint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`ugyfel_munkaba_allas_allapot_id`),
            UNIQUE KEY `nev_UNIQUE` (`nev`),
            KEY `letrehozo_id_INDEX` (`letrehozo_id`),
            KEY `modosito_id_INDEX` (`modosito_id`),
            KEY `record_status_INDEX` (`ugyfel_munkaba_allas_allapot_aktiv`,`ugyfel_munkaba_allas_allapot_torolt`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci COMMENT='Ügyfelekhez tartozó \"munkába állás állapot\"-okat tároló tábla' ;";
        $fkSql = "ALTER TABLE `ugyfel_munkaba_allas_allapot`
        ADD CONSTRAINT `ugyfel_munkaba_allas_allapot_letrehozo_id_fk` 
        FOREIGN KEY (`letrehozo_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_munkaba_allas_allapot_modosito_id_fk` 
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
        $this->dropTable('ugyfel_munkaba_allas_allapot');
    }
}