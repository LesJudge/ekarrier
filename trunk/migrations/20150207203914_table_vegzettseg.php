<?php

use Phinx\Migration\AbstractMigration;

class TableVegzettseg extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `vegzettseg` (
            `vegzettseg_id` int unsigned NOT NULL AUTO_INCREMENT,
            `nev` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
            `modositas_szama` int unsigned NOT NULL DEFAULT '0',
            `letrehozas_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modositas_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `letrehozo_id` int unsigned NOT NULL COMMENT 'user_id',
            `modosito_id` int unsigned NOT NULL COMMENT 'user_id',
            `vegzettseg_aktiv` tinyint unsigned NOT NULL DEFAULT '1',
            `vegzettseg_torolt` tinyint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`vegzettseg_id`),
            KEY `vegzettseg_status_INDEX` (`vegzettseg_aktiv`,`vegzettseg_torolt`),
            KEY `letrehozo_id_INDEX` (`letrehozo_id`),
            KEY `modosito_id_INDEX` (`modosito_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci COMMENT='A végzettségeket tartalmazó tábla.' ;";
        $fkSql = "ALTER TABLE `vegzettseg`
        ADD CONSTRAINT `vegzettseg_letrehozo_id_fk` 
        FOREIGN KEY (`letrehozo_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE NO ACTION,
        ADD CONSTRAINT `vegzettseg_modosito_id_fk` 
        FOREIGN KEY (`modosito_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE NO ACTION;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        $this->dropTable('vegzettseg');
    }
}