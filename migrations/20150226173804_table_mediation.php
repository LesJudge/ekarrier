<?php

use Phinx\Migration\AbstractMigration;

class TableMediation extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `ugyfel_attr_kozvetites` (
            `ugyfel_attr_kozvetites_id` int unsigned NOT NULL AUTO_INCREMENT,
            `ugyfel_attr_esetnaplo_id` int unsigned NOT NULL,
            `hova` VARCHAR(128) COLLATE utf8_hungarian_ci NOT NULL,
            `megjelent` BIT NOT NULL,
            `mikor` DATE NOT NULL,
            `letrehozo_id` int unsigned NOT NULL,
            `modosito_id` int unsigned NOT NULL,
            `letrehozas_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modositas_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `modositas_szama` smallint unsigned NOT NULL DEFAULT '0',
            `ugyfel_attr_kozvetites_aktiv` tinyint unsigned NOT NULL DEFAULT '1',
            `ugyfel_attr_kozvetites_torolt` tinyint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`ugyfel_attr_kozvetites_id`),
            KEY `ugyfel_attr_esetnaplo_id_INDEX` (`ugyfel_attr_esetnaplo_id`),
            KEY `letrehozo_id_INDEX` (`letrehozo_id`),
            KEY `modosito_id_INDEX` (`modosito_id`),
            KEY `record_status_INDEX` (`ugyfel_attr_kozvetites_aktiv`,`ugyfel_attr_kozvetites_torolt`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci COMMENT='Ügyfélhez tartozó közvetítések.' ;";
        $fkSql = "ALTER TABLE `ugyfel_attr_kozvetites`
        ADD CONSTRAINT `ugyfel_attr_kozvetites_letrehozo_id_fk` 
        FOREIGN KEY (`letrehozo_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_kozvetites_modosito_id_fk` 
        FOREIGN KEY (`modosito_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_kozvetites_ugyfel_attr_esetnaplo_id_fk` 
        FOREIGN KEY (`ugyfel_attr_esetnaplo_id`) 
        REFERENCES `ugyfel_attr_esetnaplo` (`ugyfel_attr_esetnaplo_id`) 
        ON DELETE NO ACTION 
        ON UPDATE NO ACTION;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('ugyfel_attr_kozvetites');
    }
}