<?php
class Ceg_Telephely_Edit_Model extends Admin_Edit_Model
{
    /**
     *
     * @var \AddressFinder
     */
    protected $addressFinder;    
    
        public $_tableName='ceg_telephely';
        public $_bindArray=array(
            'ceg_id'=>'SelCeg',
            'cim_iranyitoszam_id'=>'SelIrsz',
            'cim_varos_id' => 'SelVaros',
            'cim_megye_id' => 'SelMegye',
            'cim_orszag_id' => 'SelOrszag',
            'utca'=>'TxtUtca',
            'hazszam'=>'TxtHsz',
            'ceg_telephely_aktiv'=>'ChkAktiv'
        );
        
        public function __construct()
        {
            parent::__construct();
            $this->addressFinder = new AddressFinder($this->_DB);
        }
        
        public function __addForm()
        {
                parent::__addForm();
                // Cég
                $comp=$this->addItem('SelCeg');
                $comp->_verify['select']=true;
                $comp->_select_value=$this->getSelectValues(
                        'ceg',
                        'nev',
                        ' AND ceg_aktiv=1 AND ceg_torolt=0',
                        ' ORDER BY nev ASC',
                        false,
                        array(''=>'--Kérem, válasszon!--')
                );
                
                $ps = array('' => '--Kérem, válasszon!--');
                
                $country=$this->addItem('SelOrszag');
                $country->_verify['select'] = true;
                $country->_select_value = $ps + $this->addressFinder->findCountries();
                // Irányítószám
                $zipCode=$this->addItem('SelIrsz');
                $zipCode->_verify['select'] = true;
                $zipCode->_select_value = $ps + $this->addressFinder->findZipCodesByCountryId();
                
                // Megye
                $shire=$this->addItem('SelMegye');
                $shire->_verify['select'] = true;
                $shire->_select_value = $ps + $this->addressFinder->findCountiesByCountryId();
                
                // Város
                $city=$this->addItem('SelVaros');
                $city->_verify['select'] = true;
                $city->_select_value = $ps + $this->addressFinder->findCitiesByCountryId();
                // Utca, házszám
                $street=$this->addItem('TxtUtca');
                $street->_verify['string']=true;
                
                $streetNumber=$this->addItem('TxtHsz');
                $streetNumber->_verify['string']=true;
        }
        
        public function __editData()
        {
                $query="SELECT modositas_szama, 
                                            DATE_FORMAT(letrehozas_timestamp,'%Y-%m-%d %H:%i') AS ceg_telephely_letrehozas_datum, 
                                            DATE_FORMAT(modositas_timestamp,'%Y-%m-%d %H:%i') AS ceg_telephely_modositas_datum, 
                                            u1.user_fnev AS letrehozo_id, 
                                            u2.user_fnev AS modosito_id
                               FROM {$this->_tableName}
                               LEFT JOIN user AS u1 ON letrehozo_id=u1.user_id
                               LEFT JOIN user AS u2 ON modosito_id=u2.user_id
                               WHERE ceg_telephely_id='{$this->modifyID}'
                               LIMIT 1";
                $data=$this->_DB->prepare($query)->query_select()->query_fetch_array();
                return $data;
        }
        
        public function __formValues()
        {
                parent::__formValues();
        }
        
        public function __insert()
        {
                parent::__insert(",letrehozo_id=".(int)UserLoginOut_Admin_Controller::$_id);
        }
        
        public function __update()
        {
                parent::__update(",modositas_timestamp=NOW()
                                              ,modositas_szama=modositas_szama+1
                                              ,modosito_id=".(int)UserLoginOut_Admin_Controller::$_id);
        }
        
        public function verifyRow()
        {
                return true; // Prevent language check.
        }
        
        public function telephelyAllapot()
        {
                if($this->_params["ChkAktiv"]->_value!=1)
                {
                        return "<span class='ui-icon ui-icon-alert tip' title='<strong>Nem jelenik meg.</strong> A telephely nem publikus!'></span>";
                }
                return "<span class='ui-icon ui-icon-circle-check tip' title='<strong>Megjelenik.</strong>'></span>";
        }
        
}