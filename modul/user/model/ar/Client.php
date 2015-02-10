<?php
/**
 * @property int $ugyfel_id Ügyfél azonosító.
 * @property int $user_allapot_id Ügyfél állapot azonosító.
 * @property int $munkakor_kategoria Munkakör kategória.
 * @property int $munkaba_allas_allapot Munkába állás állapot.
 * @property int $vegzettseg_id Végzettség azonosító.
 * @property string $email E-mail cím.
 * @property string $vezeteknev Vezetéknév.
 * @property string $keresztnev Keresztnév.
 * @property string $egyeb_munkakorok_erdeklik Egyéb munkakörök érdeklik.
 * @property string $nem Ügyfél neme.
 * @property string $anyja_neve Anyja neve.
 * @property string $telefonszam_vezetekes Vezetékes telefonszám.
 * @property string $telefonszam_mobil1 Elsődleges mobilszám.
 * @property string $telefonszam_mobil2 Másodlagos mobilszám.
 * @property int $user_hirlevel Hírlevélre feliratkozott-e.
 * @property mixed $kapcsolatfelvetel_ideje Kapcsolatfelvétel ideje.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property mixed $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Módosítás száma.
 * @property int $ugyfel_aktiv Aktív-e az ügyfél.
 * @property int $ugyfel_torolt Törölt-e az ügyfél.
 * 
 * @property \User $creator Létrehozó user objektum.
 * @property \User $modificatory Módosító user objektum.
 * @property \LaborMarket $labormarket Ügyfél munkaerő piaci helyzete.
 * @property \ProjectInformation $projectinformation Ügyfél projekt információ.
 * @property \UserEducation[] $educations Ügyfél végzettségei.
 * @property \UserKnowledge[] $knowledges Ügyfél nyelvtudása.
 * @property \UcKnowledge[] $computerknowledges Ügyfél számítógépes ismeretei.
 * @property \ServiceInterested $services[] Ügyfél által érdekelt szolgáltatások.
 * @property \ClientContact[] $contacts Ügyfélhez tartozó kapcsolatfelvételek.
 * @property \ClientProgramInformation[] $programinformations Ügyfélhez tartozó program információk.
 * @property \ClientWorkSchedules[] $workschedules Ügyfélhez tartozó munkarendek.
 * @property \ClientProjects[] $projects Ügyfélhez tartozó projektek.
 * @property \ClientJob[] $jobs Ügyfélhez tartozó munkakörök.
 * @property \Residence $residence Lakhely.
 * @property \DwellingPlace $dwellingplace Tartózkodási hely.
 * @property \TemporaryResidence $temporaryresidence Ideiglenes lakhely.
 * @property \CommentActivity $commentactivity Álláskeresési aktivitás megjegyzés.
 * @property \CommentClientInformation $commentclientinformation Ügyfél információ megjegyzés.
 * @property \CommentContact $commentcontact Esetnapló megjegyzés.
 * @property \CommentDocument $commentdocument Dokumentumok megjegyzés.
 * @property \CommentEducation $commenteducation Végzettségek/Nyelvtudás/Tanulmányok/Számítógépes ismeretek megjegyzés.
 * @property \CommentJob $commentjob Munkakör/munkarend megjegyzés.
 * @property \CommentLaborMarket $commentlabormarket Munkaerőpiaci helyzete megjegyzés.
 * @property \CommentLogin $commentlogin Belépés adatok megjegyzés.
 * @property \CommentPersonalData $commentpersonaldata Személyes adatok megjegyzés.
 * @property \CommentProject $commentproject Projekt megjegyzés.
 * @property \CommentProjectInformation $commentprojectinformation Projekt információ megjegyzés.
 * @property \ClientDataStatus $clientdatastatus Ügyfél státusz adatok.
 * @property \ClientBirthData $clientbirthdata Ügyfél születési adatok.
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class Client extends \ArBase
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'ugyfel_id';
    /**
     * Modelhez tartozó 1:1 kapcsolatok.
     * @var array
     */
    public static $belongs_to = array(
        array(
            'labormarket',
            'class_name' => 'LaborMarket',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'projectinformation',
            'class_name' => 'ProjectInformation',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'clientdatastatus',
            'class_name' => 'ClientDataStatus',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'clientbirthdata',
            'class_name' => 'ClientBirthData',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'residence',
            'class_name' => 'Residence',
            'conditions' => 'beallitas_cim_tipus_id = 1 AND ugyfel_attr_cim_aktiv = 1 AND ugyfel_attr_cim_torolt = 0',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'dwellingplace',
            'class_name' => 'DwellingPlace',
            'conditions' => 'beallitas_cim_tipus_id = 2 AND ugyfel_attr_cim_aktiv = 1 AND ugyfel_attr_cim_torolt = 0',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'temporaryresidence',
            'class_name' => 'TemporaryResidence',
            'conditions' => 'beallitas_cim_tipus_id = 3 AND ugyfel_attr_cim_aktiv = 1 AND ugyfel_attr_cim_torolt = 0',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'commentactivity',
            'class_name' => 'CommentActivity',
            'conditions' => 'beallitas_ugyfelkezelo_tab_id = 7 AND 
                             ugyfel_attr_tab_megjegyzes_aktiv = 1 AND 
                             ugyfel_attr_tab_megjegyzes_torolt = 0',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'commentclientinformation',
            'class_name' => 'CommentClientInformation',
            'conditions' => 'beallitas_ugyfelkezelo_tab_id = 1 AND 
                             ugyfel_attr_tab_megjegyzes_aktiv = 1 AND 
                             ugyfel_attr_tab_megjegyzes_torolt = 0',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'commentcontact',
            'class_name' => 'CommentContact',
            'conditions' => 'beallitas_ugyfelkezelo_tab_id = 9 AND 
                             ugyfel_attr_tab_megjegyzes_aktiv = 1 AND 
                             ugyfel_attr_tab_megjegyzes_torolt = 0',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'commentdocument',
            'class_name' => 'CommentDocument',
            'conditions' => 'beallitas_ugyfelkezelo_tab_id = 10 AND 
                             ugyfel_attr_tab_megjegyzes_aktiv = 1 AND 
                             ugyfel_attr_tab_megjegyzes_torolt = 0',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'commenteducation',
            'class_name' => 'CommentEducation',
            'conditions' => 'beallitas_ugyfelkezelo_tab_id = 6 AND 
                             ugyfel_attr_tab_megjegyzes_aktiv = 1 AND 
                             ugyfel_attr_tab_megjegyzes_torolt = 0',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'commentjob',
            'class_name' => 'CommentJob',
            'conditions' => 'beallitas_ugyfelkezelo_tab_id = 5 AND 
                             ugyfel_attr_tab_megjegyzes_aktiv = 1 AND 
                             ugyfel_attr_tab_megjegyzes_torolt = 0',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'commentlabormarket',
            'class_name' => 'CommentLaborMarket',
            'conditions' => 'beallitas_ugyfelkezelo_tab_id = 3 AND 
                             ugyfel_attr_tab_megjegyzes_aktiv = 1 AND 
                             ugyfel_attr_tab_megjegyzes_torolt = 0',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'commentlogin',
            'class_name' => 'CommentLogin',
            'conditions' => 'beallitas_ugyfelkezelo_tab_id = 11 AND 
                             ugyfel_attr_tab_megjegyzes_aktiv = 1 AND 
                             ugyfel_attr_tab_megjegyzes_torolt = 0',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'commentpersonaldata',
            'class_name' => 'CommentPersonalData',
            'conditions' => 'beallitas_ugyfelkezelo_tab_id = 2 AND 
                             ugyfel_attr_tab_megjegyzes_aktiv = 1 AND 
                             ugyfel_attr_tab_megjegyzes_torolt = 0',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'commentproject',
            'class_name' => 'CommentProject',
            'conditions' => 'beallitas_ugyfelkezelo_tab_id = 8 AND 
                             ugyfel_attr_tab_megjegyzes_aktiv = 1 AND 
                             ugyfel_attr_tab_megjegyzes_torolt = 0',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'commentprojectinformation',
            'class_name' => 'CommentProjectInformation',
            'conditions' => 'beallitas_ugyfelkezelo_tab_id = 4 AND 
                             ugyfel_attr_tab_megjegyzes_aktiv = 1 AND 
                             ugyfel_attr_tab_megjegyzes_torolt = 0',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        )
    );
    /**
     * Modelhez tartozó 1:n kapcsolatok.
     * @var array
     */
    public static $has_many = array(
        array(
            'educations',
            'class_name' => 'UserEducation',
            'conditions' => 'ugyfel_attr_vegzettseg_aktiv = 1 AND ugyfel_attr_vegzettseg_torolt = 0',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'knowledges',
            'class_name' => 'UserKnowledge',
            'conditions' => 'ugyfel_attr_nyelvtudas_aktiv = 1 AND ugyfel_attr_nyelvtudas_torolt = 0',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'computerknowledges',
            'class_name' => 'UcKnowledge',
            'conditions' => 'ugyfel_attr_szgep_ismeret_aktiv = 1 AND ugyfel_attr_szgep_ismeret_torolt = 0',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'services',
            'class_name' => 'ServiceInterested',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'contacts',
            'class_name' => 'ClientContact',
            'conditions' => 'ugyfel_attr_esetnaplo_aktiv = 1 AND ugyfel_attr_esetnaplo_torolt = 0',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'programinformations',
            'class_name' => 'ClientProgramInformation',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'workschedules',
            'class_name' => 'ClientWorkSchedules',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'mediations',
            'class_name' => 'ClientMediation',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'projects',
            'class_name' => 'ClientProject',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'jobs',
            'class_name' => 'ClientJob',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        )
    );
    /**
     * Kötelező mezők validációs szabályai.
     * @var array
     */
    public static $validates_presence_of = array();
    /**
     * Mezőkre vonatkozó string hossz validációs szabályok.
     * @var array
     */
    public static $validates_length_of = array();
    /**
     * Mezők által felvehető értékek validációs szabályok.
     * @var array
     */
    public static $validates_inclusion_of = array();
    /**
     * Mezők értékeinek "formájára" vonatkozó validációs szabályok.
     * @var array
     */
    public static $validates_format_of = array();
    /**
     * Mezők, amelyek nem "mass-assignolhatóak". (Konstruktorban hiába van átadva, NULL értéket vesz fel az attribútum.)
     * @var array
     */
    public static $attr_protected = array(
        'ugyfel_id',
        'letrehozo_id',
        'modosito_id',
        'modositas_szama',
        'ugyfel_aktiv',
        'ugyfel_torolt'
    );
    /**
     * Konstruktor felüldeklarálása.
     * @param array $attributes
     * @param boolean $guard_attributes
     * @param boolean $instantiating_via_find
     * @param boolean $new_record
     */
    public function __construct(
        array $attributes = array(),
        $guard_attributes = true,
        $instantiating_via_find = false,
        $new_record = true
    ) {
        $this->modifyAttributes($attributes);
        parent::__construct($attributes, $guard_attributes, $instantiating_via_find, $new_record);
        $emailLength = $this->getEmailLength();
        $nameLength = $this->getNameLength();
        $telLength = static::getTelephoneLength();
        $phonePattern = static::regexPhoneNumber();
        static::$validates_presence_of = array(
            array(
                'vezeteknev',
                'message' => 'Kötelező mező!'
            ),
            array(
                'keresztnev',
                'message' => 'Kötelező mező!'
            )
        );
        static::$validates_length_of = array(
            array(
                'email',
                'within' => $emailLength,
                'too_short' => 'Az e-mail cím legalább ' . $emailLength[0] . ' karakter hosszú legyen!',
                'too_long' => 'Az e-mail cím legfeljebb ' . $emailLength[1] . ' karakter hosszú lehet!'
            ),
            array(
                'vezeteknev',
                'within' => $nameLength,
                'too_short' => 'A vezetéknévnek legalább ' . $nameLength[0] . ' karakter hosszúnak kell lennie!',
                'too_long' => 'A vezetéknév legfeljebb ' . $nameLength[1] . ' karakter hosszú lehet!'
            ),
            array(
                'keresztnev',
                'within' => $nameLength,
                'too_short' => 'A keresztnévnek legalább ' . $nameLength[0] . ' karakter hosszúnak kell lennie!',
                'too_long' => 'A keresztnév legfeljebb ' . $nameLength[1] . ' karakter hosszú lehet!'
            ),
            array(
                'telefonszam_vezetekes',
                'allow_blank' => true,
                'within' => $telLength,
                'too_short' => 'A telefonszámnak legalább ' . $telLength[0] . ' karakter hosszúnak kell lennie!',
                'too_long' => 'A telefonszám legfeljebb ' . $telLength[1] - 1 . ' karakter hosszú lehet!'
            ),
            array(
                'telefonszam_mobil1',
                'allow_blank' => true,
                'within' => $telLength,
                'too_short' => 'A mobiltelefonszámnak legalább ' . $telLength[0] . ' karakter hosszúnak kell lennie!',
                'too_long' => 'A mobiltelefonszámnak legfeljebb ' . $telLength[1] . ' karakter hosszú lehet!'
            ),
            array(
                'telefonszam_mobil2',
                'allow_blank' => true,
                'within' => $telLength,
                'too_short' => 'A mobiltelefonszámnak legalább ' . $telLength[0] . ' karakter hosszúnak kell lennie!',
                'too_long' => 'A mobiltelefonszámnak legfeljebb ' . $telLength[1] . ' karakter hosszú lehet!'
            )
        );
        static::$validates_inclusion_of = array(
            array(
                'user_hirlevel',
                'in' => array(0, 1),
                'message' => 'A hírlevél értéke csak igen-nem lehet!'
            ),
            array(
                'ugyfel_aktiv',
                'in' => array(0, 1),
                'message' => 'Az aktív értéke csak igen-nem lehet!'
            )
        );
        static::$validates_format_of = array(
            array(
                'telefonszam_vezetekes',
                'allow_blank' => true,
                'with' => $phonePattern,
                'message' => 'A telefonszám nem megfelelő! (pl. 3650123456)'
            ),
            array(
                'telefonszam_mobil1',
                'allow_blank' => true,
                'with' => $phonePattern,
                'message' => 'A telefonszám nem megfelelő! (pl. 36501234567)'
            ),
            array(
                'telefonszam_mobil2',
                'allow_blank' => true,
                'with' => $phonePattern,
                'message' => 'A telefonszám nem megfelelő! (pl. 36501234567)'
            )
        );
    }
    /**
     * Serializálja az ügyfélhez tartozó végzettségeket.
     * @return mixed
     */
    public function sheepItEducations()
    {
        return $this->sheepItSerialize('educations');
    }
    /**
     * Ha az ügyfélhez tartozik nyelvtudás, akkor serializálja azokat, ha nem, akkor false-szal tér vissza.
     * @return mixed
     */
    public function sheepItKnowledges()
    {
        return $this->sheepItSerialize('knowledges');
    }
    /**
     * Ha az ügyfélhez tartozik számítógépes ismeret, akkor serializálja azokat, ha nem, akkor false-szal tér vissza.
     * @return mixed
     */
    public function sheepItComputerKnowledges()
    {
        return $this->sheepItSerialize('computerknowledges');
    }
    /**
     * Ha az ügyfélhez tartozik érdekelt szolgáltatás, akkor serializálja azokat, ha nem, akkor false-szal tér vissza.
     * @return mixed
     */
    public function sheepItServices()
    {
        return $this->sheepItSerialize('services');
    }
    
    public function sheepItMediations()
    {
        return $this->sheepItSerialize('mediations');
    }
    /**
     * sheepItForm-mal felvett adathalmazt serializálja.
     * @param string $attribute 1:n kapcsolat attribútum neve.
     * @return mixed
     */
    protected function sheepItSerialize($attribute)
    {
        $data = $this->{$attribute};
        if (count($data) > 0) {
            return ArHelper::serializeSheepItModels($data);
        }
        return false;
    }
    /**
     * Attribútum értékek módosítása.
     * @param array $attributes
     */
    protected function modifyAttributes(array &$attributes)
    {
        $unset = array(
            'user_allapot_id',
            'munkakor_kategoria',
            'munkaba_allas_allapot',
            'vegzettseg_id',
            'kapcsolatfelvetel_ideje'
        );
        foreach ($unset as $attr) {
            if (isset($attributes[$attr]) && (int)$attributes[$attr] == 0) {
                unset($attributes[$attr]);
            }
        }
    }
    /**
     * Attribútumok értékeinek beállítása.
     * @param array $attributes
     */
    public function set_attributes(array $attributes)
    {
        $this->modifyAttributes($attributes);
        parent::set_attributes($attributes);
    }
    /**
     * Visszatér az attribútumok label-jeit tartalmazó tömbbel.
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'ugyfel_id' => 'Felhasználó azonosító',
            'user_allapot_id' => 'Állapot',
            'munkakor_kategoria' => 'Munkakör kategória',
            'munkaba_allas_allapot' => 'Munkába állás állapot',
            'vegzettseg_id' => 'Legmagasabb iskolai végzettség',
            'email' => 'E-Mail cím',
            'vezeteknev' => 'Vezetéknév',
            'keresztnev' => 'Keresztnév',
            'nem' => 'Neme',
            'anyja_neve' => 'Anyja neve',
            'telefonszam_vezetekes' => 'Vezetékes telefonszám',
            'telefonszam_mobil1' => 'Mobiltelefonszám - elsődleges',
            'telefonszam_mobil2' => 'Mobiltelefonszám - másodlagos',
            'user_hirlevel' => 'Hírlevél',
            'egyeb_munkakorok_erdeklik' => 'Egyéb munkakörök érdeklik',
            'kapcsolatfelvetel_ideje' => 'Kapcsolatfelvétel ideje'
        );
    }
    /**
     * Visszatér az e-mail cím minimális és maximális hosszát tartalmazó tömbbel.
     * @return array
     */
    public function getEmailLength()
    {
        return array(8, 255);
    }
    /**
     * Visszatér a név minimális és maximális hosszát tartalmazó tömbbel.
     * @return array
     */
    public function getNameLength()
    {
        return array(3, 128);
    }
    /**
     * Visszatér a telefonszám minimális és maximális hosszát tartalmazó tömbbel.
     * @return array
     */
    public static function getTelephoneLength()
    {
        return array(10, 11);
    }
    /**
     * Visszatér a házszám minimális és maximális hosszát tartalmazó tömbbel.
     * @return array
     */
    public static function getAddressHouseNumberLength()
    {
        return array(1, 32);
    }
    /**
     * Visszatér a telefonszám validáláshoz tartozó reguláris kifejezéssel.
     * @return string
     */
    public static function regexPhoneNumber()
    {
        //return '/^\36\d{8,9}$/';
        return '/^36[0-9]{8,9}$/';
    }
}