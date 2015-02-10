<?php
class Munkavallalo_Vegzettseg_Edit_Model extends Page_Edit_Model
{
        
        public $_tableName='user_attr_vegzettseg';
        public $_bindArray=array(
                'vegzettseg_id'=>'SelVegzettseg',
                'user_attr_vegzettseg_iskola'=>'TxtIskola',
                'user_attr_vegzettseg_kezdet'=>'YearKezdet',
                'user_attr_vegzettseg_veg'=>'YearVeg',
                'user_attr_vegzettseg_szak'=>'TxtSzak',
                'user_attr_vegzettseg_aktiv'=>'ChkAktiv'
        );
        
        public function __addForm()
        {
                parent::__addForm();
                $yearVerify=array(
                        'pattern'=>'/^[0-9]{4}$/',
                        'value'=>true,
                        'message'=>'Valós évszámot adjon meg!'
                );
                // Végzettség
                $vegzettseg=$this->addItem('SelVegzettseg');
                $vegzettseg->_verify['select']=true;
                $vegzettseg->_select_value=$this->getSelectValues(
                        'vegzettseg',
                        'vegzettseg_nev',
                        ' AND vegzettseg_aktiv=1 AND vegzettseg_torolt=0',
                        ' ORDER BY vegzettseg_nev ASC',
                        true,
                        array(''=>'--Kérem, válasszon!--')
                );
                // Iskola
                $iskola=$this->addItem('TxtIskola');
                $iskola->_verify['string']=true;
                // Kezdet
                $kezdet=$this->addItem('YearKezdet');
                $kezdet->_verify['pattern']=$yearVerify;
                // Vég
                $veg=$this->addItem('YearVeg');
                $veg->_verify['pattern']=$yearVerify;
                // Szak
                $szak=$this->addItem('TxtSzak');
                // Publikus
                $public=$this->addItem('ChkAktiv');
                $public->_select_value=Rimo::$_config->AktivSelectValues[Rimo::$_config->ADMIN_NYELV_ID];
        }
        
        /**
         * Eredeti __formValues() metódus felüldeklarálása.
         */
        public function __formValues()
        {
                $query="SELECT ".Create::query_load_sets($this->_bindArray)."
                               FROM {$this->_tableName}
                               WHERE {$this->_tableName}_id=".(int)$this->modifyID." AND
                                            nyelv_id=".Rimo::$_config->SITE_NYELV_ID." AND
                                            user_id=".(int)UserLoginOut_Site_Controller::$_id."
                               LIMIT 1";
                $data=$this->_DB->prepare($query)->query_select()->query_fetch_array();
                foreach ($this->_bindArray as $field => $item)
                {
                        $this->getItemObject($item,'loadData')->_value = $data[$field];
                }
        }
        
        /**
         * Új rekord felvitele.
         */
        public function __insert()
        {
                $userId=(int)UserLoginOut_Site_Controller::$_id;
                parent::__insert(',user_id='.$userId.'
                                            ,user_attr_vegzettseg_letrehozo='.$userId);
        }
        
        /**
         * Rekord módosítása.
         */
        public function __update()
        {
                parent::__update(',user_attr_vegzettseg_modosito='.(int)UserLoginOut_Site_Controller::$_id.'
                                              ,user_attr_vegzettseg_modositas_datum=NOW()
                                              ,user_attr_vegzettseg_modositas_szama=user_attr_vegzettseg_modositas_szama+1');
        }
        
}