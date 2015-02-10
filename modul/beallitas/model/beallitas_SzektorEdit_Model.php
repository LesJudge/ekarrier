<?php
class Beallitas_SzektorEdit_Model extends Admin_Edit_Model
{

        public $_tableName='szektor';
        public $_bindArray=array(
                'szektor_nev'=>'TxtNev',
                'szektor_aktiv'=>'ChkAktiv',
        );

        public function __addForm()
        {
                parent::__addForm();
                // Név
                $this->addItem('TxtNev')->_verify['string']=true;
        }

        public function __editData()
        {
                parent::__editData();
                $query="SELECT szektor_javitas_szama, 
                                            DATE_FORMAT(szektor_create_date,'%Y-%m-%d %H:%i') AS szektor_create_date, 
                                            DATE_FORMAT(szektor_modositas_datum,'%Y-%m-%d %H:%i') AS szektor_modositas_datum, 
                                            u1.user_fnev AS szektor_letrehozo, 
                                            u2.user_fnev AS szektor_modosito
                               FROM {$this->_tableName}
                               LEFT JOIN user AS u1 ON szektor_letrehozo=u1.user_id
                               LEFT JOIN user AS u2 ON szektor_modosito=u2.user_id
                               WHERE szektor_id='{$this->modifyID}' AND 
                                            szektor.nyelv_id='{$this->nyelvID}'
                               LIMIT 1";
                $data=$this->_DB->prepare($query)->query_select()->query_fetch_array();
                return $data;
        }

        public function __update()
        {
                parent::__update(',szektor_modositas_datum=now()
                                              ,szektor_javitas_szama=szektor_javitas_szama+1
                                              ,szektor_modosito='.UserLoginOut_Controller::$_id
                );
        }

        public function __insert()
        {
                parent::__insert(',szektor_letrehozo='.UserLoginOut_Controller::$_id);
        }

        public function szektorAllapot()
        {
                if($this->_params["ChkAktiv"]->_value!=1)
                {
                        return "<span class='ui-icon ui-icon-alert tip' title='<strong>Nem jelenik meg.</strong> Az iskolai végzettség nem publikus!'></span>";
                }
                return "<span class='ui-icon ui-icon-circle-check tip' title='<strong>Megjelenik.</strong>'></span>";
        }

}