<?php
class Beallitas_AllashirdetesElonyEdit_Model extends Admin_Edit_Model
{

        public $_tableName='allashirdetes_elony';
        public $_bindArray=array(
                'allashirdetes_elony_nev'=>'TxtNev',
                'allashirdetes_elony_aktiv'=>'ChkAktiv',
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
                $query="SELECT allashirdetes_elony_modositas_szama, 
                                            DATE_FORMAT(allashirdetes_elony_letrehozas_datum,'%Y-%m-%d %H:%i') AS allashirdetes_elony_create_date, 
                                            DATE_FORMAT(allashirdetes_elony_modositas_datum,'%Y-%m-%d %H:%i') AS allashirdetes_elony_modositas_datum, 
                                            u1.user_fnev AS allashirdetes_elony_letrehozo, 
                                            u2.user_fnev AS allashirdetes_elony_modosito
                               FROM {$this->_tableName}
                               LEFT JOIN user AS u1 ON allashirdetes_elony_letrehozo=u1.user_id
                               LEFT JOIN user AS u2 ON allashirdetes_elony_modosito=u2.user_id
                               WHERE allashirdetes_elony_id='{$this->modifyID}' AND 
                                            allashirdetes_elony.nyelv_id='{$this->nyelvID}'
                               LIMIT 1";
                $data=$this->_DB->prepare($query)->query_select()->query_fetch_array();
                return $data;
        }

        public function __update()
        {
                parent::__update(',allashirdetes_elony_modositas_datum=now()
                                              ,allashirdetes_elony_modositas_szama=allashirdetes_elony_modositas_szama+1
                                              ,allashirdetes_elony_modosito='.UserLoginOut_Controller::$_id
                );
        }

        public function __insert()
        {
                parent::__insert(',allashirdetes_elony_letrehozo='.UserLoginOut_Controller::$_id);
        }

        public function allashirdetesElonyAllapot()
        {
                if($this->_params["ChkAktiv"]->_value!=1)
                {
                        return "<span class='ui-icon ui-icon-alert tip' title='<strong>Nem jelenik meg.</strong> Az iskolai végzettség nem publikus!'></span>";
                }
                return "<span class='ui-icon ui-icon-circle-check tip' title='<strong>Megjelenik.</strong>'></span>";
        }

}