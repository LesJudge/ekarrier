<?php

return array(
    'firstname' => array(
        'Uniweb\\Library\\DynamicFilter\\Filter\\String', array(
            'field' => 'keresztnev',
            'select' => 'ugyfel_id',
            'table' => 'ugyfel'
        )
    ),
    'lastname' => array(
        'Uniweb\\Library\\DynamicFilter\\Filter\\String', array(
            'field' => 'vezeteknev',
            'select' => 'ugyfel_id',
            'table' => 'ugyfel'
        )
    ),
    'email' => array(
        'Uniweb\\Library\\DynamicFilter\\Filter\\String', array(
            'field' => 'email',
            'select' => 'ugyfel_id',
            'table' => 'ugyfel'
        )
    ),
    'motherName' => array(
        'Uniweb\\Library\\DynamicFilter\\Filter\\String', array(
            'field' => 'anyja_neve',
            'select' => 'ugyfel_id',
            'table' => 'ugyfel'
        )
    ),
    'birthFirstname' => array(
        'Uniweb\\Library\\DynamicFilter\\Filter\\String', array(
            'field' => 'keresztnev',
            'select' => 'ugyfel_id',
            'table' => 'ugyfel_attr_szuletesi_adatok'
        )
    ),
    'birthLastname' => array(
        'Uniweb\\Library\\DynamicFilter\\Filter\\String', array(
            'field' => 'vezeteknev',
            'select' => 'ugyfel_id',
            'table' => 'ugyfel_attr_szuletesi_adatok'
        )
    ),
    'birthdate' => array(
        'Uniweb\\Library\\DynamicFilter\\Filter\\Date', array(
            'field' => 'szuletesi_ido',
            'select' => 'ugyfel_id',
            'table' => 'ugyfel_attr_szuletesi_adatok'
        )
    ),
    'service' => array('Uniweb\\Module\\Ugyfel\\Library\\DynamicFilter\\Filter\\Service'),
    'education' => array('Uniweb\\Module\\Ugyfel\\Library\\DynamicFilter\\Filter\\Education'),
    'highestEducation' => array('Uniweb\\Module\\Ugyfel\\Library\\DynamicFilter\\Filter\\HighestEducation'),
    'phoneLandline' => array(
        'Uniweb\\Library\\DynamicFilter\\Filter\\String', array(
            'field' => 'telefonszam_vezetekes',
            'select' => 'ugyfel_id',
            'table' => 'ugyfel'
        )
    ),
    'phoneMobile1' => array(
        'Uniweb\\Library\\DynamicFilter\\Filter\\String', array(
            'field' => 'telefonszam_mobil1',
            'select' => 'ugyfel_id',
            'table' => 'ugyfel'
        )
    ),
    'phoneMobile2' => array(
        'Uniweb\\Library\\DynamicFilter\\Filter\\String', array(
            'field' => 'telefonszam_mobil2',
            'select' => 'ugyfel_id',
            'table' => 'ugyfel'
        )
    ),
    'palyakezdo' => array(
        'Uniweb\\Library\\DynamicFilter\\Filter\\TrueOrFalse', array(
            'field' => 'palyakezdo',
            'select' => 'ugyfel_id',
            'table' => 'ugyfel_attr_munkaeropiaci_helyzet'
        )
    ),
    'regisztraltMunkanelkuli' => array(
        'Uniweb\\Library\\DynamicFilter\\Filter\\TrueOrFalse', array(
            'field' => 'regisztralt_munkanelkuli',
            'select' => 'ugyfel_id',
            'table' => 'ugyfel_attr_munkaeropiaci_helyzet'
        )
    ),
    'gyesGyedVisszatero' => array(
        'Uniweb\\Library\\DynamicFilter\\Filter\\TrueOrFalse', array(
            'field' => 'gyes_gyed_visszatero',
            'select' => 'ugyfel_id',
            'table' => 'ugyfel_attr_munkaeropiaci_helyzet'
        )
    ),
    'megvaltozottMunkakepessegu' => array(
        'Uniweb\\Library\\DynamicFilter\\Filter\\TrueOrFalse', array(
            'field' => 'megvaltozott_munkakepessegu',
            'select' => 'ugyfel_id',
            'table' => 'ugyfel_attr_munkaeropiaci_helyzet'
        )
    ),
    'dolgozik' => array(
        'Uniweb\\Library\\DynamicFilter\\Filter\\TrueOrFalse', array(
            'field' => 'dolgozik',
            'select' => 'ugyfel_id',
            'table' => 'ugyfel_attr_munkaeropiaci_helyzet'
        )
    ),
    'dolgozikCeg' => array(
        'Uniweb\\Library\\DynamicFilter\\Filter\\String', array(
            'field' => 'dolgozik_nev',
            'select' => 'ugyfel_id',
            'table' => 'ugyfel_attr_munkaeropiaci_helyzet'
        )
    ),
    'dolgozikCim' => array(
        'Uniweb\\Library\\DynamicFilter\\Filter\\String', array(
            'field' => 'dolgozik_cim',
            'select' => 'ugyfel_id',
            'table' => 'ugyfel_attr_munkaeropiaci_helyzet'
        )
    ),
    'dolgozikMunkakor' => array(
        'Uniweb\\Library\\DynamicFilter\\Filter\\String', array(
            'field' => 'dolgozik_munkakor',
            'select' => 'ugyfel_id',
            'table' => 'ugyfel_attr_munkaeropiaci_helyzet'
        )
    ),
    'munkavegzestKorlatozoEgyebOkok' => array(
        'Uniweb\\Library\\DynamicFilter\\Filter\\String', array(
            'field' => 'munkavegzest_korlatozo_egyeb_okok',
            'select' => 'ugyfel_id',
            'table' => 'ugyfel_attr_munkaeropiaci_helyzet'
        )
    ),
    'mikorRegisztralt' => array(
        'Uniweb\\Library\\DynamicFilter\\Filter\\Date', array(
            'field' => 'mikor_regisztralt',
            'select' => 'ugyfel_id',
            'table' => 'ugyfel_attr_munkaeropiaci_helyzet'
        )
    ),
    'gyesGyedLejaratiDatum' => array(
        'Uniweb\\Library\\DynamicFilter\\Filter\\Date', array(
            'field' => 'gyes_gyed_lejarati_datum',
            'select' => 'ugyfel_id',
            'table' => 'ugyfel_attr_munkaeropiaci_helyzet'
        )
    ),
    'kovetkezoFelulvizsgalatIdeje' => array(
        'Uniweb\\Library\\DynamicFilter\\Filter\\Date', array(
            'field' => 'kovetkezo_felulvizsgalat_ideje',
            'select' => 'ugyfel_id',
            'table' => 'ugyfel_attr_munkaeropiaci_helyzet'
        )
    ),
    'euProgram' => array(
        'Uniweb\\Library\\DynamicFilter\\Filter\\TrueOrFalse', array(
            'field' => 'eu_prog_elm_ket_ev',
            'select' => 'ugyfel_id',
            'table' => 'ugyfel_attr_projekt_informacio'
        )
    ),
    'hazaiProgram' => array(
        'Uniweb\\Library\\DynamicFilter\\Filter\\TrueOrFalse', array(
            'field' => 'hazai_prog_elm_ket_ev',
            'select' => 'ugyfel_id',
            'table' => 'ugyfel_attr_projekt_informacio'
        )
    ),
    'kozvetitioAdatbazisbaKivanKerulni' => array(
        'Uniweb\\Library\\DynamicFilter\\Filter\\TrueOrFalse', array(
            'field' => 'kozvetitio_adatbazisba_kivan_kerulni',
            'select' => 'ugyfel_id',
            'table' => 'ugyfel_attr_projekt_informacio'
        )
    ),
    'mobilitastVallal' => array(
        'Uniweb\\Library\\DynamicFilter\\Filter\\TrueOrFalse', array(
            'field' => 'mobilitast_vallal',
            'select' => 'ugyfel_id',
            'table' => 'ugyfel_attr_projekt_informacio'
        )
    ),
    'hozzajarulAMunkakozvetiteshez' => array(
        'Uniweb\\Library\\DynamicFilter\\Filter\\TrueOrFalse', array(
            'field' => 'hozzajarul_a_munkakozvetiteshez',
            'select' => 'ugyfel_id',
            'table' => 'ugyfel_attr_projekt_informacio'
        )
    ),
    'egyMegallProg' => array(
        'Uniweb\\Library\\DynamicFilter\\Filter\\TrueOrFalse', array(
            'field' => 'egy_megall_ktttnk_prog',
            'select' => 'ugyfel_id',
            'table' => 'ugyfel_attr_projekt_informacio'
        )
    ),
    'egyMegallKepz' => array(
        'Uniweb\\Library\\DynamicFilter\\Filter\\TrueOrFalse', array(
            'field' => 'egy_megall_ktttnk_kepz',
            'select' => 'ugyfel_id',
            'table' => 'ugyfel_attr_projekt_informacio'
        )
    ),
);