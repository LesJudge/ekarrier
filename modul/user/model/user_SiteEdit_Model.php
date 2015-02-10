<?php
/**
 * @property MYSQL_DB $_DB Adatbázis.
 */
class User_SiteEdit_Model extends \AttachableUserModelAbstract
{
    /**
     * AddressFinder objektum.
     * @var \AddressFinder
     */
    protected $addressFinder;
    /**
     * UserHirlevelHelper objektum.
     * @var \UserHirlevelHelper
     */
    protected $userHirlevelHelper;
    /**
     * Konstruktor.
     */
    
    
    public function __construct()
    {
        parent::__construct();
        $helper = new \ModelEditHelper;
        $this->setAttacher(new \SiteUserEditInsert($this->_DB, $helper));
        $this->setAttached(new \SiteUserEditUpdate($this->_DB, $helper));
        $this->setFinder(new \SiteUserEditDataFinder($this->_DB, $helper));
        $this->userHirlevelHelper = new \UserHirlevelHelper($this->_DB);
        $this->addressFinder = new \AddressFinder($this->_DB);
    }
    /**
     * Form létrehozása.
     */
    public function __addForm()
    {
        parent::__addForm();
        // Születési idő
                        /*
                        $birthDate = $this->addItem('DateSzulIdo');
                        $birthDate->_verify['date'] = true;
                        if (!$this->modifyID) {
                            $accept = $this->addItem('ChkElfogad');
                            $accept->_verify['string'] = true;
                        }
                        */
                        
        $this->_params['ChkHirlevel']->_select_value = '';
        // Kérem, válasszon opció.
        $pleaseSelect = array('' => '--Kérem, válasszon!--');
        // Legmagasabb iskolai végzettség.
        $hea = $this->addItem('SelVegzettseg'); // highest educational attainment
        $hea->_verify['select'] = true;
        $hea->_select_value = $pleaseSelect + $this->getSelectValues(
            'vegzettseg',
            'vegzettseg_nev',
            ' AND vegzettseg_aktiv=1 AND vegzettseg_torolt=0',
            ' ORDER BY vegzettseg_nev ASC',
            true,
            $pleaseSelect
        );
        // Nem
                /*    $gender = $this->addItem('SelNem');
                    $gender->_verify['select'] = true;
                    $gender->_select_value = $pleaseSelect + array('male' => 'Férfi', 'female' => 'Nő');
                  */  
        // Anyja neve.
                //$this->addItem('TxtAnyjaNeve');
        // --- Telefonszám mezők.
        // Vezetékes telefonszám.
        
                 /*   $pHome = $this->addItem('TxtTelszamVezetekes');
                    $pHome->_verify['pattern'] = array(
                        'allowEmpty' => true,
                        'message' => 'A telefonszám nem megfelelő! pl. (3600123456)',
                        'pattern' => '/^36[0-9]{8}$/',
                        'value' => true
                    );
                   */ 
        // Elsődleges mobilszám.
        $pMob1 = $this->addItem('TxtTelszamMobil1');
        $pMob1->_verify['string'] = true;
        $pMob1->_verify['pattern'] = array(
            'allowEmpty' => false,
            'message' => 'A telefonszám nem megfelelő! pl. (36001234567)',
            'pattern' => '/^36[0-9]{9}$/',
            'value' => true
        );
        // Másodlagos mobilszám.
        
        
              /*  $pMob2 = $this->addItem('TxtTelszamMobil2');
                $pMob2->_verify['pattern'] = array(
                    'allowEmpty' => true,
                    'message' => 'A telefonszám nem megfelelő! pl. (36001234567)',
                    'pattern' => '/^36[0-9]{9}$/',
                    'value' => true
                );
             */
        
        /*
        // Születési keresztnév.
        $this->addItem('TxtSzulKeresztnev');
        // Születési vezetéknév.
        $this->addItem('TxtSzulVezeteknev');
        // Születési idő.
        $this->_params['DateSzulIdo']->_verify['string'] = true;
        // Születési hely - Ország
        $birthplaceCountry = $this->addItem('SelSzulhelyOrszag');
        $birthplaceCountry->_verify['select'] = true;
        // Születési hely - Város
        $birthplaceCity = $this->addItem('SelSzulhelyVaros');
        $birthplaceCity->_verify['select'] = true;
        // --- Lakhely
        // Ország
        $residenceCountry = $this->addItem('SelLakhelyOrszag');
        $residenceCountry->_verify['select'] = true;
        // Megye
        $residenceCounty = $this->addItem('SelLakhelyMegye');
        $residenceCounty->_verify['select'] = true;
        // Város
        $residenceCity = $this->addItem('SelLakhelyVaros');
        $residenceCity->_verify['select'] = true;
        // Irányítószám
        $this->addItem('SelLakhelyIranyitoszam');
        // Utca
        $this->addItem('TxtLakhelyUtca');
        // Házszám
        $this->addItem('TxtLakhelyHazszam');
        // --- Tartkózkodási hely
        $this->addItem('SelTarthelyOrszag');
        $this->addItem('SelTarthelyMegye');
        $this->addItem('SelTarthelyVaros');
        $this->addItem('SelTarthelyIranyitoszam');
        $this->addItem('TxtTarthelyUtca');
        $this->addItem('TxtTarthelyHazszam');
        // -- Ideiglenes lakcím
        $this->addItem('SelIdeiglenesOrszag');
        $this->addItem('SelIdeiglenesMegye');
        $this->addItem('SelIdeiglenesVaros');
        $this->addItem('SelIdeiglenesIranyitoszam');
        $this->addItem('TxtIdeiglenesUtca');
        $this->addItem('TxtIdeiglenesHazszam');
    */
        
    }
    /**
     * Alapértelmezett értékek beállítása.
     */
    public function setDefaultVal()
    {
        $this->_params['SelGroup']->_value = array(2 => 2);
        $this->_params['SelNyelv']->_value = Rimo::$_config->SITE_NYELV_ID;
        $this->_params['ChkAktiv']->_value = 1;
        /*
        $ps = array('' => '--Kérem, válasszon!--');
        $this->_params['SelLakhelyOrszag']->_select_value =  $this->addressFinder->findCountries();
        $this->_params['SelLakhelyVaros']->_select_value = $ps + $this->addressFinder->findCitiesByCountryId();
        // Ország mezők.
        $this->_params['SelLakhelyOrszag']->_select_value = 
        $this->_params['SelTarthelyOrszag']->_select_value = 
        $this->_params['SelIdeiglenesOrszag']->_select_value = 
        $this->_params['SelSzulhelyOrszag']->_select_value = $ps + $this->addressFinder->findCountries();
        // Megye mezők.
        $this->_params['SelLakhelyMegye']->_select_value = 
        $this->_params['SelTarthelyMegye']->_select_value = 
        $this->_params['SelIdeiglenesMegye']->_select_value = $ps + $this->addressFinder->findCountiesByCountryId();
        // Város mezők.
        $this->_params['SelLakhelyVaros']->_select_value = 
        $this->_params['SelTarthelyVaros']->_select_value = 
        $this->_params['SelIdeiglenesVaros']->_select_value = 
        $this->_params['SelSzulhelyVaros']->_select_value = $ps + $this->addressFinder->findCitiesByCountryId();
        // Irányítószám mezők.
        $this->_params['SelLakhelyIranyitoszam']->_select_value = 
        $this->_params['SelTarthelyIranyitoszam']->_select_value = 
        $this->_params['SelIdeiglenesIranyitoszam']->_select_value = $ps + $this->addressFinder->findZipCodesByCountryId();
        
        */
    }
    /**
     * Felhasználó adatok frissítése.
     */
    public function __update($sets = "")
    {
        $this->modifyID = $this->attached->save($this->_params, $this->getUserId(), $this->getAttachedId());
        $this->userHirlevelHelper->hirlevelUser($this->modifyID, $this->_params);
        $this->_params['Password']->_value = $this->_params['Password2']->_value = null;
    }
    /**
     * Felhasználó létrehozása.
     */
    public function __insert($sets = "")
    {
        $this->insertID = $this->attacher->save($this->_params, null, null);
        $this->userHirlevelHelper->hirlevelUser($this->insertID, $this->_params);
        $this->_params['Password']->_value = $this->_params['Password2']->_value = null;
    }
}