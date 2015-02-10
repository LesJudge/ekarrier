<?php
class Sugo_Edit_Model extends Admin_Edit_Model
{

        public $_tableName='sugo';
        public $_bindArray=array(
                'sugo_nev'=>'TxtNev',
                'sugo_tartalom'=>'TxtTartalom',
                'sugo_aktiv'=>'ChkAktiv',
        );

        public function __addForm()
        {
                parent::__addForm();
                // Név
                $this->addItem('TxtNev')->_verify['string']=true;
                // Tartalom
                $this->addItem('TxtTartalom')->_verify['string']=true;
        }

        public function deleteMegtekintes()
        {
                $query="UPDATE {$this->_tableName} SET sugo_megtekintve=0
                              WHERE sugo_id='{$this->modifyID}' AND 
                                           nyelv_id='{$this->nyelvID}'
                              LIMIT 1";
                $this->_DB->prepare($query)->query_update();
        }

        public function __editData()
        {
                parent::__editData();
                $query="SELECT sugo_megtekintve,
                                            sugo_javitas_szama, 
                                            DATE_FORMAT(sugo_create_date,'%Y-%m-%d %H:%i') AS sugo_create_date, 
                                            DATE_FORMAT(sugo_modositas_datum,'%Y-%m-%d %H:%i') AS sugo_modositas_datum, 
                                            u1.user_fnev AS sugo_letrehozo, 
                                            u2.user_fnev AS sugo_modosito
                               FROM {$this->_tableName}
                               LEFT JOIN user AS u1 ON sugo_letrehozo=u1.user_id
                               LEFT JOIN user AS u2 ON sugo_modosito=u2.user_id
                               WHERE sugo_id='{$this->modifyID}' AND 
                                            sugo.nyelv_id='{$this->nyelvID}'
                               LIMIT 1";
                $data=$this->_DB->prepare($query)->query_select()->query_fetch_array();
                return $data;
        }

        public function __update()
        {
                parent::__update(',sugo_modositas_datum=now()
                                              ,sugo_javitas_szama=sugo_javitas_szama+1
                                              ,sugo_modosito='.UserLoginOut_Controller::$_id
                );
        }

        public function __insert()
        {
                parent::__insert(',sugo_letrehozo='.UserLoginOut_Controller::$_id);
        }



        public function sugoAllapot()
        {
                if($this->_params["ChkAktiv"]->_value!=1)
                {
                        return "<span class='ui-icon ui-icon-alert tip' title='<strong>Nem jelenik meg.</strong> A cég nem publikus!'></span>";
                }
                return "<span class='ui-icon ui-icon-circle-check tip' title='<strong>Megjelenik.</strong>'></span>";
        }

}