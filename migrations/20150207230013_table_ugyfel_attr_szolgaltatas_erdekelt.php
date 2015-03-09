<?php

use Phinx\Migration\AbstractMigration;

class TableUgyfelAttrSzolgaltatasErdekelt extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `ugyfel_attr_szolgaltatas_erdekelt` (
            `ugyfel_attr_szolgaltatas_erdekelt_id` int unsigned NOT NULL AUTO_INCREMENT,
            `ugyfel_id` int unsigned NOT NULL COMMENT 'Ügyfél azonosítója.',
            `szolgaltatas_id` int unsigned NOT NULL COMMENT 'Szolgáltatás azonosítója.',
            `reszt_akar_venni` bit DEFAULT NULL COMMENT 'Részt akar-e venni a szolgáltatáson.',
            `reszt_vett` bit DEFAULT NULL COMMENT 'Részt vett-e a szolgáltatáson.',
            `mikor` date DEFAULT NULL COMMENT 'Mikor vett részt a szolgáltatáson.',
            `letrehozo_id` int unsigned NOT NULL,
            `modosito_id` int unsigned NOT NULL,
            `letrehozas_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modositas_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `modositas_szama` smallint unsigned NOT NULL DEFAULT '0',
            `ugyfel_attr_szolgaltatas_erdekelt_aktiv` tinyint unsigned NOT NULL DEFAULT '1',
            `ugyfel_attr_szolgaltatas_erdekelt_torolt` tinyint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`ugyfel_attr_szolgaltatas_erdekelt_id`),
            KEY `ugyfel_id_INDEX` (`ugyfel_id`),
            KEY `szolgaltatas_id_INDEX` (`szolgaltatas_id`),
            KEY `letrehozo_id_INDEX` (`letrehozo_id`),
            KEY `modosito_id_INDEX` (`modosito_id`),
            KEY `record_status_INDEX` (`ugyfel_attr_szolgaltatas_erdekelt_aktiv`,`ugyfel_attr_szolgaltatas_erdekelt_torolt`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci COMMENT='Ügyfelek és szolgáltatások (amelyek érdeklik) közti kapc' ;";
        $fkSql = "ALTER TABLE `ugyfel_attr_szolgaltatas_erdekelt`
        ADD CONSTRAINT `ugyfel_attr_szolgaltatas_erdekelt_ugyfel_id_fk` 
        FOREIGN KEY (`ugyfel_id`) 
        REFERENCES `ugyfel` (`ugyfel_id`) 
        ON DELETE NO ACTION 
        ON UPDATE NO ACTION,
        ADD CONSTRAINT `ugyfel_attr_szolgaltatas_erdekelt_szolgaltatas_id_fk` 
        FOREIGN KEY (`szolgaltatas_id`) 
        REFERENCES `szolgaltatas` (`szolgaltatas_id`) 
        ON DELETE NO ACTION 
        ON UPDATE NO ACTION,
        ADD CONSTRAINT `ugyfel_attr_szolgaltatas_erdekelt_letrehozo_id_fk` 
        FOREIGN KEY (`letrehozo_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE NO ACTION,
        ADD CONSTRAINT `ugyfel_attr_szolgaltatas_erdekelt_modosito_id_fk` 
        FOREIGN KEY (`modosito_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE NO ACTION;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        $this->dropTable('ugyfel_attr_szolgaltatas_erdekelt');
    }
}