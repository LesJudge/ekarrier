<?php
return array(
    'defaultGetter' => 'getIOAttribute',
    'defaultSetter' => 'setIOAttribute',
    'attributes' => array(
        'status' => array(
            'label' => 'Státusz',
            'getter' => 'getIOAttributeStatus',
            'setter' => 'setIOAttributeStatus'
        ),
        'neme' => array(
            'label' => 'Neme',
            'getter' => 'getIOAttributeGender',
            'setter' => 'setIOAttributeGender'
        ),
        'name' => array(
            'label' => 'Név',
            'getter' => 'getIOAttributeName',
            'setter' => 'setIOAttributeName'
        ),
        'leanykorinev' => array(
            'label' => 'Leánykori név',
            'getter' => 'getIOAttributeBirthname',
            'setter' => 'setIOAttributeBirthname'
        ),
        'szulhely' => array(
            'label' => 'Születési hely',
            'getter' => 'getIOAttributeBirthplace',
            'setter' => 'setIOAttributeBirthplace'
        ),
        'szulido' => array(
            'label' => 'Születési idő',
            'getter' => 'getIOAttributeBirthdate',
            'setter' => 'setIOAttributeBirthdate'
        ),
        'anyjaneve' => array(
            'label' => 'Anyja neve',
            'getter' => 'getIOAttributeMothersName',
            'setter' => 'setIOAttributeMothersName'
        ),
        'irszam' => array(
            'label' => 'Irányítószám',
            'getter' => 'getIOAttributeZipCode',
            'setter' => 'setIOAttributeZipCode'
        ),
        'telepules' => array(
            'label' => 'Település',
            'getter' => 'getIOAttributeCity',
            'setter' => 'setIOAttributeCity'
        ),
        'utca' => array(
            'label' => 'Utca',
            'getter' => 'getIOAttributeStreet',
            'setter' => 'setIOAttributeStreet'
        ),
        'hazszam' => array(
            'label' => 'Házszám',
            'getter' => 'getIOAttributeHouseNumber',
            'setter' => 'setIOAttributeHouseNumber'
        ),
        'megye' => array(
            'label' => 'Megye',
            'getter' => 'getIOAttributeCounty',
            'setter' => 'setIOAttributeCounty'
        ),
        'phone1' => array(
            'label' => 'Vezetékes',
            'getter' => 'getIOAttributePhone1',
            'setter' => 'setIOAttributePhone1'
        ),
        'phone2' => array(
            'label' => 'Mobil - Elsődleges',
            'getter' => 'getIOAttributePhone2',
            'setter' => 'setIOAttributePhone2'
        ),
        'phone3' => array(
            'label' => 'Mobil - Másodlagos',
            'getter' => 'getIOAttributePhone3',
            'setter' => 'setIOAttributePhone3'
        ),
        'email' => array(
            'label' => 'E-mail cím',
            'getter' => 'getIOAttributeEmail',
            'setter' => 'setIOAttributeEmail'
        ),
        'legmagvegzettseg' => array(
            'label' => 'Legmagasabb iskolai végzettség',
            'getter' => 'getIOAttributeHighestEducation',
            'setter' => 'setIOAttributeHighestEducation'
        ),
        'regmunka' => array(
            'label' => 'Regisztrált munkanélküli?',
            'getter' => 'getIOAttributeRegmunka',
            'setter' => 'setIOAttributeRegmunka'
        ),
        'palyakezdo' => array(
            'label' => '25 év alatti pályakezdő?',
            'getter' => 'getIOAttributePalyakezdo',
            'setter' => 'setIOAttributePalyakezdo'
        ),
        'megvmunka' => array(
            'label' => 'Megváltozott munkaképességű?',
            'getter' => 'getIOAttributeMegvmunka',
            'setter' => 'setIOAttributeMegvmunka'
        ),
        'gyesgyed' => array(
            'label' => 'GYES-ről, GYED-ről visszatérő?',
            'getter' => 'getIOAttributeGyesgyed',
            'setter' => 'setIOAttributeGyesgyed'
        ),
        'unios2ev' => array(
            'label' => 'Uniós finanszírozású programban részt vett-e az utóbbi 2 évben?',
            'getter' => 'getIOAttributeUnios2ev',
            'setter' => 'setIOAttributeUnios2ev'
        ),
        'hazai2ev' => array(
            'label' => 'Hazai finanszírozású programban részt vett-e az utóbbi 2 évben?',
            'getter' => 'getIOAttributeHazai2ev',
            'setter' => 'setIOAttributeHazai2ev'
        ),
        'honnan' => array(
            'label' => 'Honnan hallott rólunk?',
            'getter' => 'getIOAttributeProgramInformation',
            'setter' => 'setIOAttributeProgramInformation',
            'source' => 'getIOSourceProgramInformation'
        ),
        'allkerkarrpont' => array(
            'label' => 'Álláskeresési Tanácsadó és Karrier Pont Iroda vezető képzésen részt vett-e?',
            'getter' => 'getIOAttributeAllkerkarrpont',
            'setter' => 'setIOAttributeAllkerkarrpont'
        ),
        'allasvadasz' => array(
            'label' => 'Állásvadász táborban részt vett-e?',
            'getter' => 'getIOAttributeAllasvadasz',
            'setter' => 'setIOAttributeAllasvadasz'
        ),
        'munkapcs' => array(
            'label' => 'Munkáltatói kapcsolattartó képzésen részt vett-e?',
            'getter' => 'getIOAttributeMunkapcs',
            'setter' => 'setIOAttributeMunkapcs'
        ),
        'telassz' => array(
            'label' => 'Telefonos és elektonikus ügyfélkapcsolati asszisztens képzésen részt vett-e?',
            'getter' => 'getIOAttributeTelassz',
            'setter' => 'setIOAttributeTelassz'
        ),
        'vallval' => array(
            'label' => 'Vállalkozóvá válás elősegítése képzésen részt vett-e?',
            'getter' => 'getIOAttributeVallval',
            'setter' => 'setIOAttributeVallval'
        ),
        'allaskulcs' => array(
            'label' => 'Álláskeresési technika és kulcsképesség-fejlesztésen részt vett-e?',
            'getter' => 'getIOAttributeAllaskulcs',
            'setter' => 'setIOAttributeAllaskulcs'
        ),
        'psziszoc' => array(
            'label' => 'Pszicho-szociális tanácsadáson részt vett-e?',
            'getter' => 'getIOAttributePsziszoc',
            'setter' => 'setIOAttributePsziszoc'
        ),
        'grafologia' => array(
            'label' => 'Grafológiai munkakörelemzésen részt vett-e?',
            'getter' => 'getIOAttributeGrafologia',
            'setter' => 'setIOAttributeGrafologia'
        ),
        'allaskertan' => array(
            'label' => 'Álláskeresési tanácsadáson részt vett-e?',
            'getter' => 'getIOAttributeAllaskertan',
            'setter' => 'setIOAttributeAllaskertan'
        ),
        'pszichtan' => array(
            'label' => 'Pszichológiai tanácsadáson részt vett-e?',
            'getter' => 'getIOAttributePszichtan',
            'setter' => 'setIOAttributePszichtan'
        ),
        'jogitan' => array(
            'label' => 'Jogi tanácsadáson részt vett-e?',
            'getter' => 'getIOAttributeJogitan',
            'setter' => 'setIOAttributeJogitan'
        ),
        'kepzesitan' => array(
            'label' => 'Képzési tanácsadáson részt vett-e?',
            'getter' => 'getIOAttributeKepzesitan',
            'setter' => 'setIOAttributeKepzesitan'
        ),
        'munkatan' => array(
            'label' => 'Munkatanácsadáson részt vett-e?',
            'getter' => 'getIOAttributeMunkatan',
            'setter' => 'setIOAttributeMunkatan'
        ),
        'egyuttmukprog' => array(
            'label' => 'Kötött-e együttműködési megállapodást a programban?',
            'getter' => 'getIOAttributeEgyuttmukprog',
            'setter' => 'setIOAttributeEgyuttmukprog'
        ),
        'egyuttmukkepzes' => array(
            'label' => 'Kötött-e együttműködési megállapodást képzésben?',
            'getter' => 'getIOAttributeEgyuttmukkepzes',
            'setter' => 'setIOAttributeEgyuttmukkepzes'
        ),
        'szolgaltatas' => array(
            'label' => 'Szolgáltatások, amik érdeklik',
            'getter' => 'getIOAttributeSzolgaltatas',
            'setter' => 'setIOAttributeSzolgaltatas',
            'source' => 'getIOSourceSzolgaltatas'
        ),
        'kapcsfel' => array(
            'label' => 'Kapcsolatfelvétel ideje',
            'getter' => 'getIOAttributeKapcsfel',
            'setter' => 'setIOAttributeKapcsfel'
        ),
        'vegzettseg' => array(
            'label' => 'Végzettségei',
            'getter' => 'getIOAttributeEducation',
            'setter' => 'setIOAttributeEducation',
            'source' => 'getIOSourceEducation'
        ),
        'nyelvvizsganyelv' => array(
            'label' => 'Nyelvvizsga nyelv',
            'getter' => 'getIOAttributeLanguage',
            'setter' => 'setIOAttributeLanguage',
            'source' => 'getIOSourceLanguage'
        ),
        'nyelvvizsgatipus' => array(
            'label' => 'Nyelvvizsga típus',
            'getter' => 'getIOAttributeNyelvvizsgatipus',
            'setter' => 'setIOAttributeNyelvvizsgatipus',
            'source' => 'getIOSourceLanguage'
        ),
        'kategoria' => array(
            'label' => 'Kategória',
            'getter' => 'getIOAttributeKategoria',
            'setter' => 'setIOAttributeKategoria',
            'source' => 'getIOSourceKategoria'
        ),
        'betolt' => array(
            'label' => 'Betölteni kívánt munkakörök',
            'getter' => 'getIOAttributeBetolt',
            'setter' => 'setIOAttributeBetolt',
            'source' => 'getIOSourceBetolt'
        ),
        'hozzajarul' => array(
            'label' => 'Hozzájárul-e a munkaközvetítéshez?',
            'getter' => 'getIOAttributeHozzajarul',
            'setter' => 'setIOAttributeHozzajarul'
        ),
        'mobilitas' => array(
            'label' => 'Mobilis-e',
            'getter' => 'getIOAttributeMobilitas',
            'setter' => 'setIOAttributeMobilitas'
        ),
        'munkarend' => array(
            'label' => 'Munkarend',
            'getter' => 'getIOAttributeMunkarend',
            'setter' => 'setIOAttributeMunkarend',
            'source' => 'getIOSourceMunkarend'
        ),
        'munkakorkategoria' => array(
            'label' => 'Munkakör kategória',
            'getter' => 'getIOAttributeMunkakorkategoria',
            'setter' => 'setIOAttributeMunkakorkategoria'
        ),
        'munkaallapot' => array(
            'label' => 'Munkába állás állapota',
            'getter' => 'getIOAttributeMunkaallapot',
            'setter' => 'setIOAttributeMunkaallapot'
        ),
        'online' => array(
            'label' => 'Online rendszerben rögzítve',
            'getter' => 'getIOAttributeOnline',
            'setter' => 'setIOAttributeOnline'
        ),
        'megjegyzes' => array(
            'label' => 'Megjegyzés',
            'getter' => 'getIOAttributeMegjegyzes',
            'setter' => 'setIOAttributeMegjegyzes'
        )
    )
);