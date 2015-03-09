<?php

use Phinx\Migration\AbstractMigration;

class TableJogcsoport extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `jogcsoport` (
            `jogcsoport_id` tinyint unsigned NOT NULL AUTO_INCREMENT,
            `site_tipus_id` tinyint unsigned NOT NULL,
            `jogcsoport_nev` varchar(64) COLLATE utf8_hungarian_ci NOT NULL,
            `jogcsoport_aktiv` tinyint unsigned NOT NULL DEFAULT '1',
            `jogcsoport_torolt` tinyint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`jogcsoport_id`),
            UNIQUE KEY `jogcsoport_nev_UNIQUE` (`jogcsoport_nev`),
            KEY `site_tipus_id_INDEX` (`site_tipus_id`),
            KEY `record_status_INDEX` (`jogcsoport_aktiv` , `jogcsoport_torolt`)
        )  ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE = utf8_hungarian_ci COMMENT='Jogosultság csoportokat tartalmazó tábla.';";
        $fkSql = "ALTER TABLE `jogcsoport` 
        ADD CONSTRAINT `jogcsoport_site_tipus_id_fk`
          FOREIGN KEY (`site_tipus_id`)
          REFERENCES `site_tipus` (`site_tipus_id`)
          ON DELETE NO ACTION
          ON UPDATE CASCADE;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        $this->dropTable('jogcsoport');
    }
}