<?php

use Phinx\Migration\AbstractMigration;

class TableJogcsoportFunction extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `jogcsoport_function` (
            `jogcsoport_id` tinyint unsigned NOT NULL,
            `jogcsoport_function_id` int unsigned NOT NULL COMMENT 'modul_function_id',
            PRIMARY KEY (`jogcsoport_id` , `jogcsoport_function_id`),
            KEY `jogcsoport_function_id_INDEX` (`jogcsoport_function_id`)
        )  ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE = utf8_hungarian_ci COMMENT='A jogcsoportok és modul \"funkciók\" közti kapcsolatot leíró tábla.';";
        $fkSql = "ALTER TABLE `jogcsoport_function` 
        ADD CONSTRAINT `jogcsoport_function_jogcsoport_id_fk`
          FOREIGN KEY (`jogcsoport_id`)
          REFERENCES `jogcsoport` (`jogcsoport_id`)
          ON DELETE NO ACTION
          ON UPDATE CASCADE, 
        ADD CONSTRAINT `jogcsoport_function_id_fk` 
          FOREIGN KEY (`jogcsoport_function_id`) 
          REFERENCES `modul_function` (`modul_function_id`) 
          ON DELETE NO ACTION 
          ON UPDATE CASCADE;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        $this->dropTable('jogcsoport_function');
    }
}