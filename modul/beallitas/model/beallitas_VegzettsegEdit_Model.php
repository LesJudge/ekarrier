<?php
class Beallitas_VegzettsegEdit_Model extends Admin_Edit_Model
{

        public $_tableName='vegzettseg';
        public $_bindArray=array(
                'nev'=>'TxtNev',
                'vegzettseg_aktiv'=>'ChkAktiv',
        );

        public function __addForm()
        {
                parent::__addForm();
                // Név
                $this->addItem('TxtNev')->_verify['string']=true;
        }

    /**
     * Nyelv ellenőrzés felülírása, kikerülése. Erre azért van szükség, mert a táblában nincs nyelv_id mező.
     * @param string $nyelv
     * @return boolean
     */
    public function verifyRow($nyelv = "")
    {
        return true;
    }

        public function __editData()
        {
                parent::__editData();
                $query="SELECT modositas_szama, 
                                            DATE_FORMAT(letrehozas_timestamp,'%Y-%m-%d %H:%i') AS letrehozas_timestamp, 
                                            DATE_FORMAT(modositas_timestamp,'%Y-%m-%d %H:%i') AS modositas_timestamp, 
                                            u1.user_fnev AS letrehozo_id, 
                                            u2.user_fnev AS modosito_id
                               FROM {$this->_tableName}
                               LEFT JOIN user AS u1 ON letrehozo_id=u1.user_id
                               LEFT JOIN user AS u2 ON modosito_id=u2.user_id
                               WHERE vegzettseg_id='{$this->modifyID}' 
                               LIMIT 1";
                $data=$this->_DB->prepare($query)->query_select()->query_fetch_array();
                return $data;
        }

        public function __update()
        {
                parent::__update(',modositas_timestamp=now()
                                              ,modositas_szama=modositas_szama+1
                                              ,modosito_id='.UserLoginOut_Controller::$_id
                );
        }

        public function __insert()
        {
                parent::__insert(',letrehozo_id='.UserLoginOut_Controller::$_id);
        }

        public function vegzettsegAllapot()
        {
                if($this->_params["ChkAktiv"]->_value!=1)
                {
                        return "<span class='ui-icon ui-icon-alert tip' title='<strong>Nem jelenik meg.</strong> Az iskolai végzettség nem publikus!'></span>";
                }
                return "<span class='ui-icon ui-icon-circle-check tip' title='<strong>Megjelenik.</strong>'></span>";
        }

}