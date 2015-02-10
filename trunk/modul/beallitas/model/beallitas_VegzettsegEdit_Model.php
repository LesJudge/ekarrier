<?php
class Beallitas_VegzettsegEdit_Model extends Admin_Edit_Model
{

        public $_tableName='vegzettseg';
        public $_bindArray=array(
                'vegzettseg_nev'=>'TxtNev',
                'vegzettseg_aktiv'=>'ChkAktiv',
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
                $query="SELECT vegzettseg_javitas_szama, 
                                            DATE_FORMAT(vegzettseg_create_date,'%Y-%m-%d %H:%i') AS vegzettseg_create_date, 
                                            DATE_FORMAT(vegzettseg_modositas_datum,'%Y-%m-%d %H:%i') AS vegzettseg_modositas_datum, 
                                            u1.user_fnev AS vegzettseg_letrehozo, 
                                            u2.user_fnev AS vegzettseg_modosito
                               FROM {$this->_tableName}
                               LEFT JOIN user AS u1 ON vegzettseg_letrehozo=u1.user_id
                               LEFT JOIN user AS u2 ON vegzettseg_modosito=u2.user_id
                               WHERE vegzettseg_id='{$this->modifyID}' AND 
                                            vegzettseg.nyelv_id='{$this->nyelvID}'
                               LIMIT 1";
                $data=$this->_DB->prepare($query)->query_select()->query_fetch_array();
                return $data;
        }

        public function __update()
        {
                parent::__update(',vegzettseg_modositas_datum=now()
                                              ,vegzettseg_javitas_szama=vegzettseg_javitas_szama+1
                                              ,vegzettseg_modosito='.UserLoginOut_Controller::$_id
                );
        }

        public function __insert()
        {
                parent::__insert(',vegzettseg_letrehozo='.UserLoginOut_Controller::$_id);
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