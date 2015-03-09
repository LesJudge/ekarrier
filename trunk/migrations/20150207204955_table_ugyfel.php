<?php

use Phinx\Migration\AbstractMigration;

class TableUgyfel extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `ugyfel` (
            `ugyfel_id` int unsigned NOT NULL AUTO_INCREMENT,
            `ugyfel_munkakor_kategoria_id` int unsigned DEFAULT NULL,
            `ugyfel_munkaba_allas_allapot_id` int unsigned DEFAULT NULL,
            `vegzettseg_id` int unsigned DEFAULT NULL,
            `email` varchar(255) NOT NULL,
            `vezeteknev` varchar(128) NOT NULL,
            `keresztnev` varchar(128) NOT NULL,
            `anyja_neve` varchar(255) NOT NULL DEFAULT '',
            `nem` enum('male','female') NOT NULL,
            `egyeb_munkakorok_erdeklik` varchar(255) NOT NULL DEFAULT '',
            `telefonszam_vezetekes` varchar(10) NOT NULL DEFAULT '',
            `telefonszam_mobil1` varchar(11) NOT NULL DEFAULT '',
            `telefonszam_mobil2` varchar(11) NOT NULL DEFAULT '',
            `user_hirlevel` tinyint unsigned NOT NULL DEFAULT '1',
            `kapcsolatfelvetel_ideje` datetime DEFAULT NULL,
            `letrehozo_id` int unsigned NOT NULL,
            `modosito_id` int unsigned NOT NULL,
            `letrehozas_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modositas_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `modositas_szama` smallint unsigned NOT NULL DEFAULT '0',
            `ugyfel_aktiv` tinyint unsigned NOT NULL DEFAULT '1',
            `ugyfel_torolt` tinyint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`ugyfel_id`),
            KEY `munkakor_kategoria_INDEX` (`ugyfel_munkakor_kategoria_id`),
            KEY `munkaba_allas_allapot_INDEX` (`ugyfel_munkaba_allas_allapot_id`),
            KEY `vegzettseg_id_INDEX` (`vegzettseg_id`),
            KEY `letrehozo_id_INDEX` (`letrehozo_id`),
            KEY `modosito_id_INDEX` (`modosito_id`),
            KEY `record_status_INDEX` (`ugyfel_aktiv`,`ugyfel_torolt`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Ügyfeleket tartalmazó tábla.' ;";
        $fkSql = "ALTER TABLE `ugyfel`
        ADD CONSTRAINT `ugyfel_ugyfel_munkakor_kategoria_id_fk` 
        FOREIGN KEY (`ugyfel_munkakor_kategoria_id`) 
        REFERENCES `ugyfel_munkakor_kategoria` (`ugyfel_munkakor_kategoria_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_ugyfel_munkaba_allas_allapot_id_fk` 
        FOREIGN KEY (`ugyfel_munkaba_allas_allapot_id`) 
        REFERENCES `ugyfel_munkaba_allas_allapot` (`ugyfel_munkaba_allas_allapot_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_vegzettseg_id_fk` 
        FOREIGN KEY (`vegzettseg_id`) 
        REFERENCES `vegzettseg` (`vegzettseg_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_letrehozo_id_fk` 
        FOREIGN KEY (`letrehozo_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_modosito_id_fk` 
        FOREIGN KEY (`modosito_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        $this->dropTable('ugyfel');
    }
}