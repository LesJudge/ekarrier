<?php

use Phinx\Migration\AbstractMigration;

class TableUserJogcsoport extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `user_jogcsoport` (
            `user_jogcsoport_id` tinyint unsigned NOT NULL,
            `user_id` int unsigned NOT NULL,
            PRIMARY KEY (`user_jogcsoport_id`,`user_id`),
            KEY `user_id_INDEX` (`user_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci COMMENT='A felhasználók és jogosultság csoportok közti kapcsolatot leíró tábla.';";
        $fkSql = "ALTER TABLE `user_jogcsoport` 
        ADD CONSTRAINT `user_jogcsoport_user_jogcsoport_id_fk`
          FOREIGN KEY (`user_jogcsoport_id`)
          REFERENCES `jogcsoport` (`jogcsoport_id`)
          ON DELETE NO ACTION
          ON UPDATE CASCADE, 
        ADD CONSTRAINT `user_jogcsoport_user_id_fk` 
          FOREIGN KEY (`user_id`) 
          REFERENCES `user` (`user_id`) 
          ON DELETE NO ACTION 
          ON UPDATE CASCADE;";
        
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        $this->dropTable('user_jogcsoport');
    }
}