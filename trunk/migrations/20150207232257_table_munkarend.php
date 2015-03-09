<?php

use Phinx\Migration\AbstractMigration;

class TableMunkarend extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `munkarend` (
            `munkarend_id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'Munkarend azonosító.',
            `nev` varchar(255) COLLATE utf8_hungarian_ci NOT NULL COMMENT 'Munkarend neve.',
            `has_field` tinyint unsigned NOT NULL DEFAULT '0' COMMENT 'Tartozik-e a munkarendhez beviteli mező.',
            `letrehozo_id` int unsigned NOT NULL COMMENT 'Létrehozó felhasználó azonosítója.',
            `modosito_id` int unsigned NOT NULL COMMENT 'Módosító felhasználó azonosítója.',
            `letrehozas_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Létrehozás ideje.',
            `modositas_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Módosítás ideje.',
            `modositas_szama` tinyint unsigned NOT NULL DEFAULT '0' COMMENT 'Módosítás száma.',
            `munkarend_aktiv` tinyint unsigned NOT NULL DEFAULT '1' COMMENT 'Megjelenik-e a munkakör.',
            `munkarend_torolt` tinyint unsigned NOT NULL DEFAULT '0' COMMENT 'Törölt-e a munkakör.',
            PRIMARY KEY (`munkarend_id`),
            UNIQUE KEY `nev_UNIQUE` (`nev`),
            KEY `letrehozo_id_INDEX` (`letrehozo_id`),
            KEY `modosito_id_INDEX` (`modosito_id`),
            KEY `record_status_INDEX` (`munkarend_aktiv`,`munkarend_torolt`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci COMMENT='Munkarendeket tartalmazó tábla.' ;";
        $fkSql = "ALTER TABLE `munkarend`
        ADD CONSTRAINT `munkarend_letrehozo_id_fk` 
        FOREIGN KEY (`letrehozo_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `munkarend_modosito_id_fk` 
        FOREIGN KEY (`modosito_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        $this->dropTable('munkarend');
    }
}