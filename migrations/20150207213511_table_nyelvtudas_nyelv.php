<?php

use Phinx\Migration\AbstractMigration;

class TableNyelvtudasNyelv extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `nyelvtudas_nyelv` (
            `nyelvtudas_nyelv_id` tinyint unsigned NOT NULL AUTO_INCREMENT,
            `nev` varchar(128) COLLATE utf8_hungarian_ci NOT NULL,
            `letrehozo_id` int unsigned NOT NULL,
            `modosito_id` int unsigned NOT NULL,
            `letrehozas_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modositas_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `modositas_szama` smallint unsigned NOT NULL DEFAULT '0',
            `nyelvtudas_nyelv_aktiv` tinyint unsigned NOT NULL DEFAULT '1',
            `nyelvtudas_nyelv_torolt` tinyint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`nyelvtudas_nyelv_id`),
            UNIQUE KEY `nyelvtudas_nyelv_nev_UNIQUE` (`nev`),
            KEY `nyelvtudas_nyelv_letrehozo_INDEX` (`letrehozo_id`),
            KEY `nyelvtudas_nyelv_modosito_INDEX` (`modosito_id`),
            KEY `nyelvtudas_nyelv_status_INDEX` (`nyelvtudas_nyelv_aktiv`,`nyelvtudas_nyelv_torolt`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci COMMENT='Nyelvtudáshoz tartozó nyelveket tartalmazó tábla.' ;";
        $fkSql = "ALTER TABLE `nyelvtudas_nyelv`
        ADD CONSTRAINT `nyelvtudas_nyelv_letrehozo_id_fk` 
        FOREIGN KEY (`letrehozo_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `nyelvtudas_nyelv_modosito_id_fk` 
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
        $this->dropTable('nyelvtudas_nyelv');
    }
}