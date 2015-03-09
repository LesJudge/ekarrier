<?php

use Phinx\Migration\AbstractMigration;

class TableUserUgyfel extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE IF NOT EXISTS `user_ugyfel` (
            `user_id` int unsigned NOT NULL COMMENT 'Az ügyfél felhasználó azonosítóját tároló mező.',
            `ugyfel_id` int unsigned NOT NULL,
            PRIMARY KEY (`user_id`,`ugyfel_id`),
            KEY `ugyfel_id_INDEX` (`ugyfel_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci COMMENT='Az ügyfélhez tartozó adatokat tároló tábla.';";
        $fkSql = "ALTER TABLE `user_ugyfel`
        ADD CONSTRAINT `user_ugyfel_user_id_fk` 
        FOREIGN KEY (`user_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE, 
        ADD CONSTRAINT `user_ugyfel_ugyfel_id_fk` 
        FOREIGN KEY (`ugyfel_id`) 
        REFERENCES `ugyfel` (`ugyfel_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        $this->dropTable('user_ugyfel');
    }
}