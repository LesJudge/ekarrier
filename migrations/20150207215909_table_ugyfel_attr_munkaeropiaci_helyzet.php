<?php

use Phinx\Migration\AbstractMigration;

class TableUgyfelAttrMunkaeropiaciHelyzet extends AbstractMigration
{
    public function up()
    {
        $tableSql = "CREATE TABLE `ugyfel_attr_munkaeropiaci_helyzet` (
            `ugyfel_id` int unsigned NOT NULL COMMENT 'Felhasználó azonosító.',
            `palyakezdo` bit DEFAULT NULL COMMENT 'Pályakezdő-e?',
            `regisztralt_munkanelkuli` bit DEFAULT NULL COMMENT 'Regisztrált munkanélküli-e?',
            `mikor_regisztralt` date DEFAULT NULL COMMENT 'Mikor regisztrált?',
            `gyes_gyed_visszatero` bit DEFAULT NULL COMMENT 'GYES-ről, GYED-ről visszatérő?',
            `gyes_gyed_lejarati_datum` date DEFAULT NULL COMMENT 'Mikor jár le a GYES, GYED?',
            `megvaltozott_munkakepessegu` bit DEFAULT NULL COMMENT 'Megváltozott munkaképességű-e?',
            `kovetkezo_felulvizsgalat_ideje` date DEFAULT NULL COMMENT 'Következő felülvizsgálat ideje',
            `munkavegzest_korlatozo_egyeb_okok` text COLLATE utf8_hungarian_ci COMMENT 'Munkavégzést korlátozó egyéb okok (pl. bármilyen betegség, ápolási díjban részesül)',
            `dolgozik` bit DEFAULT NULL COMMENT 'Dolgozik',
            `dolgozik_nev` varchar(255) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '' COMMENT 'Cég neve, ha dolgozik.',
            `dolgozik_cim` varchar(255) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '' COMMENT 'Cég címe, ha dolgozik.',
            `dolgozik_munkakor` varchar(255) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '' COMMENT 'Munkakör neve, amiben dolgozik, ha dolgozik.',
            `letrehozo_id` int unsigned NOT NULL,
            `modosito_id` int unsigned NOT NULL,
            `letrehozas_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modositas_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `modositas_szama` smallint unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`ugyfel_id`),
            KEY `letrehozo_id_INDEX` (`letrehozo_id`),
            KEY `modosito_id_INDEX` (`modosito_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci COMMENT='Ügyfélhez tartozó munkaerő piaci helyzeti adatokat tarta';";
        $fkSql = "ALTER TABLE `ugyfel_attr_munkaeropiaci_helyzet`
        ADD CONSTRAINT `ugyfel_attr_mp_helyzet_ugyfel_id_fk` 
        FOREIGN KEY (`ugyfel_id`) 
        REFERENCES `ugyfel` (`ugyfel_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_mp_helyzet_letrehozo_id_fk` 
        FOREIGN KEY (`letrehozo_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE,
        ADD CONSTRAINT `ugyfel_attr_mp_helyzet_modosito_id_fk` 
        FOREIGN KEY (`modosito_id`) 
        REFERENCES `user` (`user_id`) 
        ON DELETE NO ACTION 
        ON UPDATE CASCADE;";
        $this->execute($tableSql);
        $this->execute($fkSql);
    }
    
    public function down()
    {
        $this->dropTable('ugyfel_attr_munkaeropiaci_helyzet');
    }
}