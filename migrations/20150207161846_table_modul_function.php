<?php

use Phinx\Migration\AbstractMigration;

class TableModulFunction extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `modul_function` (
            `modul_function_id` int unsigned NOT NULL AUTO_INCREMENT,
            `site_tipus_id` tinyint unsigned NOT NULL DEFAULT '1',
            `modul_azon` varchar(64) COLLATE utf8_hungarian_ci NOT NULL,
            `modul_function_azon` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
            `modul_function_nev` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
            `modul_function_tipus` enum('__loadController', '__runEvents') COLLATE utf8_hungarian_ci NOT NULL,
            `modul_function_root` tinyint unsigned NOT NULL DEFAULT '0',
            `modul_function_torolt` tinyint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`modul_function_id`),
            UNIQUE KEY (`modul_function_nev`),
            KEY `site_tipus_id_INDEX` (`site_tipus_id`),
            KEY `modul_function_torolt_INDEX` (`modul_function_torolt`),
            KEY `modul_function_root_INDEX` (`modul_function_root`),
            KEY `modul_azon_INDEX` (`modul_azon`)
        )  ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE = utf8_hungarian_ci COMMENT='Modul \"funkciókat\" tartalmazó tábla.';";
        $fkSql = "ALTER TABLE `modul_function` 
        ADD CONSTRAINT `modul_function_site_tipus_id_fk`
          FOREIGN KEY (`site_tipus_id`)
          REFERENCES `site_tipus` (`site_tipus_id`)
          ON DELETE NO ACTION
          ON UPDATE CASCADE, 
        ADD CONSTRAINT `modul_function_modul_azon_fk` 
          FOREIGN KEY (`modul_azon`) 
          REFERENCES `modul` (`modul_azon`) 
          ON DELETE NO ACTION 
          ON UPDATE CASCADE;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        $this->dropTable('modul_function');
    }
}