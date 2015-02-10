<?php
class Beallitas_AlkalmazottiviszonyEdit_Model extends Admin_Edit_Model
{

        public $_tableName='alkalmazottiviszony';
        public $_bindArray=array(
                'alkalmazottiviszony_nev'=>'TxtNev',
                'alkalmazottiviszony_aktiv'=>'ChkAktiv',
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
                $query="SELECT alkalmazottiviszony_javitas_szama, 
                                            DATE_FORMAT(alkalmazottiviszony_create_date,'%Y-%m-%d %H:%i') AS alkalmazottiviszony_create_date, 
                                            DATE_FORMAT(alkalmazottiviszony_modositas_datum,'%Y-%m-%d %H:%i') AS alkalmazottiviszony_modositas_datum, 
                                            u1.user_fnev AS alkalmazottiviszony_letrehozo, 
                                            u2.user_fnev AS alkalmazottiviszony_modosito
                               FROM {$this->_tableName}
                               LEFT JOIN user AS u1 ON alkalmazottiviszony_letrehozo=u1.user_id
                               LEFT JOIN user AS u2 ON alkalmazottiviszony_modosito=u2.user_id
                               WHERE alkalmazottiviszony_id='{$this->modifyID}' AND 
                                            alkalmazottiviszony.nyelv_id='{$this->nyelvID}'
                               LIMIT 1";
                $data=$this->_DB->prepare($query)->query_select()->query_fetch_array();
                return $data;
        }

        public function __update()
        {
                parent::__update(',alkalmazottiviszony_modositas_datum=now()
                                              ,alkalmazottiviszony_javitas_szama=alkalmazottiviszony_javitas_szama+1
                                              ,alkalmazottiviszony_modosito='.UserLoginOut_Controller::$_id
                );
        }

        public function __insert()
        {
                parent::__insert(',alkalmazottiviszony_letrehozo='.UserLoginOut_Controller::$_id);
        }

        public function alkalmazottiviszonyAllapot()
        {
                if($this->_params["ChkAktiv"]->_value!=1)
                {
                        return "<span class='ui-icon ui-icon-alert tip' title='<strong>Nem jelenik meg.</strong> Az iskolai végzettség nem publikus!'></span>";
                }
                return "<span class='ui-icon ui-icon-circle-check tip' title='<strong>Megjelenik.</strong>'></span>";
        }

}