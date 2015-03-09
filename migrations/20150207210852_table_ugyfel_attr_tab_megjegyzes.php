<?php

use Phinx\Migration\AbstractMigration;

class TableUgyfelAttrTabMegjegyzes extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `ugyfel_attr_tab_megjegyzes` (
        `ugyfel_attr_tab_megjegyzes_id` int unsigned NOT NULL AUTO_INCREMENT,
        `ugyfel_id` int unsigned NOT NULL,
        `ugyfel_tab_id` tinyint unsigned NOT NULL,
        `megjegyzes` text COLLATE utf8_hungarian_ci NOT NULL,
        `letrehozo_id` int unsigned NOT NULL,
        `modosito_id` int unsigned NOT NULL,
        `letrehozas_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `modositas_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
        `modositas_szama` smallint unsigned NOT NULL DEFAULT '0',
        `ugyfel_attr_tab_megjegyzes_aktiv` tinyint unsigned NOT NULL DEFAULT '1',
        `ugyfel_attr_tab_megjegyzes_torolt` tinyint unsigned NOT NULL DEFAULT '0',
        PRIMARY KEY (`ugyfel_attr_tab_megjegyzes_id`),
        KEY `ugyfel_tab_id_INDEX` (`ugyfel_tab_id`),
        KEY `letrehozo_id_INDEX` (`letrehozo_id`),
        KEY `modosito_id_INDEX` (`modosito_id`),
        KEY `status_INDEX` (`ugyfel_attr_tab_megjegyzes_aktiv`,`ugyfel_attr_tab_megjegyzes_torolt`),
        KEY `ugyfel_id_INDEX` (`ugyfel_id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci ;";
        $fkSql = "ALTER TABLE `ugyfel_attr_tab_megjegyzes`
        ADD CONSTRAINT `ugyfel_attr_tab_megjegyzes_ugyfel_id_fk` 
        FOREIGN KEY (`ugyfel_id`) 
        REFERENCES `ugyfel` (`ugyfel_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_tab_megjegyzes_letrehozo_id_fk` 
        FOREIGN KEY (`letrehozo_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_tab_megjegyzes_modosito_id_fk` 
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
        $this->dropTable('ugyfel_attr_tab_megjegyzes');
    }
}