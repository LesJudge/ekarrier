<?php
class Beallitas_IparagEdit_Model extends Admin_Edit_Model
{

        public $_tableName='iparag';
        public $_bindArray=array(
                'iparag_nev'=>'TxtNev',
                'iparag_aktiv'=>'ChkAktiv',
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
                $query="SELECT iparag_javitas_szama, 
                                            DATE_FORMAT(iparag_create_date,'%Y-%m-%d %H:%i') AS iparag_create_date, 
                                            DATE_FORMAT(iparag_modositas_datum,'%Y-%m-%d %H:%i') AS iparag_modositas_datum, 
                                            u1.user_fnev AS iparag_letrehozo, 
                                            u2.user_fnev AS iparag_modosito
                               FROM {$this->_tableName}
                               LEFT JOIN user AS u1 ON iparag_letrehozo=u1.user_id
                               LEFT JOIN user AS u2 ON iparag_modosito=u2.user_id
                               WHERE iparag_id='{$this->modifyID}' AND 
                                            iparag.nyelv_id='{$this->nyelvID}'
                               LIMIT 1";
                $data=$this->_DB->prepare($query)->query_select()->query_fetch_array();
                return $data;
        }

        public function __update()
        {
                parent::__update(',iparag_modositas_datum=now()
                                              ,iparag_javitas_szama=iparag_javitas_szama+1
                                              ,iparag_modosito='.UserLoginOut_Controller::$_id
                );
        }

        public function __insert()
        {
                parent::__insert(',iparag_letrehozo='.UserLoginOut_Controller::$_id);
        }

        public function iparagAllapot()
        {
                if($this->_params["ChkAktiv"]->_value!=1)
                {
                        return "<span class='ui-icon ui-icon-alert tip' title='<strong>Nem jelenik meg.</strong> Az iskolai végzettség nem publikus!'></span>";
                }
                return "<span class='ui-icon ui-icon-circle-check tip' title='<strong>Megjelenik.</strong>'></span>";
        }

}