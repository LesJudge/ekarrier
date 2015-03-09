<?php

use Phinx\Migration\AbstractMigration;

class TableUgyfelAttrProjektInformacio extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `ugyfel_attr_projekt_informacio` (
            `ugyfel_id` int unsigned NOT NULL,
            `eu_prog_elm_ket_ev` bit DEFAULT NULL COMMENT 'Uniós finanszírozású programban részt vett-e az elmúlt 2 évben?',
            `hazai_prog_elm_ket_ev` bit DEFAULT NULL COMMENT 'Hazai finanszírozású programban részt vett-e az elmúlt 2 évben?',
            `kozvetitio_adatbazisba_kivan_kerulni` bit DEFAULT NULL COMMENT 'Közvetítői adatbázisba kíván e kerülni?',
            `hozzajarul_a_munkakozvetiteshez` bit DEFAULT NULL COMMENT 'Hozzájárult-e munkaközvetítéshez?',
            `mobilitast_vallal` bit DEFAULT NULL COMMENT 'Mobilitást vállal e?',
            `mobilitast_vallal_megjegyzes` varchar(255) COLLATE utf8_hungarian_ci DEFAULT NULL,
            `kk_trening_resztvett` bit DEFAULT NULL COMMENT 'Kulcs. Képességfejl. Tréningen részt vett-e?',
            `graf_elemz_resztvett` bit DEFAULT NULL COMMENT 'Grafológiai elemzésen részt vett-e?',
            `jogi_tadas_resztvett` bit DEFAULT NULL COMMENT 'Jogi tanácsadáson részt vett-e?',
            `kepz_tanad_resztvett` bit DEFAULT NULL COMMENT 'Képzési tanácsadáson részt vett-e?',
            `munka_tanad_resztvett` bit DEFAULT NULL COMMENT 'Munkatanácsadáson részt vett-e?',
            `pszich_tanad_resztvett` bit DEFAULT NULL COMMENT 'Pszichológiai tanácsadáson részt vett-e?',
            `egy_megall_ktttnk_prog` bit DEFAULT NULL COMMENT 'Együttműködési megállapodást kötöttünk-e vele a programba?',
            `egy_megall_ktttnk_kepz` bit DEFAULT NULL COMMENT 'Együttműködési megállapodást kötöttünk-e vele a képzésbe?',
            `kepzes_bekerult` int DEFAULT NULL COMMENT 'Melyik képzésbe került be?',
            `karrierpont_id` tinyint unsigned DEFAULT NULL,
            `letrehozo_id` int unsigned NOT NULL,
            `modosito_id` int unsigned NOT NULL,
            `letrehozas_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modositas_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `modositas_szama` smallint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`ugyfel_id`),
            KEY `karrierpont_id_INDEX` (`karrierpont_id`),
            KEY `letrehozo_id_INDEX` (`letrehozo_id`),
            KEY `modosito_id_INDEX` (`modosito_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci COMMENT='Felhasználókhoz tartozó projekt információs adatok.';";
        $fkSql = "ALTER TABLE `ugyfel_attr_projekt_informacio`
        ADD CONSTRAINT `ugyfel_attr_projekt_informacio_ugyfel_id_fk` 
        FOREIGN KEY (`ugyfel_id`) 
        REFERENCES `ugyfel` (`ugyfel_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_projekt_informacio_karrierpont_id_fk` 
        FOREIGN KEY (`karrierpont_id`) 
        REFERENCES `karrierpont` (`karrierpont_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_projekt_informacio_letrehozo_id_fk` 
        FOREIGN KEY (`letrehozo_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_projekt_informacio_modosito_id_fk` 
        FOREIGN KEY (`modosito_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        $this->dropTable('ugyfel_attr_projekt_informacio');
    }
}