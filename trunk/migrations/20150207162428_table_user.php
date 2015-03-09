<?php

use Phinx\Migration\AbstractMigration;

class TableUser extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `user` (
            `user_id` int unsigned NOT NULL AUTO_INCREMENT,
            `nyelv_id` tinyint unsigned NOT NULL DEFAULT '1',
            `user_fnev` varchar(32) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
            `user_jelszo` varchar(255) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
            `user_email` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
            `user_vnev` varchar(128) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
            `user_knev` varchar(128) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
            `user_kep_nev` varchar(255) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
            `user_hirlevel` tinyint unsigned NOT NULL DEFAULT '0',
            `user_reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `user_megerositve` tinyint unsigned NOT NULL DEFAULT '0',
            `user_megerositve_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `user_last_login` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `user_szum_login` int unsigned NOT NULL DEFAULT '0',
            `user_aktiv` tinyint unsigned NOT NULL DEFAULT '1',
            `user_torolt` tinyint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`user_id`),
            UNIQUE KEY `user_fnev_UNIQUE` (`user_fnev`),
            UNIQUE KEY `user_email_UNIQUE` (`user_email`), 
            KEY `nyelv_id_INDEX` (`nyelv_id`),
            KEY `user_login_INDEX` (`user_fnev` , `user_jelszo`),
            KEY `user_vnev_INDEX` (`user_vnev`),
            KEY `user_knev_INDEX` (`user_knev`),
            KEY `user_megerositve_INDEX` (`user_megerositve`),
            KEY `user_email_INDEX` (`user_email`),
            KEY `record_status_INDEX` (`user_aktiv` , `user_torolt`)
        )  ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE = utf8_hungarian_ci COMMENT='Felhasználókat tartalmazó tábla.';";
        $fkSql = "ALTER TABLE `user`ADD CONSTRAINT 
        `user_nyelv_id_fk` FOREIGN KEY (`nyelv_id`) REFERENCES 
        `nyelv` (`nyelv_id`) ON DELETE NO ACTION ON UPDATE CASCADE;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        $this->dropTable('user');
    }
}